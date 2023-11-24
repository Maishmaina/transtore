<?php

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// AUTH ROUTES
Route::post('login', [AuthController::class, 'login'])->name('user_login');
Route::post('register', [AuthController::class, 'register'])->name('user_register');
Route::post('verify-account', [AuthController::class, 'verifyAccount'])->name('user_verify');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('user_pass_forgot');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('user_reset_password');

Route::middleware('auth:user_api')->group(function () {
    Route::get('user', function () {
        return new UserResource(request()->user());
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('user_logout');
});
