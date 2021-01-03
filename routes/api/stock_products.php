<?php


use App\Http\Controllers\StockProduct\StockProductController;
use Illuminate\Support\Facades\Route;

Route::post('excel', [StockProductController::class, 'import']);
Route::get('', [StockProductController::class, 'index']);
Route::get('{product}', [StockProductController::class, 'show']);
Route::post('{product}/updated', [StockProductController::class, 'showUpdatedProduct']);
