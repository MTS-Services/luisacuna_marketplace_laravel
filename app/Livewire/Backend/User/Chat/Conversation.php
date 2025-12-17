<?php

namespace App\Livewire\Backend\User\Chat;

use App\Services\ConversationService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Conversation extends Component
{

    public Collection $conversations;

    #[Url(as: 'perticipants')]
    public ?string $perticipants = null;

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
        $this->conversations = new Collection();
    }

    #[On('search', 'refresh', 'new-message')]
    public function fetchConversations()
    {
        $this->conversations =  $this->service->fetchConversations(search: $this->perticipants);
    }


    public function render()
    {
        $this->fetchConversations();
        return view('livewire.backend.user.chat.conversation');
    }
}
