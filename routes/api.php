<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProducteController;
use App\Http\Controllers\UserController;

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
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::put('/user/update-password', [UserController::class, 'updatePassword']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});


Route::get('/user', [UserController::class, 'index']);
Route::get('/user/id/{id}', [UserController::class, 'show']);
Route::get('/user/username', [UserController::class, 'getUserByUsername']);

// Productes
Route::get('/products', [ProducteController::class, 'index']);
Route::get('/products/{id}', [ProducteController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProducteController::class, 'store']);
    Route::put('/products/{id}', [ProducteController::class, 'update']);
    Route::delete('/products/{id}', [ProducteController::class, 'destroy']);
});

// Categories
Route::get('/categories', [CategoriaController::class, 'index']);
Route::get('/categories/{id}', [CategoriaController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories', [CategoriaController::class, 'store']);
    Route::put('/categories/{id}', [CategoriaController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriaController::class, 'destroy']);
});
