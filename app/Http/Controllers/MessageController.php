<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function getChatUsers()
    {
        try {
            $userId = session('id');

            // Get users that current user follows or is followed by
            $users = User::select('users.*')
                ->join('follows', function($join) use ($userId) {
                    $join->on('users.id', '=', 'follows.following_id')
                         ->where('follows.follower_id', '=', $userId)
                         ->orOn('users.id', '=', 'follows.follower_id')
                         ->where('follows.following_id', '=', $userId);
                })
                ->where('users.id', '!=', $userId)
                ->selectRaw('CASE 
                    WHEN EXISTS (
                        SELECT 1 FROM follows 
                        WHERE follower_id = ? AND following_id = users.id
                    ) THEN "following"
                    ELSE "follower"
                END as relationship', [$userId])
                ->distinct()
                ->get();

            return response()->json($users);
        } catch (\Exception $e) {
            \Log::error('Error in getChatUsers: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching users'], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $content = $request->getContent();
            $data = json_decode($content, true);

            if (!$data) {
                return response()->json(['error' => 'Invalid JSON data'], 400);
            }

            $message = Message::create([
                'sender_id' => session('id'),
                'receiver_id' => $data['receiver_id'],
                'message' => $data['content'], // Changed to use 'message' column
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'error' => 'Error sending message: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMessages($userId)
    {
        try {
            $currentUserId = session('id');
            
            $messages = Message::where(function($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
            })->orWhere(function($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

            return response()->json([
                'messages' => $messages,
                'currentUserId' => $currentUserId
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching messages: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching messages'], 500);
        }
    }
}
