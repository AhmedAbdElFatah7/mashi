<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function register(RegisterRequest $request)
	{
		$data = $request->validated();

		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'phone' => $data['phone'],
			'password' => $data['password'],
			'role' => 'user',
		]);

		$token = $user->createToken('api-token')->plainTextToken;

		return response()->json([
			'user' => $user,
			'token' => $token,
		]);
	}

	public function login(LoginRequest $request)
	{
		$request->authenticate();

		$user = Auth::user();

		$token = $user->createToken('api-token')->plainTextToken;

		return response()->json([
			'user' => $user,
			'token' => $token,
		]);
	}

	public function logout(Request $request)
	{
		$user = $request->user();

		if ($user && $user->currentAccessToken()) {
			$user->currentAccessToken()->delete();
		}

		return response()->json([
			'message' => 'Logged out successfully',
		]);
	}

	public function me(Request $request)
	{
		return response()->json([
			'user' => $request->user(),
		]);
	}
}
