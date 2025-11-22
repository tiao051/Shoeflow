<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('product')->latest()->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        // Check authentication
        if (!Auth::check()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Please login first.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add items to wishlist.');
        }

        $data = [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ];

        // Check duplicates
        if (!Wishlist::where($data)->exists()) {
            Wishlist::create($data);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'ITEM ADDED TO COLLECTION'
                ]);
            }

            return redirect()->back()->with('success', 'Product added to wishlist!');
        }

        // Already exists
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'info',
                'message' => 'ALREADY IN YOUR COLLECTION'
            ]);
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