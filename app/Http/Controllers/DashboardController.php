<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard với các sản phẩm mới nhất.
     */
    public function index()
    {
        // 1. Lấy 6 sản phẩm mới nhất (New Arrivals)
        $newArrivals = Product::orderBy('created_at', 'desc')->limit(6)->get();

        // 2. Lấy 3 danh mục chính (ví dụ: Chuck Taylor, One Star, All Star)
        // Trong môi trường Laravel thực tế, bạn sẽ cần Category Model và logic lấy Category.
        // Tạm thời, chúng ta sẽ giữ nguyên phần danh mục trong Blade để tối giản.
        
        return view('dashboard', [
            'newArrivals' => $newArrivals,
        ]);
    }
}