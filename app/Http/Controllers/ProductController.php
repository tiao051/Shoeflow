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

        // Default category name
        $categoryName = 'All Sneakers';

        // 1. Filter by Category
        if ($request->has('category')) {
            $slug = $request->input('category');
            
            // Find category first
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                // If found, assign name and filter by ID (faster than whereHas)
                $categoryName = $category->name;
                $products->where('category_id', $category->id);
            }
        }

        // 2. Sort
        if ($request->has('sort')) {
            match($request->sort) {
                'price_low'  => $products->orderBy('price', 'asc'),
                'price_high' => $products->orderBy('price', 'desc'),
                // 'popular'    => $products->orderBy('views', 'desc'), 
                default      => $products->orderBy('created_at', 'desc'),
            };
        } else {
            $products->orderBy('created_at', 'desc');
        }

        // 3. Pagination & Preserve URL parameters
        $products = $products->paginate(12)->withQueryString();

        // 4. Return JSON if AJAX (Load More / Filter without reload)
        if ($request->ajax()) {
            $productCardsHtml = view('partials.product-cards', compact('products'))->render();
            $paginationHtml = $products->links('pagination::bootstrap-5')->toHtml();

            return response()->json([
                'product_list' => $productCardsHtml,
                'pagination' => $paginationHtml,   
            ]);
        }

        return view('products.index', compact('products', 'categoryName'));
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
}