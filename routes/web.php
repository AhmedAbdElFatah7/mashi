<?php

use App\Http\Controllers\Dashboard\AdsController;
use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CotegoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('ads', AdsController::class);
        Route::delete('/ads/{ad}/image', [AdsController::class, 'deleteImage'])
            ->name('ads.delete-image');
        Route::get('/featured-ads', [AdsController::class, 'featured'])
            ->name('ads.featured');
            
        Route::resource('users', UsersController::class)->only(['index', 'show', 'create', 'store', 'destroy']);
        Route::patch('/users/{user}/password', [UsersController::class, 'updatePassword'])
            ->name('users.update-password');
        Route::patch('/users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])
            ->name('users.toggle-status');
            
        Route::resource('admins', AdminsController::class);
        Route::patch('/admins/{admin}/password', [AdminsController::class, 'updatePassword'])
            ->name('admins.update-password');
        Route::patch('/admins/{admin}/toggle-status', [AdminsController::class, 'toggleStatus'])
            ->name('admins.toggle-status');
            
        Route::resource('categories', CotegoriesController::class);
        Route::get('/categories/{category}/ads', [CotegoriesController::class, 'ads'])
            ->name('categories.ads');
            
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('dashboard.profile.index');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])
            ->name('dashboard.profile.updateProfile');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])
            ->name('dashboard.profile.updateAvatar');
        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])
            ->name('dashboard.profile.deleteAvatar');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('dashboard.profile.updatePassword');
            
        // Settings Routes
        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');
        Route::delete('/settings/logo', [SettingsController::class, 'deleteLogo'])
            ->name('settings.delete-logo');

        // About Us Settings
        Route::get('/settings/about-us', [SettingsController::class, 'aboutUs'])
            ->name('settings.about-us.index');
        Route::put('/settings/about-us', [SettingsController::class, 'updateAboutUs'])
            ->name('settings.about-us.update');
            
    });

require __DIR__.'/auth.php';
