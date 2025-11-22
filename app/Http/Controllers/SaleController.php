<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // $products = Product::where('discount', '>', 0)
        //     ->orderBy('discount', 'desc')
        //     ->paginate(12);

        // return view('sale', compact('products'));
    }
}