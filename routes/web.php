<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ---------- Halaman pelanggan (HomeLayout) ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/produk/{product:slug}', [HomeController::class, 'detail'])->name('produk.detail');
Route::get('/checkout/{product:slug}', [HomeController::class, 'checkout'])->name('checkout');
Route::post('/pesan', [HomeController::class, 'pesan'])->name('pesan');
Route::get('/pesanan/{code}', [HomeController::class, 'sukses'])->name('pesanan.sukses');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');

// ---------- Login ----------
Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// ---------- Backpage admin (AdminLayout) ----------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order:order_id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
