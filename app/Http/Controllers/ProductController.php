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
        if ($request->has('category') && !$keyword) {
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

            if (!$request->has('category')) {
                $categoryName = 'Search results for ' . $keyword;
            }

            // Search by product name OR category name
            $products->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhereHas('category', function ($q) use ($keyword) {
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

    public function saleProducts(Request $request)
    {
        // Start query
        $productsQuery = Product::query()
                        ->where('is_active', 1)
                        ->whereNotNull('sale_price') // Ensure the sale_price column has a value
                        ->whereColumn('sale_price', '<', 'price'); // And sale price must be lower than original price

        // 1. Sort logic (reusing logic from other pages)
        if ($request->has('sort')) {
            match($request->sort) {
                'price_low'  => $productsQuery->orderBy('sale_price', 'asc'),
                'price_high' => $productsQuery->orderBy('sale_price', 'desc'),
                'newest'     => $productsQuery->orderBy('created_at', 'desc'),
                default      => $productsQuery->orderBy('created_at', 'desc'),
            };
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        // 2. Pagination
        $products = $productsQuery->paginate(12)->withQueryString();

        $categoryName = 'SALE UP TO 50%';

        // 3. Handle AJAX (similar to Run Star logic)
        if ($request->ajax()) {
            if ($products->isEmpty()) {
                // Partial view for no results
                $noResultsHtml = view('partials.no-results', ['keyword' => 'Sale'])->render();
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

        // 4. Return initial view
        return view('products.sale', compact('products', 'categoryName'));
    }
}