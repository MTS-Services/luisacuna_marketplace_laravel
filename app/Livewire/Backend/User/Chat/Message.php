<?php

namespace App\Livewire\Backend\User\Chat;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
    public bool $isUserAtBottom = true;
    public ?int $lastPolledMessageId = null; // Track last polled message

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    #[On('conversation-selected')]
    public function loadConversation(int $conversationId)
    {
        if ($this->conversationId === $conversationId && $this->conversation) {
            return;
        }

        $this->conversationId = $conversationId;

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

        // Set the last polled message ID
        if (!empty($this->messages)) {
            $this->lastPolledMessageId = collect($this->messages)->last()->id ?? null;
        }

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

    /**
     * ✅ POLLING METHOD - Check for new messages without broadcasting
     * This method is called by JavaScript setInterval
     */
    public function pollForNewMessages()
    {
        if (!$this->conversation) {
            return ['hasNewMessages' => false];
        }

        // Get the ID of the last message we have
        $lastMessageId = $this->lastPolledMessageId;

        if (empty($this->messages)) {
            $lastMessageId = 0;
        } elseif (!$lastMessageId) {
            $lastMessageId = collect($this->messages)->last()->id ?? 0;
        }

        // Query for new messages after the last polled message
        $newMessages = $this->conversation->messages()
            ->with(['sender', 'attachments', 'readReceipts'])
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($newMessages->isNotEmpty()) {
            // Add new messages to the array
            foreach ($newMessages as $newMessage) {
                $this->messages[] = $newMessage;
            }

            // Update last polled message ID
            $this->lastPolledMessageId = $newMessages->last()->id;

            // Dispatch event to check scroll position
            $this->dispatch('check-scroll-position');
            $this->dispatch('messages-updated');

            // Return info about new messages
            $lastNewMessage = $newMessages->last();
            return [
                'hasNewMessages' => true,
                'newMessageCount' => $newMessages->count(),
                'senderId' => $lastNewMessage->sender_id,
            ];
        }

        return ['hasNewMessages' => false];
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

            $sentMessage = $this->service->sendMessage(
                conversation: $this->conversation,
                messageBody: trim($this->message) ?: 'Sent an attachment',
                messageType: $messageType,
                attachments: $attachments
            );

            if ($sentMessage) {
                $this->messages[] = $sentMessage;

                // Update last polled message ID
                $this->lastPolledMessageId = $sentMessage->id;

                $this->message = '';
                $this->media = null;
                $this->isUserAtBottom = true;

                $this->dispatch('refresh-conversations');
                $this->dispatch('scroll-to-bottom');
                $this->dispatch('messages-updated');
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

    /**
     * ✅ BROADCASTING METHOD - Handle new message from WebSocket event
     * This is called when using Pusher/Reverb broadcasting
     */
    #[On('new-message-received')]
    public function handleNewMessageReceived($messageData)
    {
        if (!$this->conversation || $messageData['conversation_id'] != $this->conversationId) {
            return;
        }

        $newMessage = \App\Models\Message::with(['sender', 'attachments', 'readReceipts'])
            ->find($messageData['id']);

        if ($newMessage) {
            $this->messages[] = $newMessage;

            // Update last polled message ID (in case user switches to polling)
            $this->lastPolledMessageId = $newMessage->id;

            $this->dispatch('check-scroll-position');
        }
    }

    public function markVisibleMessagesAsRead(array $visibleMessageIds)
    {
        if (!$this->conversation || empty($visibleMessageIds)) {
            return;
        }

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

// Add these properties
public $showImageOverlay = false;
public $selectedImageUrl = null;

// Add these methods
public function ShowAttachemntImage($encryptedUrl)
{
    $this->showImageOverlay = true;
    $this->selectedImageUrl = $encryptedUrl;
}

public function closeImageOverlay()
{
    $this->showImageOverlay = false;
    $this->selectedImageUrl = null;
    $this->dispatch('image-overlay-closed');
}


    public function render()
    {
        return view('livewire.backend.user.chat.message', [
            'otherParticipant' => $this->otherParticipant,
        ]);
    }
}
