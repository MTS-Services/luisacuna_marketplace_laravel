<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin; // ✅ Admin model import করুন
use App\Models\Message;
use App\Models\MessageParticipant;
use App\Models\OrderMessage;

class OrderMessageService
{
    public function __construct() {}

    public function getUsersSortedByLastMessage($authId, $searchTerm = null)
    {


        $conversationUserIds = Message::where(function ($q) use ($authId) {
            $q->where('sender_id', $authId)
                ->orWhere('receiver_id', $authId);
        })
            ->whereHas('orderMessages')
            ->get()
            ->map(function ($conversation) use ($authId) {
                return $conversation->sender_id == $authId
                    ? $conversation->receiver_id
                    : $conversation->sender_id;
            })
            ->unique()
            ->filter();

        $query = User::whereIn('id', $conversationUserIds);

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
                $q->where(function ($qq) use ($user, $authId) {
                    $qq->where('sender_id', $user->id)
                        ->where('receiver_id', $authId);
                })->orWhere(function ($qq) use ($user, $authId) {
                    $qq->where('sender_id', $authId)
                        ->where('receiver_id', $user->id);
                });
            })
                ->where('creater_id', $user->id)
                ->whereNull('seen_at')
                ->count();

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

            if ($user->lastMessage) {
                $user->lastMessage->created_at_formatted = $user->lastMessage->created_at->diffForHumans();
            }
        }

        return $users->sortByDesc(function ($u) {
            return $u->lastMessage->created_at ?? null;
        })->values();
    }

    public function getOrCreateConversation(int $buyerId, int $sellerId)
    {
        $existingMessage = Message::where(function ($q) use ($buyerId, $sellerId) {
            $q->where('sender_id', $buyerId)
                ->where('receiver_id', $sellerId);
        })
            ->orWhere(function ($q) use ($buyerId, $sellerId) {
                $q->where('sender_id', $sellerId)
                    ->where('receiver_id', $buyerId);
            })
            ->first();

        if ($existingMessage) {
            return $existingMessage;
        }

        $message = Message::create([
            'message_id' => uniqid('msg_'),
            'sender_id'   => $buyerId,
            'receiver_id' => $sellerId,
        ]);

        $buyer = User::find($buyerId);
        $seller = User::find($sellerId);

        if ($buyer && $seller) {
            MessageParticipant::create([
                'message_id'       => $message->id,
                'participant_id'   => $buyer->id,
                'participant_type' => User::class,
            ]);

            MessageParticipant::create([
                'message_id'       => $message->id,
                'participant_id'   => $seller->id,
                'participant_type' => User::class,
            ]);
        }

        return $message;
    }

    /**
     * 
     */
    public function send(int $messageId, string $text, $attachments = null)
    {
        $user = auth()->user();

        return OrderMessage::create([
            'message_id'  => $messageId,
            'message'     => $text,
            'attachments' => $attachments,
            'creater_id'  => $user->id,
            'creater_type' => get_class($user),
        ]);
    }

    public function fetch(int $messageId)
    {
        return OrderMessage::where('message_id', $messageId)
            ->with(['conversation.sender', 'conversation.receiver', 'creator'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function seen(int $conversationId, int $currentUserId)
    {
        OrderMessage::where('message_id', $conversationId)
            ->where('creater_id', '!=', $currentUserId)
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);
    }
}
