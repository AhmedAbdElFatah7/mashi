<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotegoriesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdsController;
use App\Http\Controllers\Api\ProfileController;

Route::get('/categories', [CotegoriesController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/ads/category', [AdsController::class, 'byCategory']);
Route::get('/ads/featured', [AdsController::class, 'featured']);
Route::get('/ads/show', [AdsController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::get('/me', [AuthController::class, 'me']);
	Route::post('/ads', [AdsController::class, 'store']);
	Route::get('/favorites', [AdsController::class, 'favorites']);
	Route::post('/favorites', [AdsController::class, 'addToFavorites']);
	Route::post('/favorites/delete', [AdsController::class, 'removeFromFavorites']);

	// Profile routes
	Route::get('/profile', [ProfileController::class, 'show']);
	Route::post('/profile', [ProfileController::class, 'updateProfile']);
	Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
	Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
	Route::post('/profile/location', [ProfileController::class, 'updateLocation']);
});
