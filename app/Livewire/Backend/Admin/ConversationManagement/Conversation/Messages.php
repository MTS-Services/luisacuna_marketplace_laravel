<?php

namespace App\Livewire\Backend\Admin\ConversationManagement\Conversation;

use App\Enums\AttachmentType;
use App\Enums\MessageType;
use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Messages extends Component
{
    use WithFileUploads;

    public ?int $conversationId = null;
    public ?Conversation $conversation = null;
    public $messages = [];
    public string $message = '';
    public $media = null;
    public bool $isLoading = false;
    public ?int $beforeMessageId = null;
    public bool $hasJoined = false;

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    public function mount(?int $conversationId = null)
    {
        if ($conversationId) {
            $this->loadConversation($conversationId);
        }
    }

    #[On('admin-conversation-selected')]
    public function loadConversation(int $conversationId)
    {
        // Quick switch: Don't reload if same conversation
        if ($this->conversationId === $conversationId && $this->conversation) {
            return;
        }

        $this->conversationId = $conversationId;

        // Load conversation
        $this->conversation = Conversation::select('id', 'conversation_uuid', 'subject', 'status', 'last_message_at')
            ->with(['participants' => function ($query) {
                $query->where('is_active', true)
                    ->with(['participant' => function ($q) {
                        $q->select('id', 'first_name', 'last_name', 'username', 'email', 'avatar');
                    }]);
            }])
            ->find($conversationId);

        $this->loadMessages();

        // Check if admin is already a participant
        $this->hasJoined = $this->conversation->participants()
            ->where('participant_id', Auth::guard('admin')->id())
            ->where('participant_type', \App\Models\Admin::class)
            ->where('is_active', true)
            ->exists();

        // Dispatch event to JavaScript
        $this->dispatch('admin-conversation-loaded', conversationId: $conversationId);
    }

    public function loadMessages()
    {
        if (!$this->conversation) {
            $this->messages = [];
            return;
        }

        $result = $this->service->fetchConversationMessagesForAdmin(
            $this->conversation,
            perPage: 50,
            beforeMessageId: $this->beforeMessageId
        );

        if ($result) {
            $this->messages = $result['messages']->reverse()->values()->all();
        }
    }

    public function joinConversation()
    {
        if (!$this->conversation) {
            return;
        }

        $admin = Auth::guard('admin')->user();

        $participant = $this->service->adminJoinConversation($this->conversation, $admin);

        if ($participant) {
            $this->hasJoined = true;
            $this->loadMessages(); // Reload to show join message
            $this->dispatch('success', message: 'You have joined the conversation');
            $this->dispatch('refresh-admin-conversations');
        } else {
            $this->dispatch('error', message: 'Failed to join conversation');
        }
    }

    public function sendMessage()
    {
        if (!$this->conversation) {
            $this->dispatch('error', message: 'No conversation selected');
            return;
        }

        if (!$this->hasJoined) {
            $this->joinConversation();
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

            $admin = Auth::guard('admin')->user();

            // Send the message
            $sentMessage = $this->service->adminSendMessage(
                conversation: $this->conversation,
                admin: $admin,
                messageBody: trim($this->message) ?: 'Sent an attachment',
                messageType: $messageType,
                attachments: $attachments
            );

            if ($sentMessage) {
                // Add message to local array immediately
                $this->messages[] = $sentMessage;

                // Clear inputs
                $this->message = '';
                $this->media = null;

                // Notify
                $this->dispatch('refresh-admin-conversations');
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

    #[On('new-message-received-admin')]
    public function handleNewMessageReceived($messageData)
    {
        if (!$this->conversation || $messageData['conversation_id'] != $this->conversationId) {
            return;
        }

        // Add new message to array
        $newMessage = \App\Models\Message::with(['sender', 'attachments'])
            ->find($messageData['id']);

        if ($newMessage) {
            $this->messages[] = $newMessage;
            $this->dispatch('check-scroll-position-admin');
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
            $result = $this->service->fetchConversationMessagesForAdmin(
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

            if ($message && $this->service->deleteMessage($message, Auth::guard('admin')->user())) {
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

    public function getParticipantsProperty()
    {
        if (!$this->conversation) {
            return collect();
        }

        return $this->conversation->participants->map(function ($participant) {
            return [
                'id' => $participant->participant_id,
                'type' => $participant->participant_type,
                'role' => $participant->participant_role,
                'name' => $participant->participant?->full_name ?? $participant->participant?->name ?? 'Unknown',
                'avatar' => $participant->participant?->avatar,
                'is_admin' => $participant->participant_type === \App\Models\Admin::class,
            ];
        });
    }

    public function render()
    {
        return view('livewire.backend.admin.conversation-management.conversation.messages', [
            'participants' => $this->participants,
        ]);
    }
}
