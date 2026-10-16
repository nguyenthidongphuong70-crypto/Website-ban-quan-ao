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
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

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
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order = Order::with('orderDetails.product')->findOrFail($id);

        $oldStatus = $order->status;
        $newStatus = $request->input('status');

        DB::beginTransaction();

        try {
            // Hủy đơn: hoàn lại số lượng tồn kho
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product;

                    if ($product) {
                        $product->stock += $detail->quantity;
                        $product->save();
                    }
                }
            }

            // Khôi phục đơn đã hủy: trừ lại tồn kho
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->orderDetails as $detail) {
                    $product = $detail->product;

                    if ($product) {
                        if ($product->stock < $detail->quantity) {
                            throw new \Exception(
                                'Không đủ tồn kho để khôi phục đơn hàng.'
                            );
                        }

                        $product->stock -= $detail->quantity;
                        $product->save();
                    }
                }
            }

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
