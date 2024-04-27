<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InquiryController;

//Auth
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');;
Route::post('/verify', [LoginController::class, 'verify']);
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/inquiries', [InquiryController::class, 'store']);
