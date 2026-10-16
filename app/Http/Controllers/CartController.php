<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $userId = Auth::id();
    $productId = $request->product_id;
    $quantity = $request->quantity;

    // Lấy thông tin sản phẩm để có thể gọi tên sản phẩm
    $product = \App\Models\Product::findOrFail($productId);

    $cartItem = CartItem::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

    if ($cartItem) {
        $cartItem->quantity += $quantity;
        $cartItem->save();
    } else {
        CartItem::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => $quantity,
        ]);
    }

    // Đưa tên sản phẩm vào câu thông báo
    return back()->with('success', 'Đã thêm "' . $product->name . '" vào giỏ hàng thành công!');
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
