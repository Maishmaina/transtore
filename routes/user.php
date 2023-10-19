<?php

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// AUTH ROUTES
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify-account', [AuthController::class, 'verifyAccount']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:user_api')->group(function () {
    Route::get('user', function () {
        return new UserResource(request()->user());
    });
    Route::post('logout', [AuthController::class, 'logout']);
});
