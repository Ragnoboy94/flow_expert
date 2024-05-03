<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Profile\UserProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\UploadController;

//Auth
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
Route::post('/verify', [LoginController::class, 'verify']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/password/change', [PasswordController::class, 'change'])->middleware('auth:api');
Route::post('/password/forgot', [PasswordController::class, 'forgot']);

Route::post('/inquiries', [InquiryController::class, 'store']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'index']);
    Route::post('/profile/update', [UserProfileController::class, 'update']);
    Route::post('/upload', [UploadController::class, 'upload']);
});
