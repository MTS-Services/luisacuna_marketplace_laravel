<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Models\Message;
use App\Enums\MessageType;
use Illuminate\Support\Str;
use App\Models\Conversation;
use App\Enums\ParticipantRole;
use App\Enums\ConversationStatus;
use App\Models\MessageAttachment;
use App\Models\MessageReadReceipt;
use Illuminate\Support\Facades\Auth;
use App\Models\ConversationParticipant;

class OrderMessageService
{
    public function __construct() {}

    /**
     * Get conversations sorted by last message for auth participant
     */
    public function getParticipantsSortedByLastMessage($authParticipant)
    {

        // $participant = ConversationParticipant::get()->all();

        // dd($participant);

        $participantId = $authParticipant->id;
        
        $participantRole = get_class($authParticipant);
        $conversationIds = ConversationParticipant::where([
            'participant_id' => $participantId,
            'participant_role' => $participantRole,
        ]);
        // dd($conversationIds);
        $otherParticipants = ConversationParticipant::whereIn('conversation_id', $conversationIds)
            ->where(function ($q) use ($participantId, $participantRole) {
                $q->where('participant_id', '!=', $participantId)
                    ->orWhere('participant_role', '!=', $participantRole);
            })
            ->with(['participant', 'conversation'])
            ->get();

        foreach ($otherParticipants as $row) {
            $conversation = $row->conversation;

            $row->unreadCount = $this->getUnreadCount(
                $conversation->id,
                $participantId,
                $participantRole
            );
            $row->lastMessage = Message::where('conversation_id', $conversation->id)
                ->with(['sender', 'attachments'])
                ->latest()
                ->first();

            if ($row->lastMessage) {
                $row->lastMessage->created_at_formatted = $row->lastMessage->created_at->diffForHumans();
            }

            $row->conversation_uuid = $conversation->conversation_uuid;
        }

        return $otherParticipants->sortByDesc(function ($p) {
            return $p->lastMessage->created_at ?? null;
        })->values();
    }



    

    /**
     * Get or create conversation between two participants
     */
    public function getOrCreateConversation($p1, $p2)
    {
        $conversation = $this->findConversationBetweenParticipants(
            $p1->id,
            get_class($p1),
            $p2->id,
            get_class($p2)
        );

        if ($conversation) {
            return $conversation;
        }

        $conversation = Conversation::create([
            'conversation_uuid' => Str::uuid(),
            'status' => ConversationStatus::ACTIVE,
            'last_message_at' => now(),
            'creater_id' => $p1->id,
            'creater_type' => get_class($p1),
        ]);

        $this->addParticipant($conversation->id, $p1, ParticipantRole::BUYER);
        $this->addParticipant($conversation->id, $p2, ParticipantRole::SELLER);

        return $conversation;
    }

    /**
     * Find conversation between two participants
     */
    private function findConversationBetweenParticipants(
        int $id1,
        string $type1,
        int $id2,
        string $type2
    ) {
        $c1 = ConversationParticipant::where([
            'participant_id' => $id1,
            'participant_role' => $type1,
            'is_active' => true,
        ])->pluck('conversation_id');

        $c2 = ConversationParticipant::where([
            'participant_id' => $id2,
            'participant_role' => $type2,
            'is_active' => true,
        ])->pluck('conversation_id');

        $conversationId = $c1->intersect($c2)->first();

        return $conversationId ? Conversation::find($conversationId) : null;
    }

    /**
     * Add participant to conversation
     */
    private function addParticipant(int $conversationId, $participant, $role)
    {
        return ConversationParticipant::create([
            'conversation_id' => $conversationId,
            'participant_id' => $participant->id,
            'participant_type' => get_class($participant),
            'participant_role' => $role,
            'joined_at' => now(),
            'is_active' => true,
            'notification_enabled' => true,
            'creater_id' => $participant->id,
            'creater_type' => get_class($participant),
        ]);
    }

    /**
     * Send message
     */
    public function send(int $conversationId, string $messageBody, $attachments = null, $messageType = null)
    {
        $sender = auth()->user();

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $sender->id,
            'sender_type' => get_class($sender),
            'message_type' => $messageType ?? MessageType::TEXT,
            'message_body' => $messageBody,
            'creater_id' => $sender->id,
            'creater_type' => get_class($sender),
        ]);

        if ($attachments) {
            foreach ($attachments as $attachment) {
                MessageAttachment::create([
                    'message_id' => $message->id,
                    'attachment_type' => $attachment['type'] ?? 'file',
                    'file_path' => $attachment['path'],
                    'thumbnail_path' => $attachment['thumbnail'] ?? null,
                    'creater_id' => $sender->id,
                    'creater_type' => get_class($sender),
                ]);
            }
        }

        Conversation::where('id', $conversationId)->update([
            'last_message_at' => now(),
        ]);

        return $message;
    }

    /**
     * Fetch messages
     */
    public function fetch(int $conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->with(['sender', 'attachments', 'readReceipts.participant'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(int $conversationId, $participant)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->where(function ($q) use ($participant) {
                $q->where('sender_id', '!=', $participant->id)
                    ->orWhere('sender_type', '!=', get_class($participant));
            })
            ->whereDoesntHave('readReceipts', function ($q) use ($participant) {
                $q->where([
                    'participant_id' => $participant->id,
                    'participant_role' => get_class($participant),
                ]);
            })
            ->get();

        foreach ($messages as $message) {
            MessageReadReceipt::create([
                'message_id' => $message->id,
                'participant_id' => $participant->id,
                'participant_role' => get_class($participant),
                'read_at' => now(),
                'creater_id' => $participant->id,
                'creater_type' => get_class($participant),
            ]);
        }

        ConversationParticipant::where([
            'conversation_id' => $conversationId,
            'participant_id' => $participant->id,
            'participant_role' => get_class($participant),
        ])->update(['last_read_at' => now()]);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(int $conversationId, int $participantId, string $participantRole)
    {
        return Message::where('conversation_id', $conversationId)
            ->where(function ($q) use ($participantId, $participantRole) {
                $q->where('sender_id', '!=', $participantId)
                    ->orWhere('sender_type', '!=', $participantRole);
            })
            ->whereDoesntHave('readReceipts', function ($q) use ($participantId, $participantRole) {
                $q->where([
                    'participant_id' => $participantId,
                    'participant_role' => $participantRole,
                ]);
            })
            ->count();
    }

    /**
     * Leave conversation
     */
    public function leaveConversation(int $conversationId, $participant)
    {
        return ConversationParticipant::where([
            'conversation_id' => $conversationId,
            'participant_id' => $participant->id,
            'participant_role' => get_class($participant),
        ])->update([
            'is_active' => false,
            'left_at' => now(),
        ]);
    }

    /**
     * Edit message
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
     * Delete message
     */
    public function deleteMessage(int $messageId)
    {
        return Message::findOrFail($messageId)->delete();
    }
}
