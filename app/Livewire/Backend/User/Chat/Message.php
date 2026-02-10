<?php

namespace App\Livewire\Backend\User\Chat;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Models\Message as MessageModel;
use App\Services\Cloudinary\CloudinaryService;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Message extends Component
{
    use WithFileUploads;

    public ?int $conversationId       = null;
    public ?Conversation $conversation = null;
    public array $messages            = [];
    public string $message            = '';
    public $media                     = null;
    public bool $isLoading            = false;
    public bool $isLoadingConversation = false;
    public ?int $beforeMessageId      = null;
    public bool $isUserAtBottom       = true;
    public ?int $lastPolledMessageId  = null;
    public bool $hasMoreMessages      = false;

    // Image overlay state
    public bool $showImageOverlay    = false;
    public ?string $selectedImageUrl = null;

    protected ConversationService $service;
    protected CloudinaryService $cloudinaryService;

    public function boot(ConversationService $service, CloudinaryService $cloudinaryService)
    {
        $this->service          = $service;
        $this->cloudinaryService = $cloudinaryService;
    }

    #[On('conversation-selected')]
    public function loadConversation(int $conversationId)
    {
        // Skip if same conversation already loaded
        if ($this->conversationId === $conversationId && $this->conversation) {
            return;
        }

        // ✅ Reset state instantly - clears old messages so UI feels snappy
        $this->conversationId      = $conversationId;
        $this->messages            = [];
        $this->lastPolledMessageId = null;
        $this->beforeMessageId     = null;
        $this->isUserAtBottom      = true;
        $this->isLoadingConversation = true;

        // Dispatch immediately so JS can show skeleton
        $this->dispatch('conversation-loading');

        // Load conversation with minimal eager loading for speed
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

        if (!$this->conversation) {
            $this->isLoadingConversation = false;
            return;
        }

        $this->loadMessages();

        $this->isLoadingConversation = false;

        // Track last message id for polling
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
            $paginator     = $result['messages'];
            $loaded        = $paginator->reverse()->values()->all();
            $this->messages       = $loaded;
            $this->hasMoreMessages = $paginator->hasMorePages();
        }
    }

    /**
     * Polling: returns only new messages since last poll (lightweight)
     */
    public function pollForNewMessages()
    {
        if (!$this->conversation) {
            return ['hasNewMessages' => false];
        }

        $lastId = $this->lastPolledMessageId ?? 0;

        if (empty($this->messages) && $lastId === 0) {
            return ['hasNewMessages' => false];
        }

        // ✅ Optimized: only fetch id + sender_id + timestamps first
        $newMessages = $this->conversation->messages()
            ->with(['sender:id,first_name,last_name,username,avatar', 'attachments', 'readReceipts'])
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->get();

        if ($newMessages->isNotEmpty()) {
            foreach ($newMessages as $newMsg) {
                $this->messages[] = $newMsg;
            }

            $this->lastPolledMessageId = $newMessages->last()->id;
            $this->dispatch('check-scroll-position');
            $this->dispatch('messages-updated');

            return [
                'hasNewMessages'  => true,
                'newMessageCount' => $newMessages->count(),
                'senderId'        => $newMessages->last()->sender_id,
            ];
        }

        return ['hasNewMessages' => false];
    }

    /**
     * Load older messages (infinite scroll upward)
     */
    public function loadMoreMessages()
    {
        if (empty($this->messages) || !$this->hasMoreMessages) {
            return;
        }

        $oldestMessage     = collect($this->messages)->first();
        $this->beforeMessageId = $oldestMessage->id ?? null;

        if (!$this->beforeMessageId) {
            return;
        }

        $result = $this->service->fetchConversationMessages(
            $this->conversation,
            perPage: 50,
            beforeMessageId: $this->beforeMessageId
        );

        if ($result && $result['messages']->isNotEmpty()) {
            $olderMessages        = $result['messages']->reverse()->values()->all();
            $this->messages       = array_merge($olderMessages, $this->messages);
            $this->hasMoreMessages = $result['messages']->hasMorePages();
            $this->dispatch('maintain-scroll-position');
        }
    }

    public function sendMessage()
    {
        if (!$this->conversation) {
            $this->dispatch('error', message: 'No conversation selected');
            return;
        }

        $trimmed = trim($this->message);

        if (empty($trimmed) && !$this->media) {
            return;
        }

        $this->isLoading = true;

        try {
            $attachments = [];

            if ($this->media) {
                $files = is_array($this->media) ? $this->media : [$this->media];
                foreach ($files as $file) {
                    $attachments[] = $this->uploadFile($file);
                }
            }

            $messageType = !empty($attachments) ? MessageType::IMAGE : MessageType::TEXT;

            $sentMessage = $this->service->sendMessage(
                conversation: $this->conversation,
                messageBody: $trimmed ?: 'Sent an attachment',
                messageType: $messageType,
                attachments: $attachments
            );

            if ($sentMessage) {
                // Load with relationships for display
                $sentMessage->load(['sender:id,first_name,last_name,username,avatar', 'attachments', 'readReceipts']);

                $this->messages[]          = $sentMessage;
                $this->lastPolledMessageId = $sentMessage->id;
                $this->message             = '';
                $this->media               = null;
                $this->isUserAtBottom      = true;

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
        $uploaded  = $this->cloudinaryService->upload($file, ['folder' => 'chats']);
        $path      = $uploaded->publicId;
        $mimeType  = $file->getMimeType();

        $attachmentType = AttachmentType::FILE;
        $thumbnailPath  = null;

        if (str_starts_with($mimeType, 'image/')) {
            $attachmentType = AttachmentType::IMAGE;
            $thumbnailPath  = $this->createThumbnail($file);
        } elseif (str_starts_with($mimeType, 'video/')) {
            $attachmentType = AttachmentType::VIDEO;
        } elseif (str_starts_with($mimeType, 'audio/')) {
            $attachmentType = AttachmentType::AUDIO;
        }

        return [
            'type'      => $attachmentType,
            'path'      => $path,
            'thumbnail' => $thumbnailPath,
        ];
    }

    protected function createThumbnail($file): ?string
    {
        try {
            $uploaded = $this->cloudinaryService->upload($file, ['folder' => 'chats/thumbnails']);
            return $uploaded->publicId;
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

        $newMessage = MessageModel::with(['sender:id,first_name,last_name,username,avatar', 'attachments', 'readReceipts'])
            ->find($messageData['id']);

        if ($newMessage) {
            $this->messages[]          = $newMessage;
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
            ->whereDoesntHave('readReceipts', fn($q) => $q
                ->where('reader_id', Auth::id())
                ->where('reader_type', \App\Models\User::class))
            ->where('sender_id', '!=', Auth::id())
            ->get();

        foreach ($unreadMessages as $msg) {
            $this->service->markMessageAsRead($msg);
        }

        if ($unreadMessages->isNotEmpty()) {
            $this->dispatch('refresh-conversations');
        }
    }

    public function deleteMessage(int $messageId)
    {
        try {
            $msg = MessageModel::find($messageId);

            if ($msg && $this->service->deleteMessage($msg)) {
                $this->messages = collect($this->messages)
                    ->reject(fn($m) => $m->id === $messageId)
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

    public function showAttachmentImage(string $url)
    {
        $this->showImageOverlay  = true;
        $this->selectedImageUrl = $url;
    }

    // Keep old name for backward compat with blade
    public function ShowAttachemntImage(string $url)
    {
        $this->showAttachmentImage($url);
    }

    public function closeImageOverlay()
    {
        $this->showImageOverlay  = false;
        $this->selectedImageUrl = null;
        $this->dispatch('image-overlay-closed');
    }

    public function removeMedia(int $index)
    {
        if (is_array($this->media)) {
            $mediaArray = $this->media;
            array_splice($mediaArray, $index, 1);
            $this->media = empty($mediaArray) ? null : $mediaArray;
        } else {
            $this->media = null;
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
