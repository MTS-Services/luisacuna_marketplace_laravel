<?php

namespace App\Livewire\Backend\User\Chat;

use App\Services\ConversationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class IndexUser extends Component
{
    #[Url(as: 'search')]
    public ?string $searchTerm = null;

    #[Url(as: 'conversation')]
    public ?int $selectedConversationId = null;

    public bool $unreadOnly = false;

    public ?string $categoryFilter = null;

    // For tracking conversation updates in polling mode
    public ?string $lastConversationHash = null;

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

    /**
     * ✅ POLLING METHOD - Check for conversation updates without broadcasting
     * This method is called by JavaScript setInterval
     */
    public function pollForConversationUpdates()
    {
        // Get current conversation list
        $currentConversations = $this->service->fetchConversationList(
            search: $this->searchTerm,
            filters: $this->getFiltersArray()
        );

        // Create a hash of the current state (IDs + last message timestamps + unread counts)
        $currentHash = $this->generateConversationHash($currentConversations);

        // Check if there are changes
        if ($this->lastConversationHash !== null && $this->lastConversationHash !== $currentHash) {
            // Conversations have changed, refresh the list
            unset($this->conversations);
            $this->lastConversationHash = $currentHash;

            return ['hasUpdates' => true];
        }

        // Update hash for next poll
        $this->lastConversationHash = $currentHash;

        return ['hasUpdates' => false];
    }

    /**
     * Generate a hash representing the current state of conversations
     */
    protected function generateConversationHash($conversations): string
    {
        if ($conversations->isEmpty()) {
            return '';
        }

        $data = $conversations->map(function ($conversation) {
            return implode('|', [
                $conversation->id,
                $conversation->messages->first()?->id ?? 0,
                $conversation->messages->first()?->created_at?->timestamp ?? 0,
                $conversation->unread_count ?? 0,
            ]);
        })->implode('-');

        return md5($data);
    }

    /**
     * Get filters as array
     */
    protected function getFiltersArray(): array
    {
        $filters = [];

        if ($this->unreadOnly) {
            $filters['unread'] = true;
        }

        if ($this->categoryFilter) {
            $filters['category'] = $this->categoryFilter;
        }

        return $filters;
    }

    /**
     * ✅ BROADCASTING METHOD - Handle new message event from WebSocket
     * This is called when using Pusher/Reverb broadcasting
     */
    #[On('new-message')]
    public function handleNewMessage()
    {
        unset($this->conversations);
        $this->lastConversationHash = null; // Reset hash
        $this->dispatch('$refresh');
    }

    #[On('refresh-conversations')]
    public function refreshConversations()
    {
        unset($this->conversations);
        $this->lastConversationHash = null; // Reset hash
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
        $this->lastConversationHash = null;
    }

    public function updatedCategoryFilter()
    {
        unset($this->conversations);
        $this->lastConversationHash = null;
    }

    public function updatedSearchTerm()
    {
        $this->lastConversationHash = null;
    }

    public function getUnreadCountProperty()
    {
        return $this->service->getUnreadCount();
    }

    public function mount()
    {
        // Initialize hash on mount
        if ($this->conversations->isNotEmpty()) {
            $this->lastConversationHash = $this->generateConversationHash($this->conversations);
        }
    }

    public function render()
    {
        return view('livewire.backend.user.chat.index-user', [
            'totalUnreadCount' => $this->unreadCount,
        ]);
    }
}