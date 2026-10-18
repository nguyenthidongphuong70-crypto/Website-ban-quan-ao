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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MomoController;

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
| GIỎ HÀNG / ĐẶT HÀNG
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/products/{product}/cart', [CartController::class, 'store'])->name('cart.store');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');

    Route::post('/checkout/momo', [MomoController::class, 'createPayment'])->name('momo.payment');
    Route::get('/momo/return', [MomoController::class, 'returnPayment'])->name('momo.return');
    Route::post('/momo/ipn', [MomoController::class, 'ipn'])->name('momo.ipn');
    
    Route::get('/checkout/success/{id}', [OrderController::class, 'success'])->name('orders.success');
    

    Route::match(['put', 'patch'], '/cart/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/order/success/{id}', [CheckoutController::class, 'showSuccess'])->name('order.success');   
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('orders.history');
    
    
});
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
| Chỉ tài khoản đã đăng nhập mới được truy cập (phân quyền check trong Controller)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        // Dashboard & Xuất báo cáo (Excel / PDF)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/export-excel', [DashboardController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [DashboardController::class, 'exportPdf'])->name('export.pdf');

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

        // Danh sách đơn hàng
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        // Chi tiết đơn hàng
        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');
            // ROUTE IN HÓA ĐƠN TRỰC TIẾP
        Route::get('/orders/{id}/print', [OrderController::class, 'printInvoice'])
            ->name('orders.print');

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