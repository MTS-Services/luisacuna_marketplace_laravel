<?php

namespace App\Livewire\Backend\User\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderMessageService;

class MessagesComponent extends Component
{
    use WithFileUploads;

    public ?int $receiverId = null;
    public string $receiverName = '';
    public ?int $conversationId = null;
    public string $message = '';
    public $media = null;
    public string $searchTerm = '';
    public $users = [];
    public $messages = [];

    protected OrderMessageService $orderMessageService;

    public function boot(OrderMessageService $orderMessageService)
    {
        $this->orderMessageService = $orderMessageService;
    }

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers(): void
    {
        $this->users = $this->orderMessageService->getUsersSortedByLastMessage(Auth::id(), $this->searchTerm);
    }

    public function updatedSearchTerm(): void
    {
        $this->loadUsers();
    }

    public function selectUser(int $userId, string $userName = ''): void
    {
        $this->receiverId = $userId;
        $this->receiverName = $userName;

        $conversation = $this->orderMessageService->getOrCreateConversation(Auth::id(), $userId);
        $this->conversationId = $conversation->id;

        // Mark as seen when opening
        $this->orderMessageService->seen($this->conversationId, Auth::id());

        $this->loadMessages();
    }

    public function loadMessages(): void
    {
        if (!$this->conversationId) return;

        $this->messages = $this->orderMessageService->fetch($this->conversationId);
    }

    #[\Livewire\Attributes\On('refreshMessages')]
    public function refreshMessages(): void
    {
        $this->loadUsers();

        if ($this->conversationId) {
            $this->loadMessages();
            $this->orderMessageService->seen($this->conversationId, Auth::id());
        }
    }

    public function sendMessage(): void
    {
        if (!$this->receiverId || (!$this->message && empty($this->media))) return;

        $mediaData = null;
        if ($this->media) {
            $paths = [];
            foreach ((array)$this->media as $file) {
                $paths[] = $file->store('chat_media', 'public');
            }
            $mediaData = json_encode($paths);
        }

        $this->orderMessageService->send($this->conversationId, $this->message, $mediaData);

        $this->reset(['message', 'media']);
        $this->loadMessages();
        $this->loadUsers();
        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.backend.user.chat.messages-component');
    }
}
