<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//product crud
Route::get('', [ProductController::class, 'index']);
Route::post('', [ProductController::class, 'store']);
Route::get('{product}', [ProductController::class, 'show']);
Route::delete('{product}', [ProductController::class, 'destroy']);
Route::patch('{product}', [ProductController::class, 'update']);

//search
Route::get('search/{search}', [ProductController::class, 'productSearch']);


//category
Route::get('category/{category}', [ProductController::class, 'getByCategoryID']);

//tag
Route::get('tag/{tag}', [ProductController::class, 'getByTagID']);
Route::get('tag/name/{name}', [ProductController::class, 'getByTagName']);

