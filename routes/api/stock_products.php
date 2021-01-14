<?php


use App\Http\Controllers\StockProduct\StockProductController;
use Illuminate\Support\Facades\Route;


//categories
Route::get('/categories', [StockProductController::class, 'categories']);
Route::post('/categories', [StockProductController::class, 'getProductsByCategoryName']);

//search
Route::post('/search', [StockProductController::class, 'search']);

//variant
Route::get('/variant/{variant_id}', [StockProductController::class, 'getVariant']);

Route::post('excel', [StockProductController::class, 'import']);
Route::get('', [StockProductController::class, 'index']);
Route::get('{product}', [StockProductController::class, 'show']);
Route::post('{product}/updated', [StockProductController::class, 'showUpdatedProduct']);



