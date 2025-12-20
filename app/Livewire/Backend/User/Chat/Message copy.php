<?php

namespace App\Livewire\Backend\User\Chat;

use App\Models\Conversation;
use Livewire\Component;

use App\Services\ConversationService;
use Livewire\WithFileUploads;

class Message extends Component
{
    use WithFileUploads;

    public Conversation $conversation;

    protected ConversationService $service;


    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }
    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function fetchConversations()
    {
        //
    }
}
