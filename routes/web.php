<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
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
// Đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');


// Đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');


// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

});
Route::get(
    '/auth/{provider}/redirect',
    [AuthController::class, 'redirectToProvider']
)->name('social.redirect');


Route::get(
    '/auth/{provider}/callback',
    [AuthController::class, 'handleProviderCallback']
)->name('social.callback');