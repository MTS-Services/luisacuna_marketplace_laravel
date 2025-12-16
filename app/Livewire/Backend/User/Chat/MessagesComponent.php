<?php

namespace App\Livewire\Backend\User\Chat;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\Attributes\On;
use App\Enums\AttachmentType;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderMessageService;

class MessagesComponent extends Component
{
    use WithFileUploads;

    public ?int $receiverId = null;
    public string $receiverName = '';
    public ?int $conversationId = null;
    public ?string $conversationUuid = null;
    public string $message = '';
    public $media = null;
    public string $searchTerm = '';
    public $users = [];
    public $messages = [];

    protected OrderMessageService $OrderMessageService;

    public function boot(OrderMessageService $OrderMessageService)
    {
        $this->OrderMessageService = $OrderMessageService;
    }

    public function mount()
    {
        $this->loadUsers();
    }

    /**
     * Load all users with conversations
     */
    public function loadUsers(): void
    {
        $this->users = $this->OrderMessageService->getUsersSortedByLastMessage(
            Auth::id(), 
            $this->searchTerm
        );
    }

    /**
     * Reload users when search term changes
     */
    public function updatedSearchTerm(): void
    {
        $this->loadUsers();
    }

    /**
     * Select a user to chat with
     * 
     * 
     */
    public function selectUser(int $userId, string $userName = ''): void
    {
        $this->receiverId = $userId;
        $this->receiverName = $userName;

        $conversation = $this->OrderMessageService->getOrCreateConversation(
            Auth::id(), 
            $userId
        );
        
        $this->conversationId = $conversation->id;
        $this->conversationUuid = $conversation->conversation_uuid;

        $this->OrderMessageService->markAsRead($this->conversationId, Auth::id());

        $this->loadMessages();
    }

    /**
     * Load messages for current conversation
     */
    public function loadMessages(): void
    {
        if (!$this->conversationId) return;

        $this->messages = $this->OrderMessageService->fetch($this->conversationId);
    }

    /**
     *
     */
    #[On('refreshMessages')]
    public function refreshMessages(): void
    {
        $this->loadUsers();

        if ($this->conversationId) {
            $this->loadMessages();
            $this->OrderMessageService->markAsRead($this->conversationId, Auth::id());
        }
    }

    /**
     * Send a new message
     */
    public function sendMessage(): void
    {
        if (!$this->receiverId || (!trim($this->message) && empty($this->media))) {
            return;
        }

        $attachments = [];
        if ($this->media) {
            $attachments = $this->processMediaUploads();
        }

        $messageType = MessageType::TEXT;
        if (!empty($attachments)) {
            $firstAttachment = $attachments[0] ?? [];
            if (isset($firstAttachment['type']) && 
                in_array($firstAttachment['type'], ['image', AttachmentType::IMAGE])) {
                $messageType = MessageType::TEXT;
            } else {
                $messageType = MessageType::TEXT;
            }
        }

        // Send message
        $this->OrderMessageService->send(
            $this->conversationId,
            $this->message ?: '📎 Attachment',
            $attachments,
            $messageType
        );

        $this->reset(['message', 'media']);
        $this->loadMessages();
        $this->loadUsers();

        $this->dispatch('messageSent', [
            'conversationId' => $this->conversationId,
            'receiverId' => $this->receiverId,
        ]);

        $this->dispatch('scrollToBottom');
    }

    /**
     * Process uploaded media files
     * 
     *
     */
    private function processMediaUploads(): array
    {
        $attachments = [];

        foreach ((array)$this->media as $file) {
            $path = $file->store('chat_media', 'public');

            $mimeType = $file->getMimeType();
            $attachmentType = AttachmentType::IMAGE;

            if (str_starts_with($mimeType, 'image/')) {
                $attachmentType = AttachmentType::IMAGE;
            } elseif (str_starts_with($mimeType, 'video/')) {
                $attachmentType = AttachmentType::VIDEO;
            } elseif (str_starts_with($mimeType, 'audio/')) {
                $attachmentType = AttachmentType::AUDIO;
            }
            $thumbnail = null;
            if ($attachmentType === AttachmentType::IMAGE) {
                // You can add thumbnail generation logic here
                // $thumbnail = $this->generateThumbnail($path);
            }

            $attachments[] = [
                'type' => $attachmentType,
                'path' => $path,
                'thumbnail' => $thumbnail,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $mimeType,
            ];
        }

        return $attachments;
    }

    /**
     * Delete a message (soft delete)
     * 
     *
     */
    public function deleteMessage(int $messageId): void
    {
        try {
            $this->OrderMessageService->deleteMessage($messageId);
            $this->loadMessages();
            
            session()->flash('success', 'Message deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete message.');
        }
    }

    /**
     * Edit a message
     * 
     *
     */
    public function editMessage(int $messageId, string $newMessage): void
    {
        try {
            $this->OrderMessageService->editMessage($messageId, $newMessage);
            $this->loadMessages();
            
            session()->flash('success', 'Message updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update message.');
        }
    }

    /**
     * Leave/Archive conversation
     */
    public function leaveConversation(): void
    {
        if (!$this->conversationId) return;

        try {
            $this->OrderMessageService->leaveConversation(
                $this->conversationId, 
                Auth::id()
            );
            $this->reset(['conversationId', 'conversationUuid', 'receiverId', 'receiverName', 'messages']);
            
            $this->loadUsers();
            
            session()->flash('success', 'Conversation archived.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to leave conversation.');
        }
    }

    /**
     * Get unread count for a specific user
     * 
     * @param int $userId
     * @return int
     */
    public function getUnreadCount(int $userId): int
    {
        $user = collect($this->users)->firstWhere('id', $userId);
        return $user->unreadCount ?? 0;
    }

    /**
     * Mark specific conversation as read
     * 
     * @param int $conversationId
     */
    #[On('markConversationAsRead')]
    public function markConversationAsRead(int $conversationId): void
    {
        $this->OrderMessageService->markAsRead($conversationId, Auth::id());
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.backend.user.chat.messages-component', [
            'users' => $this->users,
            'messages' => $this->messages,
            'currentUserId' => Auth::id(),
        ]);
    }
}