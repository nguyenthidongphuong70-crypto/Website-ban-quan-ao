<?php
namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Hiển thị form thanh toán
    public function index()
    {
        $userId = Auth::id();
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    // Xử lý đặt hàng
    public function store(CheckoutRequest $request)
    {
        try {
            $userId = Auth::id();
            $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
            }

            // Gọi Service xử lý
            $order = $this->orderService->createOrder($userId, $request->validated(), $cartItems);

            return redirect()->route('orders.show', $order->id)
                             ->with('success', 'Đặt hàng thành công!');
                             
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}