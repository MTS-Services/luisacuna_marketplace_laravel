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

public function getUsersSortedByLastMessage($authId)
{
    $users = User::where('id', '!=', $authId)->get();

    foreach ($users as $user) {

        // Unread Count
        $user->unreadCount = OrderMessage::where('sender_id', $user->id)
            ->where('receiver_id', $authId)
            ->where('is_seen', false)
            ->count();

        // Last Message
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

    // Sort by last message date descending
    return $users->sortByDesc(function ($u) {
        return $u->lastMessage->created_at ?? null;
    })->values();
}



    public function sendOrderMessage($senderId, $receiverId, $message = null, $media = null)
    {
        return OrderMessage::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'media' => $media,
        ]);
    }


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

    public function markAsSeen($senderId, $receiverId)
    {
        OrderMessage::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->update(['is_seen' => true]);
    }
}
