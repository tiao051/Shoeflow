<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     */
    public function index()
    {
        // Assuming the user is authenticated via web middleware
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
        
        // Shipping rule: Free shipping for orders over 2,000,000 VND
        $shipping = $subtotal > 2000000 ? 0 : 50000; 
        
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
        // 1. Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|max:10', // Validate size is present
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $size = $request->input('size');
        $user = Auth::user();

        if (!$user) {
             return response()->json([
                'status' => 'error', 
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.'
            ], 401); // 401 Unauthorized
        }

        // 2. Find or create the user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // 3. Find the product details
        $product = Product::find($productId);
        
        if (!$product) {
            // If product is not found, return an error response
            return response()->json([
                'status' => 'error', 
                'message' => 'Sản phẩm không tồn tại.'
            ], 404);
        }

        // 4. Check if the item already exists in the cart with the same size
        $existingItem = $cart->items()
            ->where('product_id', $productId)
            ->where('size', $size)
            ->first();

        if ($existingItem) {
            // Update quantity
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            // Create new cart item
            $cartItem = new CartItem([
                'product_id' => $productId,
                'price' => $product->sale_price ?? $product->price, // Use sale price if available
                'quantity' => $quantity,
                'size' => $size,
            ]);
            $cart->items()->save($cartItem);
        }

        // 5. Success: Return a JSON response
        // Calculate total quantity of items to update header (optional)
        $cartCount = $cart->items()->sum('quantity');

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart successfully!',
            'cart_count' => $cartCount
        ]);     
    }
    /**
     * Update the quantity of a specific cart item.
     */
    public function update(Request $request, $itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);
        
        $newQuantity = $request->quantity;

        if ($newQuantity <= 0) {
            // Remove item if quantity is zero or less
            $cartItem->delete();
        } else {
            // Update quantity
            $cartItem->update(['quantity' => $newQuantity]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    /**
     * Clear the entire shopping cart for the current user.
     */
    public function clear()
    {
        $user = auth()->user();
        Cart::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Shopping cart cleared.');
    }

    /**
     * Get the total number of items in the cart (for AJAX calls).
     */
    public function count()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        $count = $cart ? $cart->items()->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }
}