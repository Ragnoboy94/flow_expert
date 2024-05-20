<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Profile\UserProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CustomerController;

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
    Route::get('/files', [UploadController::class, 'index']);
    Route::post('/files', [UploadController::class, 'index']);
    Route::post('/split-lots', [LotController::class, 'splitLots']);
    Route::get('/files/{fileId}/rows', [LotController::class, 'getExcelRows']);
    Route::post('/uploadOfferFile', [OfferController::class, 'store']);
    Route::get('/offers', [OfferController::class, 'index']);
    Route::put('/medicine-rows/{id}', [OfferController::class, 'update']);
    Route::get('/customer', [CustomerController::class, 'getCustomer']);
    Route::post('/customer', [CustomerController::class, 'updateCustomer']);
});
