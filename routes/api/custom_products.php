<?php

use App\Http\Controllers\CustomProduct\CustomCategoryController;
use App\Http\Controllers\CustomProduct\CustomTagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomProduct\CustomProductController;

//category
Route::post('categories', [CustomCategoryController::class, 'store']);
Route::get('categories', [CustomCategoryController::class, 'index']);
Route::post('categories/list', [CustomCategoryController::class, 'getProductByCategories']);
Route::get('categories/tags/{category}', [CustomCategoryController::class, 'tags']);
Route::get('categories/{category}', [CustomCategoryController::class, 'show']);
Route::post('categories/{category}', [CustomCategoryController::class, 'update']);
Route::delete('categories/{category}', [CustomCategoryController::class, 'destroy']);

//wishlist


//tag
Route::post('tags', [CustomTagController::class, 'store']);
Route::post('tags/add', [CustomTagController::class, 'addTagsToProduct']);

Route::post('tags/{tag}', [CustomTagController::class, 'update']);
Route::get('tags/{tag}', [CustomTagController::class, 'show']);
Route::get('tags/name/{name}', [CustomTagController::class, 'showByName']);
Route::get('tags', [CustomTagController::class, 'index']);
Route::delete('tags/{tag}', [CustomTagController::class, 'destroy']);


//search
Route::get('search/{search}', [CustomProductController::class, 'productSearch']);

//product crud
Route::get('', [CustomProductController::class, 'index']);
Route::post('', [CustomProductController::class, 'store']);
Route::get('vendor', [CustomProductController::class, 'indexVendor']);
Route::get('{product}', [CustomProductController::class, 'show']);
Route::delete('{product}', [CustomProductController::class, 'destroy']);
Route::post('{product}', [CustomProductController::class, 'update']);
