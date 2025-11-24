<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. OVERVIEW STATISTICS (CARDS)
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role_id', '!=', 2)->count(); // Exclude admin

        // 2. REVENUE CHART FOR THE LAST 7 DAYS (Line Chart)
        $revenueData = [];
        $revenueLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                            ->where('status', '!=', 'cancelled')
                            ->sum('total_amount');
            
            $revenueLabels[] = $date->format('d/m'); // Labels: 24/10, 25/10...
            $revenueData[] = $revenue;
        }

        // 3. ORDER STATUS CHART (Doughnut Chart)
        $orderStatus = Order::select('status', DB::raw('count(*) as total'))
                            ->groupBy('status')
                            ->pluck('total', 'status')
                            ->toArray();
        
        // Ensure all keys exist to prevent color misalignment if a status is missing
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $statusData = [];
        foreach ($statuses as $status) {
            $statusData[] = $orderStatus[$status] ?? 0;
        }

        // 4. List 5 newest orders
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalCustomers',
            'revenueLabels', 'revenueData',
            'statuses', 'statusData',
            'recentOrders'
        ));
    }
}