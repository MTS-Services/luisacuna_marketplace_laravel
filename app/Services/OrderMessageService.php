<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\MessageReadReceipt;
use App\Models\MessageAttachment;
use App\Enums\ConversationStatus;
use App\Enums\ParticipantRole;
use App\Enums\MessageType;
use Illuminate\Support\Str;

class OrderMessageService
{
    public function __construct() {}

    /**
     * Get all conversations for authenticated user, sorted by last message
     * 
     * 
     */
    public function getUsersSortedByLastMessage($authUserId, $searchTerm = null)
    {
        $conversationIds = ConversationParticipant::where('user_id', $authUserId)
            ->where('is_active', true)
            ->pluck('conversation_id');

        $otherParticipants = ConversationParticipant::whereIn('conversation_id', $conversationIds)
            ->where('user_id', '!=', $authUserId)
            ->where('is_active', true)
            ->with(['user', 'conversation'])
            ->get();


        $userIds = $otherParticipants->pluck('user_id')->unique();
        $query = User::whereIn('id', $userIds);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            });
        }

        $users = $query->get();

        foreach ($users as $user) {
            $conversation = $this->findConversationBetweenUsers($authUserId, $user->id);

            if ($conversation) {
                $user->unreadCount = $this->getUnreadCount($conversation->id, $authUserId);

                $user->lastMessage = Message::where('conversation_id', $conversation->id)
                    ->with(['sender', 'attachments'])
                    ->latest()
                    ->first();

                if ($user->lastMessage) {
                    $user->lastMessage->created_at_formatted = $user->lastMessage->created_at->diffForHumans();
                }
                $user->conversation_id = $conversation->id;
                $user->conversation_uuid = $conversation->conversation_uuid;
            }
        }

        return $users->sortByDesc(function ($u) {
            return $u->lastMessage->created_at ?? null;
        })->values();
    }
    public function getPaginated($perPage, $filters)
    {
        $query = Conversation::query()
            ->with([
                'conversation_participants.user',
                'messages' => function ($q) {
                    $q->latest()->limit(1);
                },
                'messages.sender'
            ]);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('subject', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('note', 'like', '%' . $filters['search'] . '%')
                    ->orWhereHas('product', function ($q) use ($filters) {
                        $q->where('name', 'like', '%' . $filters['search'] . '%');
                    });
            });
        }

        $sortField = $filters['sort_field'] ?? 'last_message_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    /**
     * Admin: Fetch full conversation messages (both users)
     */
    public function fetchForAdmin(int $conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->with([
                'sender:id,username,first_name,last_name',
                'attachments'
            ])
            ->orderBy('created_at', 'asc')
            ->get();
    }


    /**
     * Get or create conversation between two users
     * 
     *
     */
    public function getOrCreateConversation(int $userId1, int $userId2)
    {
        // Check if conversation already exists
        $existingConversation = $this->findConversationBetweenUsers($userId1, $userId2);

        if ($existingConversation) {
            return $existingConversation;
        }

        // Create new conversation
        $conversation = Conversation::create([
            'conversation_uuid' => Str::uuid(),
            'status' => ConversationStatus::ACTIVE,
            'last_message_at' => now(),
            'creater_id' => $userId1,
            'creater_type' => User::class,
        ]);

        // Add both users as participants
        $this->addParticipant($conversation->id, $userId1, ParticipantRole::BUYER);
        $this->addParticipant($conversation->id, $userId2, ParticipantRole::SELLER);

        return $conversation;
    }

    /**
     * Find conversation between two users
     * 
     * @param int $userId1
     * @param int $userId2
     * @return Conversation|null
     */
    private function findConversationBetweenUsers(int $userId1, int $userId2)
    {
        $user1Conversations = ConversationParticipant::where('user_id', $userId1)
            ->where('is_active', true)
            ->pluck('conversation_id');

        $user2Conversations = ConversationParticipant::where('user_id', $userId2)
            ->where('is_active', true)
            ->pluck('conversation_id');

        $commonConversationId = $user1Conversations->intersect($user2Conversations)->first();

        if ($commonConversationId) {
            return Conversation::find($commonConversationId);
        }

        return null;
    }

    /**
     * Add participant to conversation
     * 
     */
    private function addParticipant(int $conversationId, int $userId, $role = null)
    {
        return ConversationParticipant::create([
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'participant_role' => $role ?? ParticipantRole::BUYER,
            'joined_at' => now(),
            'is_active' => true,
            'notification_enabled' => true,
            'creater_id' => $userId,
            'creater_type' => User::class,
        ]);
    }

    /**
     * Send a message in conversation
     * 
     */
    public function send(int $conversationId, string $messageBody, $attachments = null, $messageType = null)
    {
        $user = auth()->user();

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $user->id,
            'message_type' => $messageType ?? MessageType::TEXT,
            'message_body' => $messageBody,
            'creater_id' => $user->id,
            'creater_type' => get_class($user),
        ]);

        if ($attachments && is_array($attachments)) {
            foreach ($attachments as $attachment) {
                MessageAttachment::create([
                    'message_id' => $message->id,
                    'attachment_type' => $attachment['type'] ?? 'file',
                    'file_path' => $attachment['path'],
                    'thumbnail_path' => $attachment['thumbnail'] ?? null,
                    'creater_id' => $user->id,
                    'creater_type' => get_class($user),
                ]);
            }
        }

        Conversation::where('id', $conversationId)->update([
            'last_message_at' => now(),
        ]);

        return $message;
    }

    /**
     * Fetch all messages from a conversation
     * 
     */
    public function fetch(int $conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->with(['sender', 'attachments', 'readReceipts.user'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Mark messages as read/seen
     * 
     */
    public function markAsRead(int $conversationId, int $currentUserId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $currentUserId)
            ->whereDoesntHave('readReceipts', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            })
            ->get();

        foreach ($messages as $message) {
            MessageReadReceipt::create([
                'message_id' => $message->id,
                'user_id' => $currentUserId,
                'read_at' => now(),
                'creater_id' => $currentUserId,
                'creater_type' => User::class,
            ]);
        }

        ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $currentUserId)
            ->update(['last_read_at' => now()]);
    }

    /**
     * Get unread message count for a conversation
     * 
     */
    public function getUnreadCount(int $conversationId, int $userId)
    {
        return Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $userId)
            ->whereDoesntHave('readReceipts', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

    /**
     * Delete/Archive a conversation for a user
     * 
     * 
     */
    public function leaveConversation(int $conversationId, int $userId)
    {
        return ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $userId)
            ->update([
                'is_active' => false,
                'left_at' => now(),
            ]);
    }

    /**
     * Edit a message
     * 
     *
     */
    public function editMessage(int $messageId, string $newMessageBody)
    {
        $message = Message::findOrFail($messageId);

        $message->update([
            'message_body' => $newMessageBody,
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        return $message;
    }

    /**
     * Delete a message (soft delete)
     * 
     * 
     */
    public function deleteMessage(int $messageId)
    {
        $message = Message::findOrFail($messageId);
        return $message->delete();
    }
}
