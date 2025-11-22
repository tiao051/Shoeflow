<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page with the latest products.
     */
    public function index()
    {
        // 1. Get 6 latest products (New Arrivals)
        $newArrivals = Product::orderBy('created_at', 'desc')->limit(6)->get();
        // 2. Load 3 main categories (e.g., Chuck Taylor, One Star, All Star)
        // In a real Laravel app you'd fetch categories via a Category model.
        // For simplicity, keep category markup in the Blade for now.
        
        return view('dashboard', [
            'newArrivals' => $newArrivals,
        ]);
    }
}