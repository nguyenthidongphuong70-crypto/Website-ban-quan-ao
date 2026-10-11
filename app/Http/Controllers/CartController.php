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
        $userId = Auth::id();

        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
        });

        return view('cart.index', compact('cartItems', 'total'));
    }


    public function store(AddToCartRequest $request, Product $product)
    {
        $userId = Auth::id();
        $quantity = $request->input('quantity', 1);

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');
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
