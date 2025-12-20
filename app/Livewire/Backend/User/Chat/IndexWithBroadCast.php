<?php

namespace App\Livewire\Backend\User\Chat;

use App\Services\ConversationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class IndexWithBroadCast extends Component
{
    #[Url(as: 'search')]
    public ?string $searchTerm = null;

    #[Url(as: 'conversation')]
    public ?int $selectedConversationId = null;

    public bool $unreadOnly = false;

    public ?string $categoryFilter = null;

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    #[Computed]
    public function conversations()
    {
        $filters = [];

        if ($this->unreadOnly) {
            $filters['unread'] = true;
        }

        if ($this->categoryFilter) {
            $filters['category'] = $this->categoryFilter;
        }

        return $this->service->fetchConversationList(
            search: $this->searchTerm,
            filters: $filters
        );
    }

    public function selectConversation(int $conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->dispatch('conversation-selected', conversationId: $conversationId);
    }

    #[On('new-message')]
    public function handleNewMessage()
    {
        unset($this->conversations);
        $this->dispatch('$refresh');
    }

    #[On('refresh-conversations')]
    public function refreshConversations()
    {
        unset($this->conversations);
    }

    public function markAllAsRead()
    {
        try {
            $conversations = $this->service->fetchConversationList();
            
            foreach ($conversations as $conversation) {
                $this->service->markMessagesAsRead($conversation, Auth::id());
            }

            $this->dispatch('success', message: 'All messages marked as read');
            $this->refreshConversations();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Failed to mark messages as read');
        }
    }

    public function updatedUnreadOnly()
    {
        unset($this->conversations);
    }

    public function updatedCategoryFilter()
    {
        unset($this->conversations);
    }

    public function getUnreadCountProperty()
    {
        return $this->service->getUnreadCount();
    }

    public function render()
    {
        return view('livewire.backend.user.chat.index', [
            'totalUnreadCount' => $this->unreadCount,
        ]);
    }
}