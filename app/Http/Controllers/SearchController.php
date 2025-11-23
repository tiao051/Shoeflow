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
        $sort = $request->input('sort'); // Lấy tham số sort
        
        if (!$keyword) {
            return redirect('/');
        }

        $productsQuery = Product::query() // Đổi thành $productsQuery để áp dụng sort
            ->with('category')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
                $query->orWhereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->select('id', 'name', 'price', 'color', 'category_id', 'image'); 
        
        // 1. ÁP DỤNG LOGIC SORT
        if ($sort) {
            match($sort) {
                'price_low'  => $productsQuery->orderBy('price', 'asc'),
                'price_high' => $productsQuery->orderBy('price', 'desc'),
                // 'popular'  => $productsQuery->orderBy('views', 'desc'),
                default      => $productsQuery->orderBy('created_at', 'desc'),
            };
        } else {
            // Sắp xếp mặc định
            $productsQuery->orderBy('created_at', 'desc');
        }
        
        // 2. PHÂN TRANG
        $products = $productsQuery->paginate(12)->withQueryString();
        
        $categoryName = 'Search results for ' . $keyword; 
        
        // 3. XỬ LÝ AJAX (RẤT QUAN TRỌNG ĐỂ CẬP NHẬT DANH SÁCH SẢN PHẨM SAU SORT)
        if ($request->ajax()) {
             $productCardsHtml = view('partials.product-cards', compact('products'))->render();
             $paginationHtml = $products->links('pagination::bootstrap-5')->toHtml();

             return response()->json([
                 'product_list' => $productCardsHtml,
                 'pagination' => $paginationHtml,  
             ]);
        }

        // 4. Trả về view cho lần tải đầu tiên
        return view('products.index', compact('products', 'categoryName'));
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