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
Route::get('/user/exists', [UserController::class, 'checkUserExists']);
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);
Route::put('/user/update-password', [UserController::class, 'updatePassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('checkAdminRole');
    Route::get('/user/username', [UserController::class, 'getUserByUsername'])->middleware('checkAdminRole');
    Route::put('/user/update/{id}', [UserController::class, 'adminUpdate'])->middleware('checkAdminRole');
    Route::get('/user/profile', [UserController::class, 'show']);
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::delete('/user/delete/{id}', [UserController::class, 'adminDestroy'])->middleware('checkAdminRole');
});

// Productes
Route::get('/products', [ProducteController::class, 'index']);
Route::get('/products/show/{id}', [ProducteController::class, 'show']);
Route::get('/products/category/{id}', [ProducteController::class, 'getByCategoryID']);
Route::get('/products/text', [ProducteController::class, 'getByText']);

Route::middleware('auth:sanctum', 'checkVendorRole')->group(function () {
    Route::post('/products', [ProducteController::class, 'store']);
    Route::put('/products/{id}', [ProducteController::class, 'update'])->middleware('checkProductUserId');
    Route::delete('/products/{id}', [ProducteController::class, 'destroy'])->middleware('checkProductUserId');
});

// Categories
Route::get('/categories', [CategoriaController::class, 'index']);
Route::get('/categories/{id}', [CategoriaController::class, 'show']);

Route::middleware(['auth:sanctum', 'checkAdminRole'])->group(function () {
    Route::post('/categories', [CategoriaController::class, 'store']);
    Route::put('/categories/{id}', [CategoriaController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriaController::class, 'destroy']);
});

// Metode Pagament
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/metode_pagament', [MetodePagamentController::class, 'getByUserId']);
    Route::get('/metode_pagament/{id}', [MetodePagamentController::class, 'show'])->middleware('paymentMethodUser');
    Route::post('/metode_pagament', [MetodePagamentController::class, 'store']);
    Route::put('/metode_pagament/{id}', [MetodePagamentController::class, 'update'])->middleware('paymentMethodUser');
    Route::delete('/metode_pagament/{id}', [MetodePagamentController::class, 'destroy'])->middleware('paymentMethodUser');
});
