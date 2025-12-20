<?php

namespace App\Livewire\Backend\User\Chat;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Message extends Component
{
    use WithFileUploads;

    public ?int $conversationId = null;
    public ?Conversation $conversation = null;
    public $messages = [];
    public string $message = '';
    public $media = null;
    public bool $isLoading = false;
    public ?int $beforeMessageId = null;
    public bool $isUserAtBottom = true; // Track if user is at bottom

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    #[On('conversation-selected')]
    public function loadConversation(int $conversationId)
    {
        // Quick switch: Don't reload if same conversation
        if ($this->conversationId === $conversationId && $this->conversation) {
            return;
        }

        $this->conversationId = $conversationId;

        // Load conversation with minimal queries
        $this->conversation = Conversation::select('id', 'conversation_uuid', 'subject', 'status')
            ->with(['participants' => function ($query) {
                $query->select('id', 'conversation_id', 'participant_id', 'participant_type')
                    ->where('participant_id', '!=', Auth::id())
                    ->where('is_active', true)
                    ->with(['participant' => function ($q) {
                        $q->select('id', 'first_name', 'last_name', 'username', 'avatar');
                    }]);
            }])
            ->find($conversationId);

        $this->loadMessages();
        $this->isUserAtBottom = true;

        // Dispatch event to JavaScript for initial setup
        $this->dispatch('conversation-loaded', conversationId: $conversationId);
    }

    public function loadMessages()
    {
        if (!$this->conversation) {
            $this->messages = [];
            return;
        }

        $result = $this->service->fetchConversationMessages(
            $this->conversation,
            perPage: 50,
            beforeMessageId: $this->beforeMessageId
        );

        if ($result) {
            $this->messages = $result['messages']->reverse()->values()->all();
        }
    }

    public function sendMessage()
    {
        if (!$this->conversation) {
            $this->dispatch('error', message: 'No conversation selected');
            return;
        }

        if (empty(trim($this->message)) && !$this->media) {
            return;
        }

        $this->isLoading = true;

        try {
            $attachments = [];

            // Handle file uploads
            if ($this->media) {
                if (is_array($this->media)) {
                    foreach ($this->media as $file) {
                        $attachments[] = $this->uploadFile($file);
                    }
                } else {
                    $attachments[] = $this->uploadFile($this->media);
                }
            }

            $messageType = !empty($attachments) ? MessageType::IMAGE : MessageType::TEXT;

            // Send the message
            $sentMessage = $this->service->sendMessage(
                conversation: $this->conversation,
                messageBody: trim($this->message) ?: 'Sent an attachment',
                messageType: $messageType,
                attachments: $attachments
            );

            if ($sentMessage) {
                // Add message to local array immediately (optimistic update)
                $this->messages[] = $sentMessage;

                // Clear inputs
                $this->message = '';
                $this->media = null;

                // Always scroll to bottom when user sends message
                $this->isUserAtBottom = true;

                // Notify other components
                $this->dispatch('refresh-conversations');
                $this->dispatch('scroll-to-bottom');
            } else {
                $this->dispatch('error', message: 'Failed to send message');
            }
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    protected function uploadFile($file): array
    {
        $path = $file->store('chat/attachments', 'public');

        // Determine file type
        $mimeType = $file->getMimeType();
        $attachmentType = AttachmentType::FILE;
        $thumbnailPath = null;

        if (str_starts_with($mimeType, 'image/')) {
            $attachmentType = AttachmentType::IMAGE;
            $thumbnailPath = $this->createThumbnail($file);
        } elseif (str_starts_with($mimeType, 'video/')) {
            $attachmentType = AttachmentType::VIDEO;
        } elseif (str_starts_with($mimeType, 'audio/')) {
            $attachmentType = AttachmentType::AUDIO;
        }

        return [
            'type' => $attachmentType,
            'path' => $path,
            'thumbnail' => $thumbnailPath,
        ];
    }

    protected function createThumbnail($file): ?string
    {
        try {
            $thumbnailPath = 'chat/thumbnails/' . uniqid() . '_thumb.jpg';
            $file->storeAs('public', $thumbnailPath);
            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }

    #[On('new-message-received')]
    public function handleNewMessageReceived($messageData)
    {
        if (!$this->conversation || $messageData['conversation_id'] != $this->conversationId) {
            return;
        }

        // Add new message to array
        $newMessage = \App\Models\Message::with(['sender', 'attachments', 'readReceipts'])
            ->find($messageData['id']);

        if ($newMessage) {
            $this->messages[] = $newMessage;

            // Dispatch event to check scroll position
            $this->dispatch('check-scroll-position');
        }
    }

    #[On('mark-visible-as-read')]
    public function markVisibleMessagesAsRead(array $visibleMessageIds)
    {
        if (!$this->conversation || empty($visibleMessageIds)) {
            return;
        }

        // Mark only visible messages as read
        $unreadMessages = $this->conversation->messages()
            ->whereIn('id', $visibleMessageIds)
            ->whereDoesntHave('readReceipts', function ($query) {
                $query->where('reader_id', Auth::id())
                    ->where('reader_type', \App\Models\User::class);
            })
            ->where('sender_id', '!=', Auth::id())
            ->get();

        foreach ($unreadMessages as $message) {
            $this->service->markMessageAsRead($message);
        }

        if ($unreadMessages->isNotEmpty()) {
            $this->dispatch('refresh-conversations');
        }
    }

    #[On('user-scroll-position')]
    public function updateScrollPosition(bool $isAtBottom)
    {
        $this->isUserAtBottom = $isAtBottom;
    }

    public function loadMoreMessages()
    {
        if (empty($this->messages)) {
            return;
        }

        $oldestMessage = collect($this->messages)->first();
        $this->beforeMessageId = $oldestMessage->id ?? null;

        if ($this->beforeMessageId) {
            $result = $this->service->fetchConversationMessages(
                $this->conversation,
                perPage: 50,
                beforeMessageId: $this->beforeMessageId
            );

            if ($result && $result['messages']->isNotEmpty()) {
                $olderMessages = $result['messages']->reverse()->values()->all();
                $this->messages = array_merge($olderMessages, $this->messages);
                $this->dispatch('maintain-scroll-position');
            }
        }
    }

    public function deleteMessage(int $messageId)
    {
        try {
            $message = \App\Models\Message::find($messageId);

            if ($message && $this->service->deleteMessage($message)) {
                // Remove from local array
                $this->messages = collect($this->messages)
                    ->reject(fn($msg) => $msg->id === $messageId)
                    ->values()
                    ->all();

                $this->dispatch('success', message: 'Message deleted');
            } else {
                $this->dispatch('error', message: 'Failed to delete message');
            }
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Error deleting message');
        }
    }

    public function getOtherParticipantProperty()
    {
        if (!$this->conversation) {
            return null;
        }

        return $this->conversation->participants
            ->where('participant_id', '!=', Auth::id())
            ->first()?->participant;
    }

    public function render()
    {
        return view('livewire.backend.user.chat.message', [
            'otherParticipant' => $this->otherParticipant,
        ]);
    }
}
