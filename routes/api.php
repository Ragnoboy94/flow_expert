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
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\NMCKController;
use App\Http\Controllers\FileGenerationController;

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
    Route::get('/regions', [CustomerController::class, 'getRegion']);
    Route::post('/customer/additional', [CustomerController::class, 'updateAdditionalData']);
    Route::delete('/delete-demand/{fileId}', [DeleteController::class, 'deleteDemand']);
    Route::delete('/delete-offer/{fileId}', [DeleteController::class, 'deleteOffer']);
    Route::post('/save-data', [NMCKController::class, 'storeData']);
    Route::get('/get-data', [NMCKController::class, 'getData']);
    Route::post('/save-monthly-periodic-data', [NmckController::class, 'saveMonthlyAndPeriodicData']);
    Route::put('/files/{fileId}/rows', [LotController::class, 'updateExcelRows']);
    Route::get('/drug-categories', [LotController::class, 'categoryList']);
    Route::get('/files/{fileId}/category/{categoryId}/download', [FileGenerationController::class, 'download']);
    Route::get('/nmck-files', [NmckController::class, 'getNmckFiles']);
});
