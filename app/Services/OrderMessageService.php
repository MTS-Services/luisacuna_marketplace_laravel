<?php

namespace App\Services;

use App\Models\User;
use App\Models\OrderMessage;

class OrderMessageService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * Get users sorted by last message with optional search
     */
    public function getUsersSortedByLastMessage($authId, $searchTerm = null)
    {
        $query = User::where('id', '!=', $authId);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            });
        }


        $users = $query->get();

        foreach ($users as $user) {
            $user->unreadCount = OrderMessage::where('sender_id', $user->id)
                ->where('receiver_id', $authId)
                ->where('is_seen', false)
                ->count();

            $user->lastMessage = OrderMessage::where(function ($q) use ($user, $authId) {
                $q->where('sender_id', $user->id)
                    ->where('receiver_id', $authId);
            })
                ->orWhere(function ($q) use ($user, $authId) {
                    $q->where('sender_id', $authId)
                        ->where('receiver_id', $user->id);
                })
                ->latest()
                ->first();
        }
        return $users->sortByDesc(function ($u) {
            return $u->lastMessage->created_at ?? null;
        })->values();
    }

    /**
     * Send a message
     */
    public function sendOrderMessage($senderId, $receiverId, $message = null, $media = null)
    {
        return OrderMessage::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'media' => $media,
        ]);
    }

    /**
     * Get conversation messages
     */
    public function getMessages($currentUserId, $otherUserId)
    {
        return OrderMessage::where(function ($q) use ($currentUserId, $otherUserId) {
            $q->where('sender_id', $currentUserId)->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($q) use ($currentUserId, $otherUserId) {
                $q->where('sender_id', $otherUserId)->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Mark messages as seen
     */
    public function markAsSeen($senderId, $receiverId)
    {
        OrderMessage::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->update(['is_seen' => true]);
    }
}
