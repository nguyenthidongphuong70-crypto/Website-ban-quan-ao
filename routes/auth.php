<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - AUREN
|--------------------------------------------------------------------------
| Dùng backend Laravel Breeze cho:
| - Đăng ký
| - Đăng nhập
| - Đăng xuất
|
| Quên mật khẩu / OTP dùng flow riêng của project trong routes/web.php,
| nên KHÔNG khai báo route forgot-password/reset-password mặc định của Breeze ở đây.
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Đăng ký
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register.post');


    // Đăng nhập
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.post');
});


Route::middleware('auth')->group(function () {

    // Đăng xuất
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
