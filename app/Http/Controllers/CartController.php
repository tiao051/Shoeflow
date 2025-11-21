<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $user = auth()->user();
        
        // Validate required fields (assuming product_id is required)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);
        
        $product = Product::findOrFail($request->product_id);

        // Find or create the user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if an identical item (same product, size, and color) already exists
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('size', $request->size ?? null)
            ->where('color', $request->color ?? null)
            ->first();
            
        $quantity = $request->quantity ?? 1;

        if ($cartItem) {
            // Update quantity if item exists
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
                'size' => $request->size,
                'color' => $request->color,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
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