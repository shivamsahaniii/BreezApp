<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->middleware('IsUserValid');
    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
});
