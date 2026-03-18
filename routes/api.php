<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;

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

    //Category
    Route::get('/categories', [CategoryController::class, 'getCategories']);
    Route::get('/categories/{category}', [CategoryController::class, 'getCategory']);
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'delete']);
});
