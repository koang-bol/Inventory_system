<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

// Guest Routes (Accessible when logged OUT)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Protected Routes (Accessible ONLY when logged IN)
Route::middleware('auth')->group(function () {

    // === PUT IT RIGHT HERE ===
    Route::get('/', [ProductController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Product Routes
    Route::resource('products', ProductController::class);

    // Stock Movement Routes
    Route::get('stock/logs', [StockController::class, 'index'])->name('stock.index');
    Route::get('stock/in', [StockController::class, 'showStockInForm'])->name('stock.in.form');
    Route::post('stock/in', [StockController::class, 'processStockIn'])->name('stock.in.process');
    Route::get('stock/out', [StockController::class, 'showStockOutForm'])->name('stock.out.form');
    Route::post('stock/out', [StockController::class, 'processStockOut'])->name('stock.out.process');
});