<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
// Pelanggan boleh membuat pesanan tanpa login
Route::post('/orders', [OrderController::class, 'store']);

// Wajib token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Produk: seluruh endpoint wajib token (sesuai modul BAB III)
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);

    // Nilai mahasiswa: GET /nilai, GET /nilai/{id}, POST /nilai
    Route::apiResource('nilai', NilaiController::class)->only(['index', 'show', 'store']);

    // Pesanan: hanya admin
    Route::middleware('admin')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    });
});
