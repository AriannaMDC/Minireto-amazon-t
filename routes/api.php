<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProducteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MetodePagamentController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\ValoracioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\EstadistiquesController;

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

// Usuaris
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);
Route::put('/user/update-password', [UserController::class, 'updatePassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/profile', [UserController::class, 'show']);
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::post('/user/config-update', [UserController::class, 'configUpdate']);
});

// Productes
Route::get('/products', [ProducteController::class, 'index']);
Route::get('/products/show/{id}', [ProducteController::class, 'show']);
Route::get('/products/category/{id}', [ProducteController::class, 'getByCategoryID']);
Route::get('/products/text', [ProducteController::class, 'getByText']);
Route::middleware('auth:sanctum')->get('/products/vendedor/{vendedor_id}/count', [ProducteController::class, 'getProductsCountByVendedor']);

Route::middleware('auth:sanctum', 'checkVendorRole')->group(function () {
    Route::post('/products', [ProducteController::class, 'store']);
    Route::put('/products/{id}', [ProducteController::class, 'update'])->middleware('checkProductUserId');
    Route::delete('/products/{id}', [ProducteController::class, 'destroy'])->middleware('checkProductUserId');
    Route::get('/products/vendedor', [ProducteController::class, 'getProductesVendedor']);
});

// Categories
Route::get('/categories', [CategoriaController::class, 'index']);
Route::get('/categories/{id}', [CategoriaController::class, 'show']);

// Metode Pagament
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/metode_pagament', [MetodePagamentController::class, 'getByUserId']);
    Route::get('/metode_pagament/{id}', [MetodePagamentController::class, 'show'])->middleware('paymentMethodUser');
    Route::post('/metode_pagament', [MetodePagamentController::class, 'store']);
    Route::put('/metode_pagament/{id}', [MetodePagamentController::class, 'update'])->middleware('paymentMethodUser');
    Route::delete('/metode_pagament/{id}', [MetodePagamentController::class, 'destroy'])->middleware('paymentMethodUser');
});

// Comentaris
Route::get('/comentaris/product/{productId}', [ComentariController::class, 'getAllByProductId']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comentaris', [ComentariController::class, 'store']);
    Route::put('/comentaris/{id}', [ComentariController::class, 'update'])->middleware('checkCommentUesrId');
    Route::put('/comentaris/{id}/increment_util', [ComentariController::class, 'updateUtil']);
    Route::delete('/comentaris/{id}', [ComentariController::class, 'destroy'])->middleware('checkCommentUesrId');
});

// Valoracions
Route::get('/valoracions/product/{productId}', [ValoracioController::class, 'getValoracioByProductId']);

// Carrito
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index']);
    Route::get('/carrito/historial', [CarritoController::class, 'getHistorialCompres']);
    Route::post('/carrito/producte', [CarritoController::class, 'addProducte']);
    Route::post('/carrito/incrementar/{liniaId}', [CarritoController::class, 'incrementQuantitat']);
    Route::post('/carrito/decrementar/{liniaId}', [CarritoController::class, 'decrementQuantitat']);
    Route::delete('/carrito/eliminar/{liniaId}', [CarritoController::class, 'removeProducte']);
    Route::delete('/carrito/buidar', [CarritoController::class, 'buidarCarrito']);
    Route::post('/carrito/completar', [CarritoController::class, 'completar']);
});

// Statistics routes
Route::middleware(['auth:sanctum', 'checkVendorRole'])->group(function () {
    Route::get('/estadistiques/productes-per-month', [EstadistiquesController::class, 'getProductesPerMonth']);
    Route::get('/estadistiques/compres-per-provincia', [EstadistiquesController::class, 'getCompresPerProvincia']);
    Route::get('/estadistiques/top-5-productes', [EstadistiquesController::class, 'getTop5Productes']);
    Route::get('/estadistiques/producte/{producteId}', [EstadistiquesController::class, 'getProducteStats']);
});

// ADMIN
Route::middleware(['auth:sanctum', 'checkAdminRole'])->group(function () {
    // User
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/username', [UserController::class, 'getUserByUsername']);
    Route::put('/user/update/{id}', [UserController::class, 'adminUpdate']);
    Route::delete('/user/delete/{id}', [UserController::class, 'adminDestroy']);

    // Categories
    Route::post('/categories', [CategoriaController::class, 'store']);
    Route::put('/categories/{id}', [CategoriaController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriaController::class, 'destroy']);
});
