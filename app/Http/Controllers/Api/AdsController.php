<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

	public function byCategory($category_id)
	{
		$ads = Ad::where('category_id', $category_id)
			->latest()
			->get();

		return response()->json($ads);
	}
}
