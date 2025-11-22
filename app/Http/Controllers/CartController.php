<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Voucher;

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     */
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        // If cart does not exist, return an empty cart view
        if (!$cart) {
            return view('cart', [
                'cartItems' => collect(), 
                'subtotal' => 0, 
                'shipping' => 0, 
                'tax' => 0, 
                'total' => 0
            ]);
        }

        // Load cart items with related product information
        $cartItems = $cart->items()->with('product')->get();
        
        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        
        // Shipping rule: Free shipping for orders over 1,000,000 VND
        $shipping = $subtotal > 1000000 ? 0 : 30000; 
        
        // Tax calculation (e.g., 10% VAT)
        $tax = $subtotal * 0.1;
        
        // Final total
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|max:10',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $size = $request->input('size');
        $user = Auth::user();

        if (!$user) {
             return response()->json([
                'status' => 'error', 
                'message' => 'You need to login to add products to the cart.'
            ], 401);
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $product = Product::find($productId);
        
        if (!$product) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Product not found.'
            ], 404);
        }

        $existingItem = $cart->items()
            ->where('product_id', $productId)
            ->where('size', $size)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            $cartItem = new CartItem([
                'product_id' => $productId,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => $quantity,
                'size' => $size,
            ]);
            $cart->items()->save($cartItem);
        }

        // Calculate total quantity for the badge
        $cartCount = $cart->items()->sum('quantity');

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart successfully!',
            'cart_count' => $cartCount
        ]);     
    }

    /**
     * Update the quantity of a specific cart item (AJAX).
     */
    public function update(Request $request, $itemId)
    {
        // 1. Find the cart item
        $cartItem = CartItem::find($itemId);
        if (!$cartItem) return response()->json(['status' => 'error'], 404);

        // 2. Validate input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        // 3. Update quantity
        $cartItem->update(['quantity' => $request->quantity]);
        
        // Recalculate cart totals
        $totals = $this->calculateCartTotals($cartItem->cart);

        // 4. Return JSON success response
        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated',
            'item_total' => $cartItem->price * $cartItem->quantity, 
            'totals' => $totals 
        ]);
    }

    /**
     * Remove a product from the cart (AJAX).
     */
    public function remove($itemId)
    {
        // 1. Find the cart item
        $cartItem = CartItem::find($itemId);
        if (!$cartItem) return response()->json(['status' => 'error'], 404);

        // 2. Delete the item
        $cart = $cartItem->cart;
        $cartItem->delete();

        // Recalculate cart totals
        $totals = $this->calculateCartTotals($cart);

        // 3. Return JSON success response
        return response()->json([
            'status' => 'success',
            'message' => 'Item removed',
            'totals' => $totals
        ]);
    }

    private function calculateCartTotals($cart)
    {
        $cartItems = $cart->items;
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 1000000 ? 0 : 30000;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'cart_count' => $cartItems->sum('quantity')
        ];
    }

    /**
     * Clear the entire shopping cart.
     */
    public function clear()
    {
        $user = auth()->user();
        Cart::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Shopping cart cleared.');
    }

    /**
     * Get the total number of items in the cart.
     */
    public function count()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $count = $cart ? $cart->items()->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }

    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->items()->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 1000000 ? 0 : 30000; 
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        $vouchers = Voucher::where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'vouchers'));
    }

    public function checkCoupon(Request $request)
    {
        $code = $request->input('code');
        $user = auth()->user();

        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) return response()->json(['status' => 'error', 'message' => 'Cart empty']);
        
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);

        $voucher = Voucher::where('code', $code)
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$voucher) {
            return response()->json(['status' => 'error', 'message' => 'Invalid or expired voucher code.'], 404);
        }
        
        $discountAmount = 0;

        if ($voucher->discount_type == 'fixed') {
            $discountAmount = $voucher->discount_value;
        } else {
            // Calculate percentage discount
            $discountAmount = $subtotal * ($voucher->discount_value / 100);
            // Check maximum discount limit
            if ($voucher->max_discount_amount && $discountAmount > $voucher->max_discount_amount) {
                $discountAmount = $voucher->max_discount_amount;
            }
        }
        return response()->json([
            'status' => 'success',
            'discount' => $discountAmount,
            'message' => 'Voucher applied successfully!',
            'code' => $voucher->code
        ]);
    }
}