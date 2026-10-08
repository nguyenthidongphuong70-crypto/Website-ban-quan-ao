<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Đã đăng nhập nhưng không phải admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập trang quản trị.');
        }

        // Là admin thì cho đi tiếp
        return $next($request);
    }
}

        // Đã đăng nhập nhưng không phải admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập trang quản trị.');
        }

        // Là admin thì cho đi tiếp
        return $next($request);
    }
}
