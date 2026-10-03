<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/products', [
    ProductController::class,
    'index',
])->name('products.index');

Route::get('/products/{product}', [
    ProductController::class,
    'show',
])->name('products.show');


//(Người 1)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
});