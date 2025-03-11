<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProducteController;

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

// Productes
Route::get('/productes', [ProducteController::class, 'index']);
Route::post('/productes', [ProducteController::class, 'store']);
Route::get('/productes/{id}', [ProducteController::class, 'show']);
Route::put('/productes/{id}', [ProducteController::class, 'update']);
Route::delete('/productes/{id}', [ProducteController::class, 'destroy']);

// Categories
Route::get('/categories', [CategoriaController::class, 'index']);
Route::post('/categories', [CategoriaController::class, 'store']);
Route::get('/categories/{id}', [CategoriaController::class, 'show']);
Route::put('/categories/{id}', [CategoriaController::class, 'update']);
Route::delete('/categories/{id}', [CategoriaController::class, 'destroy']);
