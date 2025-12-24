<?php

namespace App\Services;

use App\Enums\ConversationStatus;
use App\Enums\MessageType;
use App\Enums\ParticipantRole;
use App\Events\ConversationUpdated;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\MessageReadReceipt;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConversationService
{
    public function __construct(
        protected Conversation $conversation,
        protected ConversationParticipant $participant,
        protected Message $message,
        protected MessageReadReceipt $readReceipt
    ) {}

    /**
     * Start a new conversation between two users
     */
    public function startConversation(
        User $participantOne,
        User $participantTwo,
        ?string $subject = null,
        ?string $note = null
    ): ?Conversation {
        try {
            // Check if conversation already exists between these users
            $existingConversation = $this->findExistingConversation($participantOne->id, $participantTwo->id);

            if ($existingConversation) {
                return $existingConversation;
            }

            return DB::transaction(function () use ($participantOne, $participantTwo, $subject, $note) {
                // Create conversation
                $conversation = $this->conversation->create([
                    'conversation_uuid' => Str::uuid(),
                    'subject' => $subject,
                    'note' => $note,
                    'status' => ConversationStatus::ACTIVE,
                    'creater_id' => $participantOne->id,
                    'creater_type' => User::class,
                ]);

                // Add participants
                $this->addParticipantToConversation($conversation, $participantOne, ParticipantRole::BUYER);
                $this->addParticipantToConversation($conversation, $participantTwo, ParticipantRole::SELLER);

                return $conversation->load('participants.participant');
            });
        } catch (Exception $e) {
            Log::error('Failed to start conversation', [
                'participant_one' => $participantOne->id,
                'participant_two' => $participantTwo->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Find existing conversation between two users
     */
    public function findExistingConversation(int $userOneId, int $userTwoId): ?Conversation
    {
        return $this->conversation
            ->whereHas('participants', function ($query) use ($userOneId) {
                $query->where('participant_id', $userOneId)
                    ->where('participant_type', User::class)
                    ->where('is_active', true);
            })
            ->whereHas('participants', function ($query) use ($userTwoId) {
                $query->where('participant_id', $userTwoId)
                    ->where('participant_type', User::class)
                    ->where('is_active', true);
            })
            ->whereDoesntHave('participants', function ($query) {
                $query->where('participant_role', ParticipantRole::ADMIN);
            })
            ->first();
    }

    /**
     * Add participant to conversation
     */
    public function addParticipant(
        Conversation $conversation,
        User $participant,
        ParticipantRole $role = ParticipantRole::BUYER
    ): ?ConversationParticipant {
        try {
            // Check if participant already exists
            $existingParticipant = $conversation->participants()
                ->where('participant_id', $participant->id)
                ->where('participant_type', User::class)
                ->first();

            if ($existingParticipant) {
                // Reactivate if inactive
                if (!$existingParticipant->is_active) {
                    $existingParticipant->update([
                        'is_active' => true,
                        'left_at' => null,
                        'joined_at' => now(),
                    ]);
                }
                return $existingParticipant;
            }

            return $this->addParticipantToConversation($conversation, $participant, $role);
        } catch (Exception $e) {
            Log::error('Failed to add participant', [
                'conversation_id' => $conversation->id,
                'participant_id' => $participant->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Internal method to add participant
     */
    protected function addParticipantToConversation(
        Conversation $conversation,
        User $participant,
        ParticipantRole $role
    ): ConversationParticipant {
        return $this->participant->create([
            'conversation_id' => $conversation->id,
            'participant_id' => $participant->id,
            'participant_type' => User::class,
            'participant_role' => $role,
            'joined_at' => now(),
            'is_active' => true,
            'notification_enabled' => true,
            'creater_id' => $participant->id,
            'creater_type' => User::class,
        ]);
    }

    /**
     * Admin interrupts conversation
     */
    public function adminInterrupt(Conversation $conversation, User $admin): ?ConversationParticipant
    {
        return $this->addParticipant($conversation, $admin, ParticipantRole::ADMIN);
    }

    /**
     * Remove participant from conversation
     */
    public function removeParticipant(Conversation $conversation, User $participant): bool
    {
        try {
            return (bool) $conversation->participants()
                ->where('participant_id', $participant->id)
                ->where('participant_type', User::class)
                ->update([
                    'is_active' => false,
                    'left_at' => now(),
                    'updater_id' => Auth::id(),
                    'updater_type' => User::class,
                ]);
        } catch (Exception $e) {
            Log::error('Failed to remove participant', [
                'conversation_id' => $conversation->id,
                'participant_id' => $participant->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Fetch conversation list for authenticated user
     */
    public function fetchConversationList(
        ?string $search = null,
        ?array $filters = [],
        ?int $perPage = null
    ) {
        $userId = Auth::id();
        $query = $this->conversation
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('participant_id', $userId)
                    ->where('participant_type', User::class)
                    ->where('is_active', true);
            })
            ->with([
                'participants' => function ($query) use ($userId) {
                    $query->where('participant_id', '!=', $userId)
                        ->where('is_active', true)
                        ->with('participant');
                    // ->with('participant:id,first_name,last_name,email,avatar');
                },
                'messages' => function ($query) {
                    $query->latest()->limit(1)->with('sender');
                    // $query->latest()->limit(1)->with('sender:id,first_name,last_name');
                }
            ])
            ->withCount([
                'messages as unread_count' => function ($query) use ($userId) {
                    $query->whereDoesntHave('readReceipts', function ($q) use ($userId) {
                        $q->where('reader_id', $userId)
                            ->where('reader_type', User::class);
                    })
                        ->where('sender_id', '!=', $userId);
                }
            ]);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search, $userId) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('participants', function ($participantQuery) use ($search, $userId) {
                        $participantQuery->where('participant_id', '!=', $userId)
                            ->where('is_active', true)
                            ->whereHasMorph(
                                'participant',
                                [User::class],
                                function ($userQuery) use ($search) {
                                    $userQuery->where(function ($nameQuery) use ($search) {
                                        $nameQuery->where('first_name', 'like', "%{$search}%")
                                            ->orWhere('last_name', 'like', "%{$search}%")
                                            ->orWhere('username', 'like', "%{$search}%")
                                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                                    });
                                }
                            );
                    });
            });
        }

        // Apply status filter
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Apply unread filter
        if (isset($filters['unread']) && $filters['unread']) {
            $query->having('unread_count', '>', 0);
        }

        $baseQuery = $query->orderByDesc('last_message_at')
            ->orderByDesc('created_at');
        if ($perPage) {
            return $baseQuery->paginate($perPage);
        }
        return $baseQuery->get();
    }

    /**
     * Fetch single conversation with messages
     */
    public function fetchConversationMessages(
        Conversation $conversation,
        int $perPage = 50,
        ?int $beforeMessageId = null
    ) {
        // Verify user is participant
        if (!$this->isUserParticipant($conversation, Auth::id())) {
            return null;
        }

        $messagesQuery = $conversation->messages()
            ->with([
                'sender',
                'attachments',
                'readReceipts.reader'
            ])
            // ->with([
            //     'sender:id,first_name,last_name,avatar',
            //     'attachments',
            //     'readReceipts.reader:id,first_name,last_name'
            // ])
            ->orderByDesc('created_at');

        // Pagination by message ID for infinite scroll
        if ($beforeMessageId) {
            $messagesQuery->where('id', '<', $beforeMessageId);
        }

        $messages = $messagesQuery->paginate($perPage);

        // Mark messages as read
        $this->markMessagesAsRead($conversation, Auth::id());

        return [
            'conversation' => $conversation->load('participants.participant'),
            'messages' => $messages,
        ];
    }

    /**
     * Send message in conversation
     */
    public function sendMessage(
        Conversation $conversation,
        string $messageBody,
        ?User $sender = null,
        MessageType $messageType = MessageType::TEXT,
        ?array $metadata = null,
        ?int $parentMessageId = null,
        ?array $attachments = [],
        ?int $orderId = null,
    ): ?Message {
        if ($orderId && !$sender) {
            // System sender for order messages
            $sender = null;
        } else {
            $sender = $sender ?? Auth::user();

            if (!$this->isUserParticipant($conversation, $sender->id)) {
                Log::warning('User not participant in conversation', [
                    'user_id' => $sender->id,
                    'conversation_id' => $conversation->id
                ]);
                return null;
            }
        }

        try {
            return DB::transaction(function () use (
                $conversation,
                $messageBody,
                $sender,
                $messageType,
                $metadata,
                $parentMessageId,
                $attachments
            ) {
                // Create message
                $message = $this->message->create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $sender ? $sender->id : null,
                    'sender_type' => $sender ? User::class : null,
                    'message_type' => $messageType,
                    'message_body' => $messageBody,
                    'metadata' => $metadata,
                    'parent_message_id' => $parentMessageId,
                    'creater_id' => $sender ? $sender->id : null,
                    'creater_type' => $sender ? User::class : null,
                ]);

                // Handle attachments
                if (!empty($attachments)) {
                    $this->attachFilesToMessage($message, $attachments);
                }

                // Update conversation last_message_at
                $conversation->update([
                    'last_message_at' => now(),
                    'updater_id' => $sender ? $sender->id : null,
                    'updater_type' => $sender ? User::class : null,
                ]);

                if ($sender) {
                    // Mark as read for sender
                    $this->markMessageAsRead($message, $sender);
                }

                if ($sender) {

                    // Broadcast to other participants in the conversation
                    broadcast(new MessageSent($message))->toOthers();

                    // Notify all participants that conversation was updated
                    $conversation->participants()
                        ->where('participant_id', '!=', $sender?->id)
                        ->where('is_active', true)
                        ->each(function ($participant) use ($conversation) {
                            broadcast(new ConversationUpdated($conversation, $participant->participant_id));
                        });
                }

                return $message->load(['sender', 'attachments']);
            });
        } catch (Exception $e) {
            Log::error('Failed to send message', [
                'conversation_id' => $conversation->id,
                'sender_id' => $sender ? $sender->id : null,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send message in conversation as order information by system
     */
    public function sendOrderMessage(Order $order): ?Conversation
    {
        $order->load(['source.user', 'user']);
        $buyer = $order?->user ?? Auth::guard('web')->user();
        $seller = $order?->source?->user;

        $conversation = $this->startConversation($buyer, $seller);

        if (!$conversation) {
            return null;
        }
        // dd($conversation, $order, $buyer, $seller);

        $this->sendMessage(
            conversation: $conversation,
            messageBody: 'New order Initiated. Order ID: ' . $order->order_id,
            sender: null,
            messageType: MessageType::ORDER_NOTIFICATION,
            metadata: [
                'order_id' => $order->id,
                'order_uid' => $order->order_id,
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'order_status' => $order->status->value
            ],
            orderId: $order->id,
        );

        return $conversation;
    }
    /**
     * Edit message
     */
    public function editMessage(Message $message, string $newBody, ?User $editor = null): ?Message
    {
        $editor = $editor ?? Auth::user();

        // Verify editor is the sender
        if ($message->sender_id !== $editor->id) {
            Log::warning('User attempting to edit message they did not send', [
                'user_id' => $editor->id,
                'message_id' => $message->id
            ]);
            return null;
        }

        try {
            $message->update([
                'message_body' => $newBody,
                'is_edited' => true,
                'edited_at' => now(),
                'updater_id' => $editor->id,
                'updater_type' => User::class,
            ]);

            return $message->fresh();
        } catch (Exception $e) {
            Log::error('Failed to edit message', [
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Delete message
     */
    public function deleteMessage(Message $message, ?User $deleter = null): bool
    {
        $deleter = $deleter ?? Auth::user();

        // Verify deleter is sender or admin
        if ($message->sender_id !== $deleter->id && !$this->isUserAdmin($message->conversation, $deleter->id)) {
            Log::warning('User attempting to delete message without permission', [
                'user_id' => $deleter->id,
                'message_id' => $message->id
            ]);
            return false;
        }

        try {
            return $message->delete();
        } catch (Exception $e) {
            Log::error('Failed to delete message', [
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Attach files to message
     */
    protected function attachFilesToMessage(Message $message, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            MessageAttachment::create([
                'message_id' => $message->id,
                'attachment_type' => $attachment['type'],
                'file_path' => $attachment['path'],
                'thumbnail_path' => $attachment['thumbnail'] ?? null,
                'creater_id' => Auth::id(),
                'creater_type' => User::class,
            ]);
        }
    }

    /**
     * Mark message as read
     */
    public function markMessageAsRead(Message $message, ?User $reader = null): ?MessageReadReceipt
    {
        $reader = $reader ?? Auth::user();

        // Don't create duplicate read receipts
        $existing = $this->readReceipt
            ->where('message_id', $message->id)
            ->where('reader_id', $reader->id)
            ->where('reader_type', User::class)
            ->first();

        if ($existing) {
            return $existing;
        }

        try {
            return $this->readReceipt->create([
                'message_id' => $message->id,
                'reader_id' => $reader->id,
                'reader_type' => User::class,
                'read_at' => now(),
                'creater_id' => $reader->id,
                'creater_type' => User::class,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to mark message as read', [
                'message_id' => $message->id,
                'reader_id' => $reader->id,
                'reader_type' => User::class,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Mark all messages in conversation as read
     */
    public function markMessagesAsRead(Conversation $conversation, ?int $userId = null): int
    {
        $userId = $userId ?? Auth::id();

        try {
            $unreadMessages = $conversation->messages()
                ->whereDoesntHave('readReceipts', function ($query) use ($userId) {
                    $query->where('reader_id', $userId)
                        ->where('reader_type', User::class);
                })
                ->where('sender_id', '!=', $userId)
                ->pluck('id');

            if ($unreadMessages->isEmpty()) {
                return 0;
            }

            $readReceipts = $unreadMessages->map(fn($messageId) => [
                'message_id' => $messageId,
                'reader_id' => $userId,
                'reader_type' => User::class,
                'read_at' => now(),
                'creater_id' => $userId,
                'creater_type' => User::class,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->readReceipt->insert($readReceipts->toArray());

            // Update participant's last_read_at
            $conversation->participants()
                ->where('participant_id', $userId)
                ->where('participant_type', User::class)
                ->update(['last_read_at' => now()]);

            return $unreadMessages->count();
        } catch (Exception $e) {
            Log::error('Failed to mark messages as read', [
                'conversation_id' => $conversation->id,
                'reader_id' => $userId,
                'reader_type' => User::class,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount(?int $userId = null): int
    {
        $userId = $userId ?? Auth::id();

        return $this->message
            ->whereHas('conversation.participants', function ($query) use ($userId) {
                $query->where('participant_id', $userId)
                    ->where('participant_type', User::class)
                    ->where('is_active', true);
            })
            ->whereDoesntHave('readReceipts', function ($query) use ($userId) {
                $query->where('reader_id', $userId)
                    ->where('reader_type', User::class);
            })
            ->where('sender_id', '!=', $userId)
            ->count();
    }

    /**
     * Toggle notification for conversation
     */
    public function toggleNotification(Conversation $conversation, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();

        try {
            $participant = $conversation->participants()
                ->where('participant_id', $user->id)
                ->where('participant_type', User::class)
                ->first();

            if (!$participant) {
                return false;
            }

            $participant->update([
                'notification_enabled' => !$participant->notification_enabled,
                'updater_id' => $user->id,
                'updater_type' => User::class,
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to toggle notification', [
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Archive conversation
     */
    public function archiveConversation(Conversation $conversation): bool
    {
        try {
            return (bool) $conversation->update([
                'status' => ConversationStatus::ARCHIVED,
                'updater_id' => Auth::id(),
                'updater_type' => User::class,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to archive conversation', [
                'conversation_id' => $conversation->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if user is participant
     */
    public function isUserParticipant(Conversation $conversation, int $userId): bool
    {
        return $conversation->participants()
            ->where('participant_id', $userId)
            ->where('participant_type', User::class)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Check if user is admin in conversation
     */
    public function isUserAdmin(Conversation $conversation, int $userId): bool
    {
        return $conversation->participants()
            ->where('participant_id', $userId)
            ->where('participant_type', User::class)
            ->where('participant_role', ParticipantRole::ADMIN)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Get conversation by UUID
     */
    public function findByUuid(string $uuid): ?Conversation
    {
        return $this->conversation
            ->where('conversation_uuid', $uuid)
            ->first();
    }

    /**
     * Search messages within conversation
     */
    public function searchMessages(Conversation $conversation, string $search, int $perPage = 20)
    {
        if (!$this->isUserParticipant($conversation, Auth::id())) {
            return null;
        }

        return $conversation->messages()
            ->where('message_body', 'like', "%{$search}%")
            ->with(['sender:id,first_name,last_name', 'attachments'])
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Get conversation statistics
     */
    public function getConversationStats(Conversation $conversation): array
    {
        return [
            'total_messages' => $conversation->messages()->count(),
            'total_participants' => $conversation->participants()->where('is_active', true)->count(),
            'unread_messages' => $conversation->messages()
                ->whereDoesntHave('readReceipts', function ($query) {
                    $query->where('reader_id', Auth::id())
                        ->where('reader_type', User::class);
                })
                ->where('sender_id', '!=', Auth::id())
                ->count(),
            'last_activity' => $conversation->last_message_at,
            'admin_involved' => $conversation->participants()
                ->where('participant_role', ParticipantRole::ADMIN)
                ->where('is_active', true)
                ->exists(),
        ];
    }
}
