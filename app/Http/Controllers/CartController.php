<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{

    public function index()
{
    $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

    $subtotal = $cartItems->sum(function($item) {
        return $item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0);
    });

    $shippingFee = ($subtotal >= 500000 || $subtotal == 0) ? 0 : 30000;

    $total = $subtotal + $shippingFee;

    return view('cart.index', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
}


    public function store(Request $request, $id)
    {
        try {
            // Sử dụng Auth::check() và Auth::id()
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!'
                ], 401);
            }

            $quantity = $request->input('quantity', 1);

            $cartItem = CartItem::where('user_id', Auth::id())
                                ->where('product_id', $id)
                                ->first();

            if ($cartItem) {
                $cartItem->quantity +=  $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $id,
                    'quantity'   => $quantity
                ]);
            }

            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

            return response()->json([
                'success'   => true,
                'message'   => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartCount' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }
    public function addToCart(Request $request)
{
    // Xử lý thêm sản phẩm vào database/session của bạn ở đây...
    // Ví dụ:
    // $cartItem = ...;

    // Tính tổng số lượng sản phẩm trong giỏ hàng hiện tại của user
    $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

    // Nếu là request từ AJAX, trả về JSON
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
            'cartCount' => $cartCount // Số lượng mới để cập nhật lên icon giỏ hàng
        ]);
    }

    return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
}

    public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = CartItem::with('product')->findOrFail($id);

    // Kiểm tra xem số lượng mua có vượt quá tồn kho (stock) hiện tại của sản phẩm không
    if ($request->quantity > $cartItem->product->stock) {
        return redirect()->back()->with('error', 'Số lượng vượt quá sản phẩm tồn kho cho phép!');
    }

    // Cập nhật số lượng mới
    $cartItem->quantity = $request->quantity;
    $cartItem->save();

    return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng giỏ hàng thành công!');
}

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
