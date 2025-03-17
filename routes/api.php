<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProducteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetodePagamentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Usuaris
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/id/{id}', [UserController::class, 'show']);
    Route::get('/user/username', [UserController::class, 'getUserByUsername']);
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::put('/user/update-password', [UserController::class, 'updatePassword']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
});

// Productes
Route::get('/products', [ProducteController::class, 'index']);
Route::get('/products/{id}', [ProducteController::class, 'show']);

Route::middleware('auth:sanctum', 'checkVendorRole')->group(function () {
    Route::post('/products', [ProducteController::class, 'store']);
    Route::put('/products/{id}', [ProducteController::class, 'update'])->middleware('checkProductUserId');
    Route::delete('/products/{id}', [ProducteController::class, 'destroy'])->middleware('checkProductUserId');
});

// Categories
Route::get('/categories', [CategoriaController::class, 'index']);
Route::get('/categories/{id}', [CategoriaController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories', [CategoriaController::class, 'store']);
    Route::put('/categories/{id}', [CategoriaController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriaController::class, 'destroy']);
});

// Metode Pagament
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/metode_pagament/{id}', [MetodePagamentController::class, 'show']);
    Route::get('/metode_pagament/user/{usuari_id}', [MetodePagamentController::class, 'getByUserId']);
    Route::post('/metode_pagament', [MetodePagamentController::class, 'store']);
    Route::put('/metode_pagament/{id}', [MetodePagamentController::class, 'update']);
    Route::delete('/metode_pagament/{id}', [MetodePagamentController::class, 'destroy']);
});
