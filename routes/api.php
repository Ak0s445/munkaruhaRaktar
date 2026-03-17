<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);

//Product
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'getProducts']);
    Route::get('/products/{product}', [ProductController::class, 'getProduct']);
    Route::post('/products', [ProductController::class, 'create']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'delete']);
});
