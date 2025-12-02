<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdsController extends Controller
{
	public function store(Request $request)
	{
		$user = $request->user();

		if (! $user) {
			return response()->json([
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'category_id' => ['nullable', 'exists:categories,id'],
			'title' => ['required', 'string', 'max:255'],
			'description' => ['nullable', 'string'],
			'price' => ['nullable', 'numeric'],
			'type' => ['nullable', 'string', 'max:255'],
			'additional_info' => ['nullable', 'string'],
			'images' => ['nullable', 'array'],
			'images.*' => ['nullable', 'string'],
			'seller_name' => ['required', 'string', 'max:255'],
			'seller_phone' => ['required', 'string', 'max:255'],
			'allow_mobile_messages' => ['boolean'],
			'allow_whatsapp_messages' => ['boolean'],
			'fee_agree' => ['boolean'],
			'is_featured' => ['boolean'],
			'isNegotiable' => ['boolean'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$data = $validator->validated();
		$data['user_id'] = $user->id;

		$ad = Ad::create($data);

		return response()->json($ad, 201);
	}

	public function show(Request $request)
	{
		$ad = Ad::find($request->ad_id);
		if (!$ad) {
			return response()->json([
				'message' => 'Ad not found',
			], 404);
		}
		$ad->load(['user', 'category']);
		$images = $ad->images ?? [];
		if (is_string($images)) {
			$decoded = json_decode($images, true);
			if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
				$images = $decoded;
			} else {
				$images = [$images];
			}
		} elseif (! is_array($images)) {
			$images = [$images];
		}

		$images = array_map(function ($image) {
			if (! $image) {
				return $image;
			}

			$path = $image;

			if (Str::startsWith($path, 'public/')) {
				$path = substr($path, strlen('public/'));
			}

			if (! Str::startsWith($path, 'storage/')) {
				$path = 'storage/' . ltrim($path, '/');
			}

			return asset($path);
		}, $images);

		$ad->images = $images;

		return response()->json($ad);
	}

	public function byCategory(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category_id' => ['required', 'exists:categories,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}
		$ads = Ad::where('category_id', $request->category_id)
			->with('user')
			->latest()
			->get()
			->map(function ($ad) {
				$images = $ad->images ?? [];
				// Ensure images is always an array
				if (is_string($images)) {
					$decoded = json_decode($images, true);
					if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
						$images = $decoded;
					} else {
						$images = [$images];
					}
				} elseif (! is_array($images)) {
					$images = [$images];
				}

				$images = array_map(function ($image) {
					if (! $image) {
						return $image;
					}

					// Normalize path to match how categories build URLs
					$path = $image;

					// Remove leading "public/" if present
					if (Str::startsWith($path, 'public/')) {
						$path = substr($path, strlen('public/'));
					}

					// If already starts with "storage/", use as is, otherwise prefix it
					if (! Str::startsWith($path, 'storage/')) {
						$path = 'storage/' . ltrim($path, '/');
					}

					return asset($path);
				}, $images);

				$ad->images = $images;
				return $ad;
			});

		return response()->json($ads);
	}

	public function featured(Request $request)
	{
		$ads = Ad::where('is_featured', true)
			->inRandomOrder()
			->limit(12)
			->get()
			->map(function ($ad) {
				$images = $ad->images ?? [];
				if (is_string($images)) {
					$decoded = json_decode($images, true);
					if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
						$images = $decoded;
					} else {
						$images = [$images];
					}
				} elseif (! is_array($images)) {
					$images = [$images];
				}

				$images = array_map(function ($image) {
					if (! $image) {
						return $image;
					}

					$path = $image;

					if (Str::startsWith($path, 'public/')) {
						$path = substr($path, strlen('public/'));
					}

					if (! Str::startsWith($path, 'storage/')) {
						$path = 'storage/' . ltrim($path, '/');
					}

					return asset($path);
				}, $images);

				$ad->images = $images;
				return $ad;
			});

		return response()->json([
			'ads' => $ads,
		]);
	}

	public function addToFavorites(Request $request)
	{
		$user = $request->user();
		if (! $user) {
			return response()->json([
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'ad_id' => ['required', 'exists:ads,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$adId = $validator->validated()['ad_id'];
		$user->favoriteAds()->syncWithoutDetaching([$adId]);

		return response()->json([
			'message' => 'Added to favorites',
		]);
	}

	public function removeFromFavorites(Request $request)
	{
		$user = $request->user();
		if (! $user) {
			return response()->json([
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'ad_id' => ['required', 'exists:ads,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$adId = $validator->validated()['ad_id'];
		$user->favoriteAds()->detach($adId);

		return response()->json([
			'message' => 'Removed from favorites',
		]);
	}

	public function favorites(Request $request)
	{
		$user = $request->user();
		if (! $user) {
			return response()->json([
				'message' => 'Unauthenticated.',
			], 401);
		}

		$ads = $user->favoriteAds()
			->latest()
			->get()
			->map(function ($ad) {
				$images = $ad->images ?? [];
				if (is_string($images)) {
					$decoded = json_decode($images, true);
					if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
						$images = $decoded;
					} else {
						$images = [$images];
					}
				} elseif (! is_array($images)) {
					$images = [$images];
				}

				$images = array_map(function ($image) {
					if (! $image) {
						return $image;
					}

					$path = $image;

					if (Str::startsWith($path, 'public/')) {
						$path = substr($path, strlen('public/'));
					}

					if (! Str::startsWith($path, 'storage/')) {
						$path = 'storage/' . ltrim($path, '/');
					}

					return asset($path);
				}, $images);

				$ad->images = $images;
				return $ad;
			});

		return response()->json([
			'ads' => $ads,
		]);
	}

	public function addComment(Request $request)
	{
		$user = $request->user();
		if (!$user) {
			return response()->json([
				'status' => false,
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'ad_id' => ['required', 'exists:ads,id'],
			'comment' => ['required', 'string', 'max:1000'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$comment = \App\Models\Comment::create([
			'user_id' => $user->id,
			'ad_id' => $request->ad_id,
			'comment' => $request->comment,
		]);

		$comment->load('user');

		return response()->json([
			'status' => true,
			'message' => 'تم إضافة التعليق بنجاح',
			'data' => $comment,
		], 201);
	}

	public function getComments(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'ad_id' => ['required', 'exists:ads,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$user = $request->user();
		$comments = \App\Models\Comment::where('ad_id', $request->ad_id)
			->with('user')
			->withCount('likes')
			->latest()
			->get()
			->map(function ($comment) use ($user) {
				$comment->is_liked = $user ? $comment->isLikedBy($user->id) : false;
				return $comment;
			});

		return response()->json([
			'status' => true,
			'message' => 'Comments retrieved successfully',
			'data' => $comments,
		]);
	}

	public function likeComment(Request $request)
	{
		$user = $request->user();
		if (!$user) {
			return response()->json([
				'status' => false,
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'comment_id' => ['required', 'exists:comments,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$comment = \App\Models\Comment::find($request->comment_id);

		// Add like (syncWithoutDetaching prevents duplicates)
		$comment->likes()->syncWithoutDetaching([$user->id]);

		return response()->json([
			'status' => true,
			'message' => 'تم الإعجاب بالتعليق بنجاح',
			'data' => [
				'likes_count' => $comment->likes()->count(),
				'is_liked' => true,
			],
		]);
	}

	public function unlikeComment(Request $request)
	{
		$user = $request->user();
		if (!$user) {
			return response()->json([
				'status' => false,
				'message' => 'Unauthenticated.',
			], 401);
		}

		$validator = Validator::make($request->all(), [
			'comment_id' => ['required', 'exists:comments,id'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $validator->errors(),
			], 422);
		}

		$comment = \App\Models\Comment::find($request->comment_id);

		// Remove like
		$comment->likes()->detach($user->id);

		return response()->json([
			'status' => true,
			'message' => 'تم إلغاء الإعجاب بالتعليق',
			'data' => [
				'likes_count' => $comment->likes()->count(),
				'is_liked' => false,
			],
		]);
	}
}
