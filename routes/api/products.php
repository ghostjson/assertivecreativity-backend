<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('', [ProductController::class, 'index']);

Route::post('', [ProductController::class, 'store']);

Route::get('{product}', [ProductController::class, 'show']);

Route::get('category/{category}', [ProductController::class, 'getByCategory']);

Route::delete('{product}', [ProductController::class, 'destroy']);
Route::patch('{product}', [ProductController::class, 'update']);
