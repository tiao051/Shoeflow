<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Danh sách đơn hàng
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)
            ->with('items.product')
            ->findOrFail($id);

        return view('order-detail', compact('order'));
    }

    // Hủy đơn hàng
    public function cancel($id)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Đơn hàng đã bị hủy');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này');
    }

    // Tải hóa đơn PDF
    public function invoice($id)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->findOrFail($id);

        // Generate PDF - cần package laravel-dompdf
        // return PDF::loadView('invoice', compact('order'))->download('order-' . $order->id . '.pdf');
        
        return view('invoice', compact('order'));
    }
}