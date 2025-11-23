<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Ensure Product model exists
use Carbon\Carbon; // Needed for timestamp calculations if release end isn't stored in DB

class LimitedController extends Controller
{
    public function index()
    {
        // 1. Find product by slug
        $product = Product::where('slug', 'converse-chuck-70-renew-x-a-trak')->first();

        // 2. Handle missing product (optional)
        if (!$product) {
            // You can abort with 404 or return an error view
            abort(404, 'Limited edition product not found.');
        }

        // 3. Prepare additional data for the view (if needed)
        // Example: compute Release End Timestamp. If stored in DB, this is unnecessary.
        // Here we assume 7 days from now (or use a `release_ends_at` DB column).
        $release_ends_at = Carbon::now()->addDays(7); 
        
        // Truyền dữ liệu sang View
        return view('limited.index', [
            'product' => $product,
            // Add timestamp for JS countdown. Use DB column if available.
            'release_end_timestamp' => $release_ends_at->timestamp,
            // Assume status (derive from `stock` column in DB)
            'current_status' => ($product->stock > 0) ? 'AVAILABLE' : 'SOLD OUT',
            // Assumed resale value (use DB column or compute in real data)
            'resale_value' => 4500000,
        ]);
    }
}