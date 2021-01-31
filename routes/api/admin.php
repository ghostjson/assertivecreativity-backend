<?php


use App\Http\Controllers\FileManager\FileManagerController;
use Illuminate\Support\Facades\Route;

//file manager
Route::post('/file', [FileManagerController::class, 'upload']);
