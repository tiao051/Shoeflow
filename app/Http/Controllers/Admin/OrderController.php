<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index()
    {
        // Get list of orders, newest first
        $orders = Order::latest()->paginate(10); // Paginate 10 orders per page
        return view('admin.orders.index', compact('orders'));
    }

    // API that returns order details as JSON
    public function show($id)
    {
        $order = Order::with(['items.product'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }

    // Update order status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!'
        ]);
    }

    public function destroy(Order $order)
    {
        $order->items()->delete(); // Delete order items
        $order->delete(); // Delete order

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully!'
        ]);
    }
    public function export(Request $request)
    {
        $type = $request->query('type', 'day'); 
        $query = Order::query();

        // 1. Filter orders based on time
        switch ($type) {
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $fileName = 'orders_week_' . date('W_Y') . '.csv';
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                $fileName = 'orders_month_' . date('m_Y') . '.csv';
                break;
            case 'quarter':
                $query->whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()]);
                $fileName = 'orders_quarter_' . ceil(date('n')/3) . '_' . date('Y') . '.csv';
                break;
            case 'day':
            default:
                $query->whereDate('created_at', Carbon::today());
                $fileName = 'orders_today_' . date('d_m_Y') . '.csv';
                break;
        }

        // 2. Create Streamed Response (Download CSV file)
        $headers = [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($query) {
            // Open stream output
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel to read UTF-8 Vietnamese characters
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // CSV column headers
            fputcsv($file, ['Order ID', 'Customer', 'Phone', 'Total Amount', 'Payment', 'Status', 'Date']);

            // Fetch data in chunks to save memory for large datasets
            $query->latest()->chunk(100, function($orders) use ($file) {
                foreach ($orders as $order) {
                    fputcsv($file, [
                        '#' . $order->id,
                        $order->fullname,
                        $order->phone,
                        number_format($order->total_amount, 0, ',', '.'), // Do not add 'đ' to make it easier for Excel to calculate
                        $order->payment_method,
                        strtoupper($order->status),
                        $order->created_at->format('d/m/Y H:i'),
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}