<?php

namespace App\Livewire\Backend\User\Chat;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    #[On('conversation-selected')]
    public function loadConversation(int $conversationId)
    {
        $this->conversationId = $conversationId;
        $this->conversation = Conversation::with(['participants.participant'])->find($conversationId);
        $this->loadMessages();

        // Mark messages as read when conversation is opened
        if ($this->conversation) {
            $this->service->markMessagesAsRead($this->conversation);
        }
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
                // Clear inputs
                $this->message = '';
                $this->media = null;

                // Reload messages
                $this->beforeMessageId = null;
                $this->loadMessages();

                // Notify other components
                $this->dispatch('new-message');
                $this->dispatch('refresh-conversations');

                // Scroll to bottom
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

        if (str_starts_with($mimeType, 'image/')) {
            $attachmentType = AttachmentType::IMAGE;

            // Create thumbnail for images
            $thumbnailPath = $this->createThumbnail($file);
        } elseif (str_starts_with($mimeType, 'video/')) {
            $attachmentType = AttachmentType::VIDEO;
        } elseif (str_starts_with($mimeType, 'audio/')) {
            $attachmentType = AttachmentType::AUDIO;
        }

        return [
            'type' => $attachmentType,
            'path' => $path,
            'thumbnail' => $thumbnailPath ?? null,
        ];
    }

    protected function createThumbnail($file): ?string
    {
        try {
            // Simple thumbnail creation (you can enhance this with intervention/image)
            $thumbnailPath = 'chat/thumbnails/' . uniqid() . '_thumb.jpg';

            // For now, just copy the file (you should implement proper thumbnail generation)
            $file->storeAs('public', $thumbnailPath);

            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function loadMoreMessages()
    {
        if (empty($this->messages)) {
            return;
        }

        // Get the oldest message ID
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
            }
        }
    }

    #[On('refresh-messages')]
    public function refreshMessages()
    {
        if ($this->conversation) {
            // Only load new messages, not all messages
            $this->loadNewMessages();
        }
    }

    protected function loadNewMessages()
    {
        if (!$this->conversation || empty($this->messages)) {
            return;
        }

        // Get the latest message ID we have
        $latestMessageId = collect($this->messages)->last()->id ?? 0;

        // Fetch only newer messages
        $newMessages = $this->conversation->messages()
            ->with(['sender', 'attachments', 'readReceipts.reader'])
            ->where('id', '>', $latestMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($newMessages->isNotEmpty()) {
            // Append new messages
            $this->messages = array_merge($this->messages, $newMessages->all());

            // Mark new messages as read
            foreach ($newMessages as $message) {
                if ($message->sender_id !== Auth::id()) {
                    $this->service->markMessageAsRead($message);
                }
            }

            // Notify to scroll and refresh conversations list
            $this->dispatch('new-message-received');
            $this->dispatch('refresh-conversations');
        }
    }

    public function deleteMessage(int $messageId)
    {
        try {
            $message = \App\Models\Message::find($messageId);

            if ($message && $this->service->deleteMessage($message)) {
                $this->loadMessages();
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
