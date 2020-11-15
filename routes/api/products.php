<?php

use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;

//category
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories/list', [CategoryController::class, 'getProductByCategories']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::post('categories/{category}', [CategoryController::class, 'update']);
Route::get('categories/tags/{category}', [CategoryController::class, 'tags']);
Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

//wishlist


//tag
Route::post('tags', [TagController::class, 'store']);
Route::post('tags/{tag}', [TagController::class, 'update']);
Route::get('tags/{tag}', [TagController::class, 'show']);
Route::get('tags/name/{name}', [TagController::class, 'showByName']);
Route::get('tags', [TagController::class, 'index']);
Route::delete('tags/{tag}', [TagController::class, 'destroy']);

//search
Route::get('search/{search}', [ProductController::class, 'productSearch']);

//product crud


Route::get('', [ProductController::class, 'index']);
Route::get('/vendor', [ProductController::class, 'indexVendor']);
Route::post('', [ProductController::class, 'store']);
Route::get('{product}', [ProductController::class, 'show']);
Route::delete('{product}', [ProductController::class, 'destroy']);
Route::post('{product}', [ProductController::class, 'update']);
