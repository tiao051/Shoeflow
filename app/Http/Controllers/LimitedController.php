<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Đảm bảo bạn đã có Product Model
use Carbon\Carbon; // Cần cho việc tính toán timestamp nếu bạn không lưu thời gian kết thúc release trong DB

class LimitedController extends Controller
{
    public function index()
    {
        // 1. Tìm sản phẩm theo slug
        $product = Product::where('slug', 'converse-chuck-70-renew-x-a-trak')->first();

        // 2. Xử lý khi không tìm thấy sản phẩm (tùy chọn)
        if (!$product) {
            // Bạn có thể trả về 404 hoặc một view thông báo lỗi
            abort(404, 'Limited edition product not found.');
        }

        // 3. Chuẩn bị dữ liệu bổ sung cho View (nếu cần thiết)
        // Ví dụ: tính toán Release End Timestamp. Nếu bạn đã lưu trong DB thì không cần.
        // Tôi thêm vào đây giả định 7 ngày sau khi sản phẩm được tạo (hoặc bạn có thể thêm cột release_ends_at trong DB)
        $release_ends_at = Carbon::now()->addDays(7); 
        
        // Truyền dữ liệu sang View
        return view('limited.index', [
            'product' => $product,
            // Thêm timestamp để dùng cho JS countdown. 
            // Nếu bạn có cột `release_ends_at` trong DB, hãy dùng nó.
            'release_end_timestamp' => $release_ends_at->timestamp,
            // Giả định trạng thái (có thể lấy từ cột `stock` của DB)
            'current_status' => ($product->stock > 0) ? 'AVAILABLE' : 'SOLD OUT',
            // Giả định giá bán lại (nếu không có trong DB, bạn phải dùng mock hoặc thêm cột)
            'resale_value' => 4500000, 
        ]);
    }
}