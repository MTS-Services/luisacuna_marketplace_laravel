<?php

namespace App\Livewire\Backend\User\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderMessageService;

class MessagesComponent extends Component
{

    use WithFileUploads;

    public $receiverId = null;
    public $message = '';
    public $media;
    public $users;
    public $messages = [];

    protected OrderMessageService $orderMessageService;

    public function boot(OrderMessageService $orderMessageService)
    {
        $this->orderMessageService = $orderMessageService;
    }

    public function mount()
    {
        $this->users = $this->orderMessageService->getUsersSortedByLastMessage(Auth::id());
    }


    public function selectUser($userId)
    {
        $this->receiverId = $userId;
        $this->loadMessages();
        $this->orderMessageService->markAsSeen($userId, Auth::id());
    }

    public function loadMessages()
    {
        if ($this->receiverId) {
            $this->messages = $this->orderMessageService->getMessages(
                Auth::id(),
                $this->receiverId
            );
        }
    }

    public function sendMessage()
    {
        if (!$this->receiverId || (!$this->message && empty($this->media))) {
            return;
        }

        $mediaData = null;
        if (!empty($this->media)) {
            $paths = [];

            foreach ($this->media as $file) {
                $paths[] = $file->store('chat_media', 'public');
            }

            $mediaData = json_encode($paths);
        }

        $this->orderMessageService->sendOrderMessage(
            Auth::id(),
            $this->receiverId,
            $this->message,
            $mediaData
        );

        $this->reset(['message', 'media']);
        $this->loadMessages();
    }

    public function render()
    {
        $this->users = $this->orderMessageService->getUsersSortedByLastMessage(Auth::id());

        if ($this->receiverId) {
            $this->loadMessages();
        }

        return view('livewire.backend.user.chat.messages-component');
    }
}
