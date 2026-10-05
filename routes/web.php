<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
    ->middleware('auth')
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



//(Người 1)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
});

// ==============================
// QUÊN MẬT KHẨU BẰNG OTP
// ==============================

Route::get(
    '/forgot-password',
    [ForgotPasswordController::class, 'showPhoneForm']
)->name('password.request');


Route::post(
    '/forgot-password/send-otp',
    [ForgotPasswordController::class, 'sendOtp']
)->middleware('throttle:3,1')
 ->name('password.otp.send');


Route::get(
    '/forgot-password/verify-otp',
    [ForgotPasswordController::class, 'showOtpForm']
)->name('password.otp.form');


Route::post(
    '/forgot-password/verify-otp',
    [ForgotPasswordController::class, 'verifyOtp']
)->middleware('throttle:10,1')
 ->name('password.otp.verify');


Route::get(
    '/forgot-password/reset',
    [ForgotPasswordController::class, 'showResetForm']
)->name('password.reset.form');


Route::post(
    '/forgot-password/reset',
    [ForgotPasswordController::class, 'resetPassword']
)->name('password.reset.phone');
