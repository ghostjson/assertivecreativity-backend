<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;



Route::post('', [OrderController::class, 'store']);


// THREADS

Route::post('thread', [ThreadController::class, 'send']);
