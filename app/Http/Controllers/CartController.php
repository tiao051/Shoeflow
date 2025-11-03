<?php

namespace App\Http\Controllers;

use Application\Services\CartService;
use Application\Services\ShoeService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private ShoeService $shoeService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'shoe_id' => 'required|integer|exists:shoes,id',
            'shoe_name' => 'required|string',
            'shoe_image' => 'nullable|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['subtotal'] = $validated['quantity'] * $validated['price'];

        $this->cartService->addItem($validated);

        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity($key, $validated['quantity']);

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    public function remove(string $key)
    {
        $this->cartService->removeItem($key);

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }
}
