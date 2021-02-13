<?php

use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\CustomWishlistController;
use App\Http\Controllers\Order\StockWishlistController;
use App\Http\Controllers\Thread\FormController;
use App\Http\Controllers\Thread\MessageController;
use App\Http\Controllers\Thread\ThreadController;
use Illuminate\Support\Facades\Route;





// custom wishlist
Route::post('wishlist/custom', [CustomWishlistController::class, 'store']);
Route::get('wishlist/custom', [CustomWishlistController::class, 'index']);
Route::get('wishlist/custom/{wishlist}', [CustomWishlistController::class, 'show']);
Route::delete('wishlist/custom/{wishlist}', [CustomWishlistController::class, 'destroy']);
Route::delete('wishlist/custom', [CustomWishlistController::class, 'clear']);

// stock wishlist
Route::post('wishlist/stock', [StockWishlistController::class, 'store']);
Route::get('wishlist/stock', [StockWishlistController::class, 'index']);
Route::get('wishlist/stock/{wishlist}', [StockWishlistController::class, 'show']);
Route::delete('wishlist/stock/{wishlist}', [StockWishlistController::class, 'destroy']);
Route::delete('wishlist/stock', [StockWishlistController::class, 'clear']);



// THREADS

Route::get('threads/order/{order}', [ThreadController::class, 'getThreadsByOrder']);
Route::get('threads/admin/order/{order}', [ThreadController::class, 'get']);
Route::get('threads', [ThreadController::class, 'getThreadsByCurrentUser']);
Route::get('threads/{thread}', [ThreadController::class, 'getThreadById']);
Route::post('threads/{user}', [ThreadController::class, 'send']);
Route::post('threads', [ThreadController::class, 'sendToAdmin']);

// Forms
    //Response
Route::get('forms/responses/{formResponse}', [FormController::class, 'getFormResponse']);
Route::post('forms/save', [FormController::class, 'saveFormResponse']);
Route::get('forms/{form}/responses', [FormController::class, 'getAllResponses']);

Route::get('forms', [FormController::class, 'index']);
Route::post('forms', [FormController::class, 'store']);
Route::get('forms/{form}', [FormController::class, 'show']);
Route::post('forms/{form}', [FormController::class, 'update']);
Route::delete('forms/{form}', [FormController::class, 'delete']);




// Message CRUD
Route::get('messages', [MessageController::class, 'index']);
Route::post('messages', [MessageController::class, 'store']);
Route::get('messages/{message}', [MessageController::class, 'show']);
Route::post('messages/{message}', [MessageController::class, 'update']);
Route::delete('messages/{message}', [MessageController::class, 'delete']);

// orders
Route::post('custom', [OrderController::class, 'storeCustom']);
Route::post('stock', [OrderController::class, 'storeStock']);
Route::get('', [OrderController::class, 'index']);
Route::get('vendor', [OrderController::class, 'indexVendor']);
Route::get('admin', [OrderController::class, 'indexAdmin']);
Route::get('{order}', [OrderController::class, 'show']);
