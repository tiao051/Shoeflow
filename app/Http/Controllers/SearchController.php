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

        if (!$keyword) {
            return redirect('/');
        }

        $products = Product::query()
            // Eager Load the category information
            ->with('category') 
            
            // Group search conditions
            ->where(function ($query) use ($keyword) {
                // 1. Search by product name
                $query->where('name', 'LIKE', "%{$keyword}%");

                // 2. Search by category name
                $query->orWhereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            
            // FIX: Include the 'image' column here
            ->select('id', 'name', 'price', 'color', 'category_id', 'image') 
            ->paginate(12);

        return view('search.results', compact('products', 'keyword'));
    }

    /**
     * Handles fast suggestions for the AJAX Live Search.
     */
    public function suggestions(Request $request)
    {
        $keyword = $request->input('q');

        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->with('category') // Eager load category for quick suggestion
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
                
                // Search by category name
                $query->orWhereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            // FIX: Include the 'image' column here
            ->select('id', 'name', 'price', 'color', 'category_id', 'image') 
            ->limit(5)
            ->get();

        return response()->json($products);
    }
}