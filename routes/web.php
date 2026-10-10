<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    Route::get(
        '/forgot-password',
        [ForgotPasswordController::class, 'showPhoneForm']
    )->name('password.request');

    Route::post(
        '/forgot-password/send-otp',
        [ForgotPasswordController::class, 'sendOtp']
    )->middleware('throttle:3,1')->name('password.otp.send');

    Route::get(
        '/forgot-password/verify-otp',
        [ForgotPasswordController::class, 'showOtpForm']
    )->name('password.otp.form');

    Route::post(
        '/forgot-password/verify-otp',
        [ForgotPasswordController::class, 'verifyOtp']
    )->middleware('throttle:10,1')->name('password.otp.verify');

    Route::get(
        '/forgot-password/reset',
        [ForgotPasswordController::class, 'showResetForm']
    )->name('password.reset.form');

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

        // Quản lý danh mục
        Route::resource(
            'categories',
            AdminCategoryController::class
        );

        // Quản lý sản phẩm
        Route::resource(
            'products',
            AdminProductController::class
        );

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        // Chi tiết đơn hàng
        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');

        // Cập nhật trạng thái đơn hàng
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });


/*
|--------------------------------------------------------------------------
| AUTH BREEZE
|--------------------------------------------------------------------------
| Login / Register / Logout
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
