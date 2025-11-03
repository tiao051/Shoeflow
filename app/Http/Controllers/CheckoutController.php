<?php

namespace App\Http\Controllers;

use Application\Services\CartService;
use Application\Services\OrderService;
use Domain\Repositories\PromotionRepositoryInterface;
use App\Models\Address;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
        private PromotionRepositoryInterface $promotionRepository
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $addresses = auth()->user()->addresses;
        $subtotal = $this->cartService->getSubtotal();
        
        $orderCalculation = $this->orderService->calculateOrderTotal(
            $cart,
            session('discount', 0),
            session('shipping_fee', 10000) // Default shipping
        );

        return view('checkout.index', compact('cart', 'addresses', 'orderCalculation'));
    }

    public function applyPromotion(Request $request)
    {
        $validated = $request->validate([
            'promo_code' => 'required|string',
        ]);

        $subtotal = $this->cartService->getSubtotal();
        $result = $this->promotionRepository->validatePromotion($validated['promo_code'], $subtotal);

        if ($result['valid']) {
            session(['discount' => $result['discount'], 'promo_code' => $validated['promo_code']]);
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card,e_wallet',
            'notes' => 'nullable|string',
        ]);

        $cart = $this->cartService->getCart();
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $orderCalculation = $this->orderService->calculateOrderTotal(
            $cart,
            session('discount', 0),
            session('shipping_fee', 10000)
        );

        $orderData = array_merge($validated, [
            'user_id' => auth()->id(),
            'subtotal' => $orderCalculation['subtotal'],
            'discount' => $orderCalculation['discount'],
            'tax' => $orderCalculation['tax'],
            'shipping_fee' => $orderCalculation['shipping_fee'],
            'total' => $orderCalculation['total'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        try {
            $order = $this->orderService->createOrder($orderData, array_values($cart));
            
            // Clear cart and session data
            $this->cartService->clear();
            session()->forget(['discount', 'promo_code', 'shipping_fee']);

            return redirect()->route('order.success', $order['order_number'])
                ->with('success', 'Order placed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function success(string $orderNumber)
    {
        $order = $this->orderService->getOrderByNumber($orderNumber);
        
        if (!$order || $order['user_id'] !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }
}
