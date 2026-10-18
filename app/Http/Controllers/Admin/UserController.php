<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    // 1. Danh sách người dùng
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');

        if (!in_array($status, ['all', 'active', 'blocked'], true)) {
            $status = 'all';
        }

        $users = User::query()
            ->withCount('orders')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', function ($query) {
                $query->where('is_blocked', false);
            })
            ->when($status === 'blocked', function ($query) {
                $query->where('is_blocked', true);
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'search',
            'status'
        ));
    }

    // 2. Xem thông tin và đơn hàng của User
    public function show(User $user): View
    {
        $user->loadCount('orders');

        $orders = $user->orders()
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.users.show', compact(
            'user',
            'orders'
        ));
    }

    // 3. Khóa / mở khóa tài khoản
    public function setBlocked(
        Request $request,
        User $user
    ): RedirectResponse {

        $request->validate([
            'is_blocked' => ['required', 'boolean'],
        ]);

        // Không cho phép khóa Admin
        if ($user->isAdmin() || $user->is($request->user())) {
            return back()->with(
                'error',
                'Không được khóa tài khoản Admin.'
            );
        }

        $blocked = $request->boolean('is_blocked');

        $user->is_blocked = $blocked;
        $user->save();

        return back()->with(
            'success',
            $blocked
                ? 'Đã khóa tài khoản thành công.'
                : 'Đã mở khóa tài khoản thành công.'
        );
    }
}
