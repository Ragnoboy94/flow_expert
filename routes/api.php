<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');;
Route::post('/verify', [LoginController::class, 'verify']);
Route::post('/register', [RegisterController::class, 'register']);
