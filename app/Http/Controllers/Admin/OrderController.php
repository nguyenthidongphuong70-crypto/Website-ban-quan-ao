<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng (hỗ trợ lọc theo trạng thái và tìm kiếm)
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Tìm kiếm theo ID đơn hàng hoặc Tên khách hàng
        if ($request->has('search') && $request->search != '') {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo trạng thái đơn hàng
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;

            // Xử lý linh hoạt hỗ trợ các biến thể trạng thái tương đương
            if ($status === 'confirmed') {
                $query->whereIn('status', ['confirmed', 'processing', 'Đang xử lý', 'Đã xác nhận']);
            } elseif ($status === 'shipping') {
                $query->whereIn('status', ['shipping', 'shipped', 'Đang giao', 'Đang giao hàng']);
            } elseif ($status === 'pending') {
                $query->whereIn('status', ['pending', 'Chờ xử lý']);
            } elseif ($status === 'completed') {
                $query->whereIn('status', ['completed', 'Hoàn thành', 'Đã hoàn thành']);
            } elseif ($status === 'cancelled') {
                $query->whereIn('status', ['cancelled', 'Đã hủy']);
            } else {
                $query->where('status', $status);
            }
        }

        $orders = $query->latest()->paginate(10)->appends($request->query());

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

    // Cập nhật trạng thái đơn hàng chuẩn bộ 5 giá trị tiếng Anh
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
        ]);

        $order = Order::with('orderDetails.product')->findOrFail($id);

        $oldStatus = $order->status;
        $newStatus = $request->input('status');

        DB::beginTransaction();

        try {
            // Hủy đơn: hoàn lại số lượng tồn kho sản phẩm
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product;

                    if ($product) {
                        $product->stock += $detail->quantity;
                        $product->save();
                    }
                }
            }

            // Khôi phục đơn đã hủy: trừ lại tồn kho sản phẩm
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product;

                    if ($product) {
                        if ($product->stock < $detail->quantity) {
                            throw new \Exception('Không đủ tồn kho để khôi phục đơn hàng.');
                        }

                        $product->stock -= $detail->quantity;
                        $product->save();
                    }
                }
            }

            // Cập nhật trạng thái mới
            $order->update([
                'status' => $newStatus,
            ]);

            DB::commit();

            return redirect()->back()->with(
                'success',
                'Cập nhật trạng thái đơn hàng thành công!'
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with(
                'error',
                'Lỗi: ' . $e->getMessage()
            );
        }
    }

    // Hiển thị trang in hóa đơn đơn hàng
    public function printInvoice($id)
    {
        $order = Order::with([
            'user',
            'details.product'
        ])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }
}