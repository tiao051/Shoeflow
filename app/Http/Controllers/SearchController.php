<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return view('search', ['products' => collect(), 'query' => $query]);
        }

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        return view('search', compact('products', 'query'));
    }

    // AJAX search suggestions
    public function suggestions(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Product::where('name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->pluck('name');

        return response()->json($suggestions);
    }
}
