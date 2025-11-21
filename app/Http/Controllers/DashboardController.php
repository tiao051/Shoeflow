<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)->limit(4)->get();
        $newProducts = Product::latest()->limit(8)->get();
        $categories = Category::all();

        return view('dashboard', compact('featuredProducts', 'newProducts', 'categories'));
    }
}