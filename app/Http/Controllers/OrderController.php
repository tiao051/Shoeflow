// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($id)
    {
        // Tìm đơn hàng, nhưng PHẢI check xem đơn đó có thuộc về user đang đăng nhập không
        $order = Order::with('items.product') // Load kèm sản phẩm để hiển thị
                      ->where('id', $id)
                      ->where('user_id', Auth::id()) // QUAN TRỌNG: Không cho xem đơn người khác
                      ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}