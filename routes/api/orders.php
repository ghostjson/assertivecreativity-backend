<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;



Route::post('', [OrderController::class, 'store']);
