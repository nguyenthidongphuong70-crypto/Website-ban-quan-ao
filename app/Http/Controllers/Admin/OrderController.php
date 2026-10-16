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
        $orders = Order::with('user')->latest()->paginate(10);

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
        $order = Order::with('orderDetails.product')->findOrFail($id);

    $oldStatus = $order->status; // Trạng thái cũ trước khi đổi
    $newStatus = $request->input('status'); // Trạng thái mới từ form gửi lên

    DB::beginTransaction();
    try {
        // KIỂM TRA: Nếu trước đó chưa hủy, mà bây giờ chuyển sang hủy ('cancelled')
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    // Cộng lại stock số lượng đã mua
                    $product->stock += $detail->quantity;
                    $product->save();
                }
            }
        }

        // (Tùy chọn ngược lại): Nếu từ hủy mà đổi lại thành trạng thái khác (phòng hờ khôi phục đơn)
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    // Trừ lại stock
                    $product->stock = max(0, $product->stock - $detail->quantity);
                    $product->save();
                }
            }
        }

        // Cập nhật trạng thái mới cho đơn hàng
        $order->update([
            'status' => $newStatus,
            // các trường khác nếu có...
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
    }
    public function printInvoice($id)
    {
        // Sử dụng đúng tên quan hệ 'details' đã khai báo trong Order.php
        $order = Order::with(['user', 'details.product'])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
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
