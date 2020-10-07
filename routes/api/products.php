<?php

use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;

//category
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::post('categories/{category}', [CategoryController::class, 'update']);
Route::get('categories/tags/{category}', [CategoryController::class, 'tags']);

//wishlist


//tag
Route::post('tag', [TagController::class, 'store']);
Route::post('tag/{tag}', [TagController::class, 'update']);
Route::get('tag/{tag}', [TagController::class, 'show']);
Route::get('tag/name/{name}', [TagController::class, 'showByName']);

//search
Route::get('search/{search}', [ProductController::class, 'productSearch']);

//product crud


Route::get('', [ProductController::class, 'index']);
Route::post('', [ProductController::class, 'store']);
Route::get('{product}', [ProductController::class, 'show']);
Route::delete('{product}', [ProductController::class, 'destroy']);
Route::post('{product}', [ProductController::class, 'update']);
