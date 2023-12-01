<?php

use App\Http\Controllers\User\StoreRentController;
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
    //User Store Rental storage-type-list
    Route::get('storage-type-list',[StoreRentController::class,'getStorageType']);
    Route::get('facility-filter-units',[StoreRentController::class,'filterFacilityUnit']);

    Route::post('logout', [AuthController::class, 'logout'])->name('user_logout');
});
