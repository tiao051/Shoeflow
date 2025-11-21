<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Xem wishlist
    public function index()
    {
        $user = auth()->user();
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->paginate(12);

        return view('wishlist', compact('wishlistItems'));
    }

    // Thêm vào wishlist
    public function add(Request $request)
    {
        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$existingWishlist) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return response()->json(['message' => 'Sản phẩm đã thêm vào wishlist'], 200);
        }

        return response()->json(['message' => 'Sản phẩm đã có trong wishlist'], 200);
    }

    // Xóa khỏi wishlist
    public function remove($productId)
    {
        $user = auth()->user();
        Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi wishlist');
    }

    // Kiểm tra có trong wishlist không (AJAX)
    public function check($productId)
    {
        $user = auth()->user();
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        return response()->json(['in_wishlist' => $exists]);
    }
}