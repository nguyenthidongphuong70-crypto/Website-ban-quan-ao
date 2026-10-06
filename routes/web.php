<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;


/*
|--------------------------------------------------------------------------
| TRANG CHÍNH / SẢN PHẨM
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| HỒ SƠ CÁ NHÂN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    // Đổi mật khẩu
    Route::get(
        '/profile/change-password',
        [ProfileController::class, 'showChangePassword']
    )->name('profile.password.edit');

    Route::put(
        '/profile/change-password',
        [ProfileController::class, 'changePassword']
    )->name('profile.password.update');
});


/*
|--------------------------------------------------------------------------
| QUÊN MẬT KHẨU BẰNG OTP ẢO
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Trang nhập số điện thoại
    Route::get(
        '/forgot-password',
        [ForgotPasswordController::class, 'showPhoneForm']
    )->name('password.request');


    // Gửi OTP ảo
    Route::post(
        '/forgot-password/send-otp',
        [ForgotPasswordController::class, 'sendOtp']
    )
        ->middleware('throttle:3,1')
        ->name('password.otp.send');


    // Trang nhập OTP
    Route::get(
        '/forgot-password/verify-otp',
        [ForgotPasswordController::class, 'showOtpForm']
    )->name('password.otp.form');


    // Kiểm tra OTP
    Route::post(
        '/forgot-password/verify-otp',
        [ForgotPasswordController::class, 'verifyOtp']
    )
        ->middleware('throttle:10,1')
        ->name('password.otp.verify');


    // Trang nhập mật khẩu mới
    Route::get(
        '/forgot-password/reset',
        [ForgotPasswordController::class, 'showResetForm']
    )->name('password.reset.form');


    // Lưu mật khẩu mới
    Route::post(
        '/forgot-password/reset',
        [ForgotPasswordController::class, 'resetPassword']
    )->name('password.reset.phone');
});


/*
|--------------------------------------------------------------------------
| ĐĂNG NHẬP MẠNG XÃ HỘI
|--------------------------------------------------------------------------
*/

Route::get(
    '/auth/{provider}/redirect',
    [AuthController::class, 'redirectToProvider']
)->name('social.redirect');

Route::get(
    '/auth/{provider}/callback',
    [AuthController::class, 'handleProviderCallback']
)->name('social.callback');


/*
|--------------------------------------------------------------------------
| QUẢN TRỊ
|--------------------------------------------------------------------------
| Chỉ tài khoản đã đăng nhập + role admin mới được truy cập
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::resource(
            'categories',
            AdminCategoryController::class
        );

        Route::resource(
            'products',
            AdminProductController::class
        );
    });


/*
|--------------------------------------------------------------------------
| AUTH BREEZE
|--------------------------------------------------------------------------
| Login / Register / Logout
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';