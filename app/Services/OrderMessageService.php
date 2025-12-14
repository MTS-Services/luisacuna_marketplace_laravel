<?php

namespace App\Services;

use App\Models\User;
use App\Models\Message;
use App\Models\MessageParticipant;
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
            $user->unreadCount = OrderMessage::whereHas('message', function ($q) use ($user, $authId) {
                $q->where('sender_id', $user->id)
                    ->where('receiver_id', $authId);
            })
            ->whereNull('seen_at')
            ->count();

            // Get last message between these two users
            $user->lastMessage = OrderMessage::whereHas('message', function ($q) use ($user, $authId) {
                $q->where(function ($query) use ($user, $authId) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $authId);
                })
                ->orWhere(function ($query) use ($user, $authId) {
                    $query->where('sender_id', $authId)
                        ->where('receiver_id', $user->id);
                });
            })
            ->with('message')
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
    public function sendOrderMessage($senderId, $receiverId, $messageText = null, $attachments = null, $isSystemMessage = false)
    {

        $message = Message::create([
            'message_id' => uniqid('msg_', true),
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
        ]);


        MessageParticipant::create([
            'message_id' => $message->id,
            'participant_id' => $senderId,
            'participant_type' => User::class,
        ]);

        MessageParticipant::create([
            'message_id' => $message->id,
            'participant_id' => $receiverId,
            'participant_type' => User::class,
        ]);


        $orderMessage = OrderMessage::create([
            'message_id' => $message->id,
            'message' => $messageText,
            'attachments' => $attachments,
            'is_system_message' => $isSystemMessage,
        ]);

        return $orderMessage->load('message');
    }

    /**
     * Get conversation messages
     */
    // public function getMessages($currentUserId, $otherUserId)
    // {
    //     return OrderMessage::whereHas('messageRelation', function ($q) use ($currentUserId, $otherUserId) {
    //         $q->where(function ($query) use ($currentUserId, $otherUserId) {
    //             $query->where('sender_id', $currentUserId)
    //                 ->where('receiver_id', $otherUserId);
    //         })
    //         ->orWhere(function ($query) use ($currentUserId, $otherUserId) {
    //             $query->where('sender_id', $otherUserId)
    //                 ->where('receiver_id', $currentUserId);
    //         });
    //     })
    //     ->with(['messageRelation.sender', 'messageRelation.receiver'])
    //     ->orderBy('created_at', 'asc')
    //     ->get();
    // }

    /**
     * Mark messages as seen
     */
    // public function markAsSeen($senderId, $receiverId)
    // {
    //     OrderMessage::whereHas('messageRelation', function ($q) use ($senderId, $receiverId) {
    //         $q->where('sender_id', $senderId)
    //             ->where('receiver_id', $receiverId);
    //     })
    //     ->whereNull('seen_at')
    //     ->update(['seen_at' => now()]);
    // }
}