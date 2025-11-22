<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List of products
    public function index(Request $request)
    {
        $products = Product::query();

        // Filter by category
        if ($request->has('category')) {
            $products->where('category_id', $request->category);
        }

        // Sort
        if ($request->has('sort')) {
            match($request->sort) {
                'price_low' => $products->orderBy('price', 'asc'),
                'price_high' => $products->orderBy('price', 'desc'),
                'popular' => $products->orderBy('views', 'desc'),
                default => $products->orderBy('created_at', 'desc'),
            };
        }

        $products = $products->paginate(12);

        return view('products.index', compact('products')); 
    }

    // Product details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts')); 
    }

    // Search
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        return view('products.search', compact('products', 'query')); 
    }

    // Filter (Returns JSON response)
    public function filter(Request $request)
    {
        $products = Product::query();

        if ($request->has('price_min')) {
            $products->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $products->where('price', '<=', $request->price_max);
        }

        return response()->json($products->paginate(12));
    }
}