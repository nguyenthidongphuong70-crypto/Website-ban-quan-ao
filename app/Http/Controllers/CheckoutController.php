<?php
namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\OrderService;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CheckoutController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {

        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $total = $cartItems->sum(function($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0);
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
{
    $request->validate([
        'receiver_name' => 'required|string|max:100',
        'phone'         => 'required|string|max:20',
        'address'       => 'required|string|max:255',
    ]);

    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
    }

    $totalPrice = $cartItems->sum(function($item) {
        return $item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0);
    });

    DB::beginTransaction();
    try {
        $order = Order::create([
            'user_id'       => Auth::id(),
            'receiver_name' => $request->receiver_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'total_price'   => $totalPrice,
            'status'        => 'pending',
        ]);

        foreach ($cartItems as $item) {
            // 1. Lưu chi tiết đơn hàng
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->sale_price ?? $item->product->price,
            ]);

            // 2. Cập nhật (trừ) số lượng tồn kho của sản phẩm
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock = max(0, $product->stock - $item->quantity); // Đảm bảo stock không bị âm
                $product->save();
            }
        }

        // 3. Xóa giỏ hàng sau khi đặt thành công
        CartItem::where('user_id', Auth::id())->delete();

        DB::commit();

        return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
}
}
