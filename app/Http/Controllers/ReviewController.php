<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'You have already reviewed this product.',
                'has_reviewed' => true 
            ], 409); 
        }
        // --- PURCHASE VERIFICATION LOGIC (Example) ---
        // $hasPurchased = Order::where('user_id', $user->id)
        //     ->whereHas('items', function($q) use ($request) {
        //         $q->where('product_id', $request->product_id);
        //     })
        //     ->where('status', 'delivered') // Only allow if delivered
        //     ->exists();
        
        // if (!$hasPurchased) {
        //     return response()->json(['error' => 'You must purchase and receive this product to review it.'], 403);
        // }

        $review = Review::create([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_visible' => true
        ]);

        return response()->json(['message' => 'Review submitted successfully!', 'data' => $review]);
    }

    /**
     * ADMIN: AI Business Intelligence Analysis
     */
    public function analyzeReviews()
    {
        // 1. Fetch recent reviews (e.g., last 100) to analyze trends
        $reviews = Review::with('product:id,name')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json(['html' => '<p class="text-gray-500">Not enough data for analysis.</p>']);
        }

        // 2. Prepare Data for Context
        $reviewsText = "";
        foreach ($reviews as $r) {
            $productName = $r->product->name ?? 'Unknown Product';
            $comment = $r->comment ?: "No comment";
            $reviewsText .= "- Product: {$productName} | Rating: {$r->rating}/5 | Comment: {$comment}\n";
        }

        // 3. Build Prompt for Business Analyst Persona
        $systemInstruction = "You are a Senior Business Analyst for an E-commerce Shoe Store. 
        Your task is to analyze customer reviews and provide a strategic report for the Admin Panel.

        DATA TO ANALYZE:
        {$reviewsText}

        OUTPUT FORMAT:
        Return ONLY valid HTML (without ```html tags). Structure the report as follows:
        
        <div class='space-y-4'>
            <div class='p-4 bg-blue-50 rounded-lg'>
                <h3 class='font-bold text-blue-800 text-lg mb-2'>Executive Summary</h3>
                <p>...Summarize the overall sentiment (Positive/Negative/Neutral)...</p>
            </div>

            <div class='grid grid-cols-2 gap-4'>
                <div class='p-4 bg-green-50 rounded-lg'>
                    <h4 class='font-bold text-green-800'>Key Strengths</h4>
                    <ul class='list-disc list-inside text-sm mt-2'>
                        <li>...Point 1...</li>
                        <li>...Point 2...</li>
                    </ul>
                </div>
                <div class='p-4 bg-red-50 rounded-lg'>
                    <h4 class='font-bold text-red-800'>Areas for Improvement</h4>
                    <ul class='list-disc list-inside text-sm mt-2'>
                        <li>...Point 1...</li>
                        <li>...Point 2...</li>
                    </ul>
                </div>
            </div>

            <div class='p-4 bg-purple-50 rounded-lg border border-purple-100'>
                <h3 class='font-bold text-purple-800 text-lg mb-2'>Strategic Development Plan</h3>
                <p class='mb-2 text-sm text-gray-600'>Based on the feedback, here are actionable steps:</p>
                <ul class='space-y-2'>
                     <li class='flex items-start'><span class='mr-2'>👉</span><span>...Actionable Step 1...</span></li>
                     <li class='flex items-start'><span class='mr-2'>👉</span><span>...Actionable Step 2...</span></li>
                     <li class='flex items-start'><span class='mr-2'>👉</span><span>...Actionable Step 3...</span></li>
                </ul>
            </div>
        </div>

        Keep the tone professional, objective, and constructive. English language only.";

        // 4. Call Gemini API
        $analysisHtml = $this->callGeminiAPI($systemInstruction);

        return response()->json(['html' => $analysisHtml]);
    }

    private function callGeminiAPI($prompt)
    {
        $apiKey = config('services.gemini.api_key');
        $url = "[https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=](https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=){$apiKey}";

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    "contents" => [
                        ["parts" => [["text" => $prompt]]]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Error generating analysis.';
            }
            return 'API Error: ' . $response->body();
        } catch (\Exception $e) {
            return 'Connection Error: ' . $e->getMessage();
        }
    }

    /**
     * Get review summary and list for a specific product ID.
     */
    public function getReviewsSummary($productId)
    {
        // 1. Calculate Summary
        $summary = Review::where('product_id', $productId)
            ->where('is_visible', true)
            ->select(DB::raw('AVG(rating) as average_rating'), DB::raw('COUNT(id) as total_reviews'))
            ->first();

        $averageRating = round($summary->average_rating, 1);
        $totalReviews = $summary->total_reviews;

        // 2. Get review list
        $reviews = Review::where('product_id', $productId)
            ->where('is_visible', true) 
            ->with('user:id,name,avatar') 
            ->orderBy('created_at', 'desc')
            ->limit(5) // Limit to top 5 reviews for brevity
            ->get();

        return response()->json([
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
            'reviews' => $reviews
        ]);
    }
}