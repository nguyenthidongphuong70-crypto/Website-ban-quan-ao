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
        
        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

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

    public function update(Request $request, CartItem $cartItem)
    {

        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
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