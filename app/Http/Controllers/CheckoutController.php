<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Trang thanh toán
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items()->count() === 0) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống');
        }

        $cartItems = $cart->items()->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 2000000 ? 0 : 50000;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    // Tạo đơn hàng
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|in:card,bank,cod',
        ]);

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect('/cart')->with('error', 'Giỏ hàng trống');
        }

        $cartItems = $cart->items()->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 2000000 ? 0 : 50000;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . time(),
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'shipping_name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'shipping_email' => $validated['email'],
            'shipping_phone' => $validated['phone'],
            'shipping_address' => $validated['address'],
            'shipping_city' => $validated['city'],
            'shipping_postal_code' => $validated['postal_code'],
        ]);

        // Tạo order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'size' => $item->size,
                'color' => $item->color,
            ]);
        }

        // Xóa giỏ hàng
        $cart->delete();

        return redirect()->route('order.detail', $order->id)->with('success', 'Đơn hàng đã được tạo');
    }
}