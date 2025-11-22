<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Retrieve the current user's wishlist items with product relation
        $wishlistItems = Auth::user()->wishlistItems()->with('product')->latest()->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        // Ensure the user is authenticated (route may already have middleware)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to wishlist.');
        }

        $data = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ];

        // Prevent duplicates: only create if the entry doesn't already exist
        if (!Wishlist::where($data)->exists()) {
            Wishlist::create($data);

            return redirect()->back()->with('success', 'Product added to wishlist!');
        }

        return redirect()->back()->with('info', 'This product is already in your wishlist.');
    }

    public function destroy(Request $request, $id)
    {
        $wishlist = Wishlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $wishlist->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from wishlist.'
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}