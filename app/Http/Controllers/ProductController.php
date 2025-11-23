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
        $categoryName = 'All Sneakers';
        
        $keyword = $request->input('q'); 
        $isSearching = false; 

        // 1. Filter by Category 
        if ($request->has('category')) {
            $slug = $request->input('category');
            
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                $categoryName = $category->name;
                $products->where('category_id', $category->id);
            }
        }
        
        // 2. Search by Keyword 
        if ($keyword) {
            $isSearching = true;
            
            // If this is a search page (not a category page), set the title as search results
            if (!$request->has('category')) {
                // Set a special string so that products.index view can reformat
                $categoryName = 'Search results for ' . $keyword; 
            }
            
            // Filter products by keyword
            $products->where(function ($query) use ($keyword) {
                // Search by product name
                $query->where('name', 'LIKE', "%{$keyword}%");

                // Search by category name
                $query->orWhereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            });
        }
        
        // 3. Sort 
        if ($request->has('sort')) {
            match($request->sort) {
                'price_low'  => $products->orderBy('price', 'asc'),
                'price_high' => $products->orderBy('price', 'desc'),
                'newest'     => $products->orderBy('created_at', 'desc'),
                // 'popular'  => $products->orderBy('views', 'desc'), 
                default      => $products->orderBy('created_at', 'desc'),
            };
        } else {
            $products->orderBy('created_at', 'desc');
        }

        // 4. Pagination & Preserve URL parameters
        $products = $products->paginate(12)->withQueryString();

        // 5. Return JSON if AJAX (Load More / Filter without reload)
        if ($request->ajax()) {
            if ($products->isEmpty()) {
                $noResultsHtml = view('partials.no-results', compact('keyword'))->render();
                return response()->json([
                    'product_list' => $noResultsHtml,
                    'pagination' => '', 
                ]);
            }
            
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
    
    public function runStarTrainer(Request $request)
    {
        $products = Product::where('image', 'LIKE', '%run_star%')
                           ->where('is_active', 1)
                           ->orderBy('created_at', 'desc');

        if ($request->has('sort')) {
            match($request->sort) {
                'price_low'  => $products->orderBy('price', 'asc'),
                'price_high' => $products->orderBy('price', 'desc'),
                'newest'     => $products->orderBy('created_at', 'desc'),
                default      => $products->orderBy('created_at', 'desc'),
            };
        }
        else {
            $products->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(12)->withQueryString();

        $categoryName = 'RUN STAR TRAINER COLLECTION'; 
        
        if ($request->ajax()) {
            if ($products->isEmpty()) {
                $noResultsHtml = view('partials.no-results', ['keyword' => 'Run Star'])->render(); 
                return response()->json([
                    'product_list' => $noResultsHtml,
                    'pagination' => '',
                ]);
            }
            
            $productCardsHtml = view('partials.product-cards', ['products' => $products])->render();
            $paginationHtml = $products->links('pagination::bootstrap-5')->toHtml();

            return response()->json([
                'product_list' => $productCardsHtml,
                'pagination' => $paginationHtml,  
            ]);
        }

        return view('products.run-star-trainer', compact('products', 'categoryName'));
    }
}