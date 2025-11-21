<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Xem giỏ hàng
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart) {
            return view('cart', ['cartItems' => collect(), 'subtotal' => 0, 'shipping' => 0, 'tax' => 0, 'total' => 0]);
        }

        $cartItems = $cart->items()->with('product')->get();
        
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 2000000 ? 0 : 50000;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    // Thêm vào giỏ hàng
    public function add(Request $request)
    {
        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        // Tìm hoặc tạo cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Kiểm tra sản phẩm đã có trong cart chưa
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('size', $request->size ?? null)
            ->where('color', $request->color ?? null)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ?? 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'size' => $request->size,
                'color' => $request->color,
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã thêm vào giỏ hàng');
    }

    // Cập nhật số lượng
    public function update(Request $request, $itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        
        if ($request->quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->update(['quantity' => $request->quantity]);
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã cập nhật');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ');
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        $user = auth()->user();
        Cart::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa');
    }

    // Lấy số lượng sản phẩm trong giỏ (AJAX)
    public function count()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $count = $cart ? $cart->items()->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }
}