<?php

use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\WishlistController;
use App\Http\Controllers\Thread\ThreadController;
use Illuminate\Support\Facades\Route;



Route::post('', [OrderController::class, 'store']);

// wishlist
Route::post('wishlist', [WishlistController::class, 'store']);
Route::get('wishlist', [WishlistController::class, 'index']);
Route::delete('wishlist/{product}', [WishlistController::class, 'destroy']);
Route::delete('wishlist', [WishlistController::class, 'clear']);


// THREADS

Route::post('thread', [ThreadController::class, 'send']);
