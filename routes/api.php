<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotegoriesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdsController;

Route::get('/categories', [CotegoriesController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/ads/category', [AdsController::class, 'byCategory']);
Route::get('/ads/featured', [AdsController::class, 'featured']);
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::post('/ads', [AdsController::class, 'store']);
});
