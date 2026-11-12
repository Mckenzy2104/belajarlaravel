<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[\App\Http\Controllers\ProductController::class,'index']);
Route::get('/products/create', [\App\Http\Controllers\ProductController::class, 'create']);
Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store']);