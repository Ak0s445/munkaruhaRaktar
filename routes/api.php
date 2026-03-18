<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LocationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    //Auth
    Route::post('/logout', [UserController::class, 'logout']);

    //My profile
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::put('/profile/password', [UserController::class, 'setPassword']);

    //Admin
    Route::get('/users', [UserController::class, 'getProfiles']);
    Route::put('/users/{user}/make-admin', [UserController::class, 'makeAdmin']);
    Route::put('/users/{user}/remove-admin', [UserController::class, 'removeAdmin']);
    Route::delete('/users/{user}', [UserController::class, 'deleteUser']);
    Route::put('/users/{user}/password', [UserController::class, 'setPasswordByAdmin']);
    Route::put('/users/{user}/profile', [UserController::class, 'updateProfileByAdmin']);

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

    //Location
    Route::get('/locations', [LocationController::class, 'getLocations']);
    Route::get('/locations/{location}', [LocationController::class, 'getLocation']);
    Route::post('/locations', [LocationController::class, 'create']);
    Route::put('/locations/{location}', [LocationController::class, 'update']);
    Route::delete('/locations/{location}', [LocationController::class, 'delete']);
});
