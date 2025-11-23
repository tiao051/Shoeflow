<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LimitedController extends Controller
{
    /**
     * Display the Limited Edition product page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Dữ liệu giả lập cho sản phẩm Limited Edition
        // Thực tế: Dữ liệu này sẽ được lấy từ database (ví dụ: Product::where('is_limited', true)->first())
        $product = (object)[
            'id' => 999,
            'name' => 'CHUCK 70 RENEW x DRKSHDW',
            'price' => 3990000,
            'total_stock' => 500,
            'current_number' => 241, // Số thứ tự hiện tại (nếu có)
            'release_type' => 'End', // 'Drop' hoặc 'End'
            // Đặt thời gian kết thúc (ví dụ: 3 ngày 21 giờ 14 phút 9 giây kể từ bây giờ)
            'release_end_timestamp' => now()->addDays(3)->addHours(21)->addMinutes(14)->addSeconds(9)->timestamp,
        ];
        
        return view('limited.index', compact('product'));
    }
}