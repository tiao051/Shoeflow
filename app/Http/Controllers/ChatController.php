<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // USER & ADMIN: Send message
   public function sendMessage(Request $request)
    {
        // 1. Validate input
        $request->validate(['message' => 'required|string']);

        // 2. Check authentication
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $isAdmin = $user->role_id === 2;
        
        // 3. FIX LOGIC: Determine target_user_id
        // If Admin AND target_user_id is provided (i.e., chatting from admin panel), use that ID.
        // Otherwise (Regular User OR Admin testing on the main site), use the logged-in user's own ID.
        if ($isAdmin && $request->filled('target_user_id')) {
            $targetUserId = $request->target_user_id;
        } else {
            $targetUserId = $user->id;
        }

        // 4. Create message
        try {
            $message = Message::create([
                'user_id'  => $targetUserId,
                'message'  => $request->message,
                'is_admin' => $isAdmin,
                'is_read'  => false, // Add this line to ensure the field is not missing
            ]);

            // 5. Broadcast (Wrap in try-catch so if Pusher/Redis fails, message still sends)
            try {
                broadcast(new MessageSent($message))->toOthers();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Broadcast error: ' . $e->getMessage());
                // Do not throw error to avoid making user think sending failed
            }

            return response()->json(['status' => 'Message Sent!', 'message' => $message]);

        } catch (\Exception $e) {
            // Log actual error to file for debugging
            \Illuminate\Support\Facades\Log::error('Chat Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // USER: Fetch user messages
    public function fetchMessages()
    {
        return Message::where('user_id', Auth::id())->get();
    }

    // ADMIN: Fetch list of users who have sent messages
    public function adminConversations()
    {
        // Fetch users who have sent messages, sorted by the latest message
        $users = User::whereHas('messages')
            ->with(['messages' => function($q) {
                $q->latest()->limit(1); // Fetch the latest message only
            }])
            ->get()
            ->sortByDesc(function($user) {
                return $user->messages->first()->created_at ?? 0;
            })
            ->values();

        return response()->json($users);
    }

    // ADMIN: Fetch messages of a specific user
    public function adminFetchMessages($userId)
    {
        return Message::where('user_id', $userId)->get();
    }
    
    // ADMIN: View chat page
    public function adminIndex() {
        return view('admin.chat.index');
    }
}