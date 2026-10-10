<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị tất cả đơn hàng
    public function index()
    {
        // Sắp xếp theo 'id' giảm dần để tránh lỗi nếu CSDL không có cột 'created_at'
        $orders = Order::with('user')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with([
            'user',
            'details.product'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        // Dùng DB::table để update trực tiếp duy nhất cột 'status',
        // bỏ qua Eloquent Model nên KHÔNG bị dính lỗi thiếu cột 'updated_at'
        DB::table('orders')
            ->where('id', $id)
            ->update([
                'status' => $request->status
            ]);

        return redirect()
            ->route('admin.orders.show', $id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
    /**
     * Hiển thị trang in hóa đơn đơn hàng
     */
    public function printInvoice($id)
    {
        // Sử dụng đúng tên quan hệ 'details' đã khai báo trong Order.php
        $order = Order::with(['user', 'details.product'])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }
}