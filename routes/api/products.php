<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//product crud
Route::get('', [ProductController::class, 'index']);
Route::post('', [ProductController::class, 'store']);
Route::get('{product}', [ProductController::class, 'show']);
Route::delete('{product}', [ProductController::class, 'destroy']);
Route::post('{product}', [ProductController::class, 'update']);

//search
Route::get('search/{search}', [ProductController::class, 'productSearch']);


//category

Route::post('categories/create', [ProductController::class, 'storeCategory']);
Route::post('categories', [ProductController::class, 'storeCategory']);
Route::get('categories/get', [ProductController::class, 'getAllCategory']);
Route::get('categories/{category}', [ProductController::class, 'getByCategoryID']);
Route::post('categories/{category}', [ProductController::class, 'updateCategory']);
Route::get('categories/tags/{category}', [ProductController::class, 'getTagsAssociatedWithCategory']);

//tag
Route::post('tag', [ProductController::class, 'storeTag']);
Route::post('tag/{tag}', [ProductController::class, 'updateTag']);
Route::get('tag/{tag}', [ProductController::class, 'getByTagID']);
Route::get('tag/name/{name}', [ProductController::class, 'getByTagName']);

