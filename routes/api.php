<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CotegoriesController;

Route::get('/categories', [CotegoriesController::class, 'index']);
