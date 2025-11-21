<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Danh sách sản phẩm
    public function index(Request $request)
    {
        $products = Product::query();

        // Filter theo category
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

        // SỬA Ở ĐÂY: Trỏ vào thư mục products, file index
        return view('products.index', compact('products')); 
    }

    // Chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        $product->increment('views');

        // SỬA Ở ĐÂY: Trỏ vào thư mục products, file show
        return view('products.show', compact('product', 'relatedProducts')); 
    }

    // Tìm kiếm
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        // SỬA Ở ĐÂY: Trỏ vào thư mục products, file search (hoặc dùng chung index tùy bạn)
        return view('products.search', compact('products', 'query')); 
    }

    // Filter (Giữ nguyên vì trả về JSON)
    public function filter(Request $request)
    {
        $products = Product::query();

        if ($request->has('price_min')) {
            $products->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $products->where('price', '<=', $request->price_max);
        }
        if ($request->has('sizes')) {
            $products->whereJsonContains('sizes', $request->sizes);
        }
        if ($request->has('colors')) {
            $products->whereJsonContains('colors', $request->colors);
        }

        return response()->json($products->paginate(12));
    }
}