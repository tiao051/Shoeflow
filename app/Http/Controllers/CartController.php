<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem; // Import CartItem cho tường minh
use App\Models\Product;
use App\Models\Voucher; // Đã có
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse; // Cần thiết cho các hàm AJAX như checkCoupon

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

        // Vouchers need to be filtered by user, min_order_value, etc. for a complete app
        $vouchers = Voucher::where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'vouchers'));
    }

    /**
     * Check and apply a voucher code (Coupon).
     * @return Illuminate\Http\JsonResponse
     */
    public function checkCoupon(Request $request): JsonResponse 
    {
        // 1. Get voucher code from request
        $code = $request->input('code');
        $user = auth()->user();

        // 2. Check cart
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return response()->json(['status' => 'error', 'message' => 'Your cart is empty. Please add products.'], 400);
        }
        
        // 3. Calculate subtotal
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);

        // 4. Find and validate Voucher
        $voucher = Voucher::where('code', $code)
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$voucher) {
            // Case when voucher is invalid (expired, does not exist, out of quantity)
            return response()->json(['status' => 'error', 'message' => 'Invalid or expired voucher code.'], 404);
        }
        
        // 5. Check minimum order value
        if ($voucher->min_order_value && $subtotal < $voucher->min_order_value) {
            return response()->json(['status' => 'error', 'message' => 'Order has not reached the minimum value of: ' . number_format($voucher->min_order_value) . ' VND.'], 400);
        }

        // 6. Calculate Discount
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

        // Ensure discount does not exceed subtotal
        $discountAmount = min($discountAmount, $subtotal);

        // 7. Return success JSON response
        return response()->json([
            'status' => 'success',
            'discount' => $discountAmount,
            'message' => 'Mã giảm giá đã được áp dụng thành công!',
            'code' => $voucher->code
        ]);
    }

    /**
     * Process the order creation and finalize checkout.
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod,banking',
            'note' => 'nullable|string',
            'applied_coupon' => 'nullable|string',
        ]);

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();

        // Check if cart is empty
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // 2. Recalculate all totals on server side
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 1000000 ? 0 : 30000; 
        $tax = $subtotal * 0.1;
        
        // Handle Voucher (if any)
        $discount = 0;
        $couponCode = $request->input('applied_coupon'); // Code taken from hidden input
        
        if ($couponCode) {
            $voucher = Voucher::where('code', $couponCode)
                ->where('is_active', true)
                ->where('quantity', '>', 0)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if ($voucher && $subtotal >= $voucher->min_order_value) {
                // Calculate discount
                if ($voucher->discount_type == 'fixed') {
                    $discount = $voucher->discount_value;
                } else {
                    $discount = $subtotal * ($voucher->discount_value / 100);
                    if ($voucher->max_discount_amount && $discount > $voucher->max_discount_amount) {
                        $discount = $voucher->max_discount_amount;
                    }
                }
                
                // Ensure discount does not exceed subtotal
                $discount = min($discount, $subtotal);
                
                // Decrement voucher quantity 
                $voucher->decrement('quantity');
            }
        }

        $grandTotal = $subtotal + $shipping + $tax - $discount;
        if ($grandTotal < 0) $grandTotal = 0;

        // 3. Save to Database (Use Transaction to ensure data integrity)
        DB::beginTransaction();
        try {
            // A. Create order
            // Note: Check your `orders` migration file to ensure these columns exist
            $order = Order::create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address . ', ' . $request->city, 
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'status' => 'pending', // Default status: Pending
                
                // Money columns
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'tax' => $tax,
                'coupon_code' => $couponCode && isset($voucher) ? $couponCode : null,
                'discount_amount' => $discount,
                'total_amount' => $grandTotal,
            ]);

            // B. Convert CartItem to OrderItem
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name, // Store name in case product name changes later
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'size' => $item->size,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // C. Delete cart after successful order
            $cart->items()->delete();
            // Or $cart->delete(); if you want to delete the entire Cart record

            DB::commit(); // Save all changes to DB
            // 4. Redirect to "Thank You" page or Order History
            return redirect()->route('checkout.success', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack(); // If error, rollback all operations
            \Log::error('Checkout Error: ' . $e->getMessage()); 
            return redirect()->back()->with('error', 'There was an error processing your order. Please try again.');
        }
    }

    public function success($orderId)
    {
        // Find (ensure the correct user owns the order for security)
        $order = Order::where('id', $orderId)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        return view('checkout-success', compact('order'));
    }
}