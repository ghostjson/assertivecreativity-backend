<?php

use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register/user', [AuthController::class, 'registerUser']);
Route::post('register/vendor', [AuthController::class, 'registerVendor']);

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout']);

Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('user', [AuthController::class, 'user']);
