<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Application\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->getAllOrders(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = \App\Models\Order::with(['user', 'items.shoe'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $this->orderService->updateOrderStatus($id, $validated['status']);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function updatePaymentStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $this->orderService->updatePaymentStatus($id, $validated['payment_status']);

        return redirect()->back()->with('success', 'Payment status updated successfully');
    }
}
