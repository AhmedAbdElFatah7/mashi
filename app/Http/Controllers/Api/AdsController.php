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
						$path = 'storage/'.ltrim($path, '/');
					}

					return asset($path);
				}, $images);

				$ad->images = $images;
				return $ad;
			});

		return response()->json($ads);
	}
}
