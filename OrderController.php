<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Hiển thị trang nhập thông tin thanh toán (Checkout) kèm tổng tiền
    public function index()
    {
        $cartItems = CartItem::with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng tiền giỏ hàng
        $total = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price ?? $item->product->price ?? 0;
            return $item->quantity * $price;
        });

        // Trỏ view vào thư mục orders/checkout.blade.php (hoặc tạo file checkout riêng)
        return view('orders.checkout', compact('cartItems', 'total'));
    }

    // 2. Xử lý lưu thông tin người nhận và tạo đơn hàng vào CSDL
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào thông tin người nhận
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $cartItems = CartItem::with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        // Tính lại tổng tiền để đảm bảo chính xác
        $total = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price ?? $item->product->price ?? 0;
            return $item->quantity * $price;
        });

        // Sử dụng Transaction để đảm bảo an toàn dữ liệu
        DB::beginTransaction();
        try {
            // Tạo đơn hàng mới trong bảng orders
            $order = Order::create([
                'name'        => $request->name,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'note'        => $request->note,
                'total_price' => $total,
                'status'      => 'pending',
            ]);

            // Lưu chi tiết sản phẩm vào bảng order_details
            foreach ($cartItems as $item) {
                $price = $item->product->sale_price ?? $item->product->price ?? 0;
                
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $price,
                ]);
            }

            // Xóa sạch giỏ hàng sau khi đặt hàng thành công
            CartItem::truncate();

            DB::commit();

            // Chuyển hướng sang trang thông báo thành công
            return redirect()->route('orders.success', $order->id)
                             ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    // 3. Hiển thị trang thông báo thành công
    public function success($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('orders.success', compact('order'));
    }
}