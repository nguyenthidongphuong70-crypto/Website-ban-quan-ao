<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrder($userId, array $data, $cartItems)
    {
        return DB::transaction(function () use ($userId, $data, $cartItems) {
            // 1. Tính tổng tiền và kiểm tra tồn kho
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new Exception("Sản phẩm '{$item->product->name}' không đủ số lượng trong kho.");
                }
                $totalAmount += $item->product->price * $item->quantity;
            }

            // 2. Tạo đơn hàng (Order)
            $order = Order::create([
                'user_id' => $userId,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'total_amount' => $totalAmount,
                'payment_method' => $data['payment_method'],
                'status' => 'pending', // Chờ xử lý
            ]);

            // 3. Tạo chi tiết đơn hàng (OrderDetails) & Trừ tồn kho
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Trừ tồn kho sản phẩm
                $item->product->decrement('stock', $item->quantity);
            }

            // 4. Xóa giỏ hàng sau khi đặt thành công
            CartItem::where('user_id', $userId)->delete();

            return $order;
        });
    }
}