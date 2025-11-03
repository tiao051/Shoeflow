<?php

namespace App\Http\Controllers;

use Application\Services\OrderService;
use Application\Services\ReviewService;
use App\Models\Address;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private ReviewService $reviewService
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function orders()
    {
        $orders = $this->orderService->getUserOrders(auth()->id(), 10);
        return view('profile.orders', compact('orders'));
    }

    public function orderDetail(string $orderNumber)
    {
        $order = $this->orderService->getOrderByNumber($orderNumber);
        
        if (!$order || $order['user_id'] !== auth()->id()) {
            abort(404);
        }

        return view('profile.order-detail', compact('order'));
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();

        if (!empty($validated['is_default'])) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        Address::create($validated);

        return redirect()->back()->with('success', 'Address added successfully');
    }

    public function deleteAddress(int $id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully');
    }

    public function reviews()
    {
        $reviews = $this->reviewService->getUserReviews(auth()->id());
        return view('profile.reviews', compact('reviews'));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'shoe_id' => 'required|integer|exists:shoes,id',
            'order_id' => 'nullable|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        try {
            $this->reviewService->createReview($validated);
            return redirect()->back()->with('success', 'Review submitted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'You have already reviewed this product');
        }
    }
}
