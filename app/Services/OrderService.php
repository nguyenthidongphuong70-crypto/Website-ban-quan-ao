<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrder($request, $cartItems,$userId)
{
    // 1. Tính tổng tiền
    $total =$cartItems->sum(function ($item) {$price = $item->product->sale_price ?? $item->product->price ?? 0;
        return $item->quantity * $price;
    });

    // 2. Lưu thông tin chung vào bảng `orders`
    $order = Order::create([
        'user_id' => $userId,
        'receiver_name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'note' => $request->note,
        'total_price' => $total,
        'status' => 'pending',
    ]);

    // 3. Lưu chi tiết sản phẩm vào bảng `order_details` (KHÔNG CÓ user_id hay receiver_name ở đây)
    foreach ($cartItems as $item) {
    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $item->product_id, // Đã sửa từ 'user_id' thành 'product_id'
        'quantity' => $item->quantity,
        'price' => $item->product->sale_price ?? $item->product->price ?? 0,
    ]);

    // Trừ tồn kho sản phẩm
    $product = Product::find($item->product_id);
    if ($product) {
        $product->stock = max(0, $product->stock - $item->quantity);
        $product->save();
    }
}

    // 4. Xóa giỏ hàng
    CartItem::where('user_id', $userId)->delete();

    return $order;
}
}
