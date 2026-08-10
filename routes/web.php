<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class)->except(['show']);

Route::get('products/{product}/stock-in', [StockController::class, 'createIn'])->name('stock.in');
Route::post('products/{product}/stock-in', [StockController::class, 'storeIn'])->name('stock.in.store');

Route::get('products/{product}/stock-out', [StockController::class, 'createOut'])->name('stock.out');
Route::post('products/{product}/stock-out', [StockController::class, 'storeOut'])->name('stock.out.store');

Route::get('stock', [StockController::class, 'index'])->name('stock.index');
