<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    /**
     * Handles the full search results page (when hitting Enter).
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $sort = $request->input('sort');

        if (!$keyword) {
            return redirect('/');
        }

        $productsQuery = Product::query()
            ->with('category')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhereHas('category', function ($q) use ($keyword) {
                          $q->where('name', 'LIKE', "%{$keyword}%");
                      });
            })
            ->select('id', 'name', 'price', 'color', 'category_id', 'image');

        // Apply sorting
        if ($sort) {
            match ($sort) {
                'price_low'  => $productsQuery->orderBy('price', 'asc'),
                'price_high' => $productsQuery->orderBy('price', 'desc'),
                default      => $productsQuery->orderBy('created_at', 'desc'),
            };
        } else {
            $productsQuery->orderBy('created_at', 'desc');
        }

        // Pagination
        $products = $productsQuery->paginate(12)->withQueryString();

        $categoryName = 'Search results for ' . $keyword;

        // Handle AJAX requests (updating product list dynamically)
        if ($request->ajax()) {
            $productCardsHtml = view('partials.product-cards', compact('products'))->render();
            $paginationHtml = $products->links('pagination::bootstrap-5')->toHtml();

            return response()->json([
                'product_list' => $productCardsHtml,
                'pagination'   => $paginationHtml,
            ]);
        }

        // Initial page load
        return view('products.index', compact('products', 'categoryName'));
    }

    /**
     * Handles fast suggestions for AJAX Live Search.
     */
    public function suggestions(Request $request)
    {
        $keyword = $request->input('q');

        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->with('category')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhereHas('category', function ($q) use ($keyword) {
                          $q->where('name', 'LIKE', "%{$keyword}%");
                      });
            })
            ->select('id', 'name', 'price', 'color', 'category_id', 'image')
            ->limit(5)
            ->get();

        return response()->json($products);
    }
}
