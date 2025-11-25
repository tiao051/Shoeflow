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
            'message' => 'Voucher applied successfully!',
            'code' => $voucher->code
        ]);
    }

    /**
     * Process the order creation and finalize checkout.
     */
    public function processCheckout(Request $request)
    {
        // 1. Validate
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod,vnpay', // Thêm vnpay vào validate
            'note' => 'nullable|string',
            'applied_coupon' => 'nullable|string',
        ]);

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // 2. Calculate Totals
        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 1000000 ? 0 : 30000;
        $tax = $subtotal * 0.1;
        
        $discount = 0;
        $couponCode = $request->input('applied_coupon');
        
        if ($couponCode) {
            $voucher = Voucher::where('code', $couponCode)
                ->where('is_active', true)->where('quantity', '>', 0)
                ->where('start_date', '<=', now())->where('end_date', '>=', now())
                ->first();

            if ($voucher && $subtotal >= $voucher->min_order_value) {
                if ($voucher->discount_type == 'fixed') {
                    $discount = $voucher->discount_value;
                } else {
                    $discount = $subtotal * ($voucher->discount_value / 100);
                    if ($voucher->max_discount_amount && $discount > $voucher->max_discount_amount) {
                        $discount = $voucher->max_discount_amount;
                    }
                }
                $discount = min($discount, $subtotal);
                // Decrease voucher quantity
                $voucher->decrement('quantity');
            }
        }

        $grandTotal = $subtotal + $shipping + $tax - $discount;
        if ($grandTotal < 0) $grandTotal = 0;

        DB::beginTransaction();
        try {
            // 3. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address . ', ' . $request->city,
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'status' => 'pending', 
                'subtotal' => $subtotal,
                'shipping_fee' => $shipping,
                'tax' => $tax,
                'coupon_code' => $couponCode ?? null,
                'discount_amount' => $discount,
                'total_amount' => $grandTotal,
            ]);

            // 4. Create Order Items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'size' => $item->size,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // Process payment based on selected method
            if ($request->payment_method == 'vnpay') {
                DB::commit(); // Save order first
                // Redirect to VNPAY, don't clear cart yet (in case of failure, user can retry)
                return $this->createVnpayUrl($order);
            } 
            else {
                // COD: Clear cart and complete order
                $cart->items()->delete();
                DB::commit();
                return redirect()->route('checkout.success', ['order' => $order->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error processing order: ' . $e->getMessage());
        }
    }

    /**
     * Create URL to redirect to VNPAY
     */
    private function createVnpayUrl($order)
    {
        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = config('services.vnpay.url');
        $vnp_Returnurl = config('services.vnpay.return_url');

        $vnp_TxnRef = $order->id; 
        $vnp_OrderInfo = "Thanh toan don hang #" . $order->id;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $order->total_amount * 100; 
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            $orderId = $request->vnp_TxnRef;
            $order = Order::find($orderId);
            
            if (!$order) {
                return redirect()->route('cart.index')->with('error', 'Order not found.');
            }

            if ($request->vnp_ResponseCode == '00') {
                // --- PAYMENT SUCCESSFUL ---
                
                // 1. Update order status
                $order->status = 'processing'; // Or 'paid'
                $order->save();

                // 2. Clear cart (Because when creating VNPAY order, we didn't clear it yet)
                $user = auth()->user();
                Cart::where('user_id', $user->id)->delete();

                // 3. Redirect to thank you page
                return redirect()->route('checkout.success', ['order' => $order->id])
                                 ->with('success', 'Payment successful via VNPAY!');
            } else {
                // --- PAYMENT FAILED / CANCELED ---

                // Here we choose to keep it but show an error, user needs to reorder
                return redirect()->route('cart.index')->with('error', 'Payment failed or canceled by user.');
            }
        } else {
            return redirect()->route('cart.index')->with('error', 'Invalid signature.');
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