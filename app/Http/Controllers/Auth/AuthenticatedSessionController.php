<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị giao diện đăng nhập AUREN.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập bằng Laravel Breeze.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // LoginRequest sẽ kiểm tra email/SĐT + mật khẩu
        $request->authenticate();

        // Tạo session mới sau khi đăng nhập thành công
        $request->session()->regenerate();

        /** @var User|null $user */
        $user = Auth::user();

        // Admin -> trang quản trị
        if ($user && $user->isAdmin()) {
            return redirect()->intended(route('admin.products.index'));
        }

        // Customer -> trang sản phẩm AUREN
        return redirect()->intended(route('products.index'));
    }

    /**
     * Đăng xuất tài khoản.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('products.index');
    }
}
