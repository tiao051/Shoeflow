<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Models\Faq;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $user = Auth::user();
        
        // Determine if the user is an admin or a regular customer
        $isAdmin = $user->role_id === 2; // Assuming role_id 2 is Admin
        
        if ($isAdmin && $request->filled('target_user_id')) {
            $targetUserId = $request->target_user_id;
            $broadCastChannel = $targetUserId;
        } else {
            $targetUserId = $user->id;
            $broadCastChannel = $user->id;
        }

        try {
            // 1. Save User Message
            $message = Message::create([
                'user_id'  => $targetUserId,
                'message'  => $request->message,
                'is_admin' => $isAdmin,
                'is_read'  => false,
            ]);

            // Broadcast to Pusher/Reverb
            broadcast(new MessageSent($message, $broadCastChannel))->toOthers();

            // 2. AI BOT LOGIC (Only runs when a regular User sends a message)
            if (!$isAdmin) {
                // Trigger AI processing
                $this->processAIBotResponse($request->message, $targetUserId, $broadCastChannel);
            }

            return response()->json(['status' => 'Message Sent!', 'message' => $message]);

        } catch (\Exception $e) {
            Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

/**
     * Process response using RAG (Retrieval-Augmented Generation) logic
     * Feature: Smart Product Search based on user keywords
     */
    private function processAIBotResponse($userMessage, $userId, $channel)
    {
        // --- STEP 1: RETRIEVAL (The "R" in RAG) ---
        // Instead of blindly taking the first 20 products, we search for what the user wants.

        // 1.1 Simple Keyword Extraction
        // Split message into words, remove symbols, filter out short words (< 3 chars)
        $cleanMessage = preg_replace('/[^\p{L}\p{N}\s]/u', '', $userMessage);
        $words = explode(' ', $cleanMessage);
        $keywords = array_filter($words, function($w) {
            return mb_strlen($w) > 3; // Only take words longer than 3 characters
        });

        // 1.2 Search in Database
        $productQuery = Product::where('is_active', 1);

        if (!empty($keywords)) {
            $productQuery->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    // Search in Name, Color, or Description
                    $q->orWhere('name', 'LIKE', "%{$word}%")
                      ->orWhere('color', 'LIKE', "%{$word}%")
                      ->orWhere('description', 'LIKE', "%{$word}%");
                }
            });
        }

        // Get top 10 relevant products. 
        // If keywords find nothing, this might return empty, handled below.
        $matchedProducts = $productQuery->limit(10)->get();

        // 1.3 Fallback mechanism
        // If search yields no results (or user just said "Hello"), grab 5 'Best Sellers' or 'Newest' items
        // so the AI always has something to talk about.
        if ($matchedProducts->count() < 2) {
            $fallbackProducts = Product::where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            $matchedProducts = $matchedProducts->merge($fallbackProducts);
        }

        // --- STEP 2: CONTEXT PREPARATION ---

        $databaseContext = "--- RELEVANT PRODUCTS FOUND IN WAREHOUSE ---\n";
        foreach ($matchedProducts as $p) {
            $price = number_format($p->sale_price ?? $p->price);
            $databaseContext .= "- ID: {$p->id} | Name: {$p->name} | Color: {$p->color} | Price: {$price} VND | Stock: {$p->stock}\n";
        }

        // Add FAQs (Always useful)
        $faqs = Faq::all();
        $databaseContext .= "\n--- STORE POLICIES (FAQ) ---\n";
        foreach ($faqs as $f) {
            $databaseContext .= "- {$f->keyword}: {$f->answer}\n";
        }

        // Add Chat History (Context Memory)
        $recentMessages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        $historyContext = "\n--- CONVERSATION HISTORY ---\n";
        foreach ($recentMessages as $msg) {
            $role = $msg->is_admin ? "Bot" : "User";
            $historyContext .= "{$role}: " . strip_tags($msg->message) . "\n";
        }

        // --- STEP 3: GENERATION (The "G" in RAG) ---
        
        $systemInstruction = "You are 'Kai' - a professional, witty AI stylist for Converse ShoesDelRey.

        YOUR GOAL: Help the user find the right shoe or answer their question.

        DATA SOURCE:
        - I have searched the warehouse and provided 'RELEVANT PRODUCTS' above based on the user's query.
        - Use ONLY these products to make recommendations.
        - If the 'RELEVANT PRODUCTS' list doesn't match the user's specific request (e.g., User asked for 'Pink' but list has 'Black'), apologize and offer the available items in the list instead.

        GUIDELINES:
        1. LANGUAGE: Answer strictly in ENGLISH.
        2. STYLE: Short, concise, friendly. Use emojis occasionally 👟.
        3. FORMAT: key details like <b>Product Name</b> and <b>Price</b>.
        4. SALES TACTIC: If you suggest a shoe, mention one key feature (e.g., 'Great for running', 'Classic style').
        5. HONESTY: Do not invent products. If it's not in the list, we don't have it.
        
        USER QUESTION: {$userMessage}";

        // Combine logic
        $fullPrompt = $systemInstruction . "\n\n" . $databaseContext . "\n" . $historyContext;

        // Call Gemini
        $aiReply = $this->callGeminiAPI($fullPrompt, ""); // Empty 2nd arg since we merged it

        // Fallback
        if (!$aiReply) {
            $aiReply = "I'm having a bit of trouble checking the warehouse right now. Please try again in a moment! 😓";
        }

        // --- STEP 4: SENDING MESSAGE ---
        
        $prefix = "<b>[Kai - AI Stylist]</b><br>";
        $finalMessage = $prefix . $aiReply;

        // Anti-loop (Simple check)
        $lastBotMsg = Message::where('user_id', $userId)->where('is_admin', true)->latest()->first();
        if ($lastBotMsg && $lastBotMsg->message === $finalMessage) {
            $finalMessage = $prefix . "Let me know if you need help with anything else!";
        }

        $botMessage = Message::create([
            'user_id'  => $userId,
            'message'  => $finalMessage,
            'is_admin' => true,
            'is_read'  => false,
        ]);

        broadcast(new MessageSent($botMessage, $channel));
    }

    /**
     * Call Google Gemini API via HTTP
     */
    private function callGeminiAPI($context, $userQuestion)
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) return null;
        
        // Using the Gemini 2.5 Flash model as requested
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        try {
            // Added withoutVerifying() to handle local SSL certificate issues
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    "contents" => [
                        [
                            "parts" => [
                                ["text" => $context . "\n\nUSER QUESTION: " . $userQuestion]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                // Extract text from Gemini JSON structure
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }
            
            Log::error('Gemini API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini Connection Error: ' . $e->getMessage());
            return null;
        }
    }

    // --- Standard Methods ---

    public function fetchMessages()
    {
        return Message::where('user_id', Auth::id())->get();
    }

    public function adminConversations()
    {
        $users = User::whereHas('messages')
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('is_admin', false)->where('is_read', false);
            }])
            ->with(['messages' => function($q) {
                $q->latest()->limit(1); 
            }])
            ->get()
            ->sortByDesc(function($user) {
                return $user->messages->first()->created_at ?? 0;
            })
            ->values();

        return response()->json($users);
    }

    public function adminFetchMessages($userId)
    {
        return Message::where('user_id', $userId)->get();
    }
    
    public function markAsRead(Request $request)
    {
        $userId = $request->user_id;
        Message::where('user_id', $userId)
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
    
    public function adminIndex() {
        return view('admin.chat.index');
    }
}