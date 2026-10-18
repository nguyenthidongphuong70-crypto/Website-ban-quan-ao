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

    $subtotal = $cartItems->sum(function($item) {
        return $item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0);
    });

    $shippingFee = ($subtotal >= 500000 || $subtotal == 0) ? 0 : 30000;
    $total = $subtotal + $shippingFee;

    return view('checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
    }

    public function store(Request $request)
{
    
    $validated = $request->validate([
        'receiver_name' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
        'phone'         => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        'address'       => ['required', 'string', 'max:255'],
    ], [
        'receiver_name.regex' => 'Họ và tên chỉ được chứa các ký tự chữ cái.',
        'phone.regex'         => 'Số điện thoại không hợp lệ (phải đúng 10 chữ số).',
        'required'            => 'Trường này không được để trống.',
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
        // 2. Tạo đơn hàng và dùng thẳng $validated['address']
        $order = Order::create([
            'user_id'       => Auth::id(),
            'receiver_name' => $validated['receiver_name'],
            'phone'         => $validated['phone'],
            'address'       => $validated['address'], // Lấy trực tiếp ô địa chỉ đơn giản
            'total_price'   => $totalPrice,
            'status'        => 'pending',
        ]);

        foreach ($cartItems as $item) {
            // Lưu chi tiết đơn hàng
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->sale_price ?? $item->product->price,
            ]);

            // Cập nhật (trừ) số lượng tồn kho của sản phẩm
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock = max(0, $product->stock - $item->quantity);
                $product->save();
            }
        }

        // Xóa giỏ hàng sau khi đặt thành công
        CartItem::where('user_id', Auth::id())->delete();

        DB::commit();

        return redirect()->route('order.success', ['id' => $order->id])->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
}
    public function showSuccess($id)
    {
    $order = \App\Models\Order::with('orderDetails.product')->findOrFail($id);
    return view('orders.success', compact('order'));
    }

    public function myOrders()
    {
        // Lấy danh sách đơn hàng của tài khoản đang đăng nhập
        $orders = \App\Models\Order::where('user_id', \Illuminate\Support\Facades\Auth::id())
                    ->orderBy('id', 'desc')
                    ->get();

        return view('orders.history', compact('orders'));
    }

}
