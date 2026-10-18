<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{

    public function index()
    {
    $userId = Auth::id();
    

    // 1. Chỉ lấy giỏ hàng của user đang đăng nhập
    $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // 2. Tính tổng tiền giỏ hàng
    $total = $cartItems->sum(function ($item) {
        $price = $item->product->sale_price ?? $item->product->price ?? 0;
        return $item->quantity * $price;
    });

    // 3. Trả về đúng trang điền thông tin thanh toán (checkout)
    return view('checkout.index', compact('cartItems', 'total'));
    
    }


    public function store(Request $request)
{
    // 1. Validate dữ liệu người dùng nhập từ form
    $request->validate([
        'receiver_name' => 'required|string|max:100',
        'phone'         => 'required|string|max:20',
        'address'       => 'required|string|max:255',
    ]);

    // 2. Lấy danh sách sản phẩm trong giỏ hàng của user hiện tại
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
    }

    // 3. Tính tổng tiền đơn hàng
    $totalPrice = $cartItems->sum(function($item) {
        return $item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0);
    });

    DB::beginTransaction();

    try {
        // 4. Tạo đơn hàng mới trong bảng orders
        $order = Order::create([
            'user_id'       => Auth::id(),
            'receiver_name' => $request->receiver_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'total_price'   => $totalPrice, // Sử dụng biến tổng tiền vừa tính
            'status'        => 'pending',
        ]);

        // 5. Lưu từng sản phẩm vào bảng chi tiết đơn hàng (order_details)
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->sale_price ?? $item->product->price,
            ]);
        }

        // 6. Xóa giỏ hàng sau khi đặt hàng thành công
        CartItem::where('user_id', Auth::id())->delete();

        DB::commit();

        // Chuyển hướng về trang thành công hoặc lịch sử đơn hàng
        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại! ' . $e->getMessage());
    }
}
    public function history() // hoặc danh sách đơn hàng của khách/admin
    {
        $orders = Order::where('user_id', auth()->id())
                        ->with('orderDetails.product')
                        ->latest()
                        ->get();

        return view('orders.index', compact('orders')); 
    }
    

}
