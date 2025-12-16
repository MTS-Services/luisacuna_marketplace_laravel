<?php

namespace App\Livewire\Backend\Admin\ChatManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\OrderMessageService;
use App\Models\Conversation;

class Chat extends Component
{
    use WithPagination;

    public $selectedConversationId;
    public $messages = [];
    public $conversationDetails;
    public $search = '';

    protected $orderMessageService;

    public function boot(OrderMessageService $orderMessageService)
    {
        $this->orderMessageService = $orderMessageService;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->selectedConversationId) {
            $this->messages = $this->orderMessageService
                ->fetchForAdmin($this->selectedConversationId)
                ->toArray();
            
            $conversation = Conversation::with(['conversation_participants.user'])
                ->find($this->selectedConversationId);
            
            $this->conversationDetails = $conversation;
        }
    }

    public function render()
    {
        // Get paginated data but don't store it in a property
        $conversations = $this->orderMessageService->getPaginated(50, [
            'search' => $this->search,
            'sort_field' => 'last_message_at',
            'sort_direction' => 'desc'
        ]);

        return view('livewire.backend.admin.chat-management.chat', [
            'conversations' => $conversations
        ]);
    }
}