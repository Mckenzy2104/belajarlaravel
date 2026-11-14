<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[\App\Http\Controllers\ProductController::class,'index']);
Route::get('/products/create', [\App\Http\Controllers\ProductController::class, 'create']);
Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store']);
Route::put('/products/{product}', [\App\Http\Controllers\ProductController::class, 'update']);
Route::delete('/products/{product}', [\App\Http\Controllers\ProductController::class, 'destroy']);