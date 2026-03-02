<?php

namespace App\Livewire\Backend\User\Chat;

use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url(as: 'search')]
    public ?string $searchTerm = null;

    // ✅ Use conversation_uuid in URL (hides real DB id)
    #[Url(as: 'c')]
    public ?string $selectedConversationUuid = null;

    // Internal resolved id (never exposed in URL)
    public ?int $selectedConversationId = null;

    public bool $unreadOnly = false;

    public ?string $categoryFilter = null;

    public ?string $lastConversationHash = null;

    protected ConversationService $service;

    public function boot(ConversationService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        // If UUID provided in URL, resolve to internal id on load
        if ($this->selectedConversationUuid) {
            $conversation = Conversation::where('conversation_uuid', $this->selectedConversationUuid)
                ->whereHas('participants', fn ($q) => $q
                    ->where('participant_id', Auth::id())
                    ->where('is_active', true))
                ->select('id', 'conversation_uuid')
                ->first();

            if ($conversation) {
                $this->selectedConversationId = $conversation->id;
            }
        }

        if ($this->conversations->isNotEmpty()) {
            $this->lastConversationHash = $this->generateConversationHash($this->conversations);
        }
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

    /**
     * Select conversation by UUID (safe, hides DB id)
     */
    public function selectConversation(string $conversationUuid)
    {
        // Look up the real id server-side only
        $conversation = Conversation::where('conversation_uuid', $conversationUuid)
            ->whereHas('participants', fn ($q) => $q
                ->where('participant_id', Auth::id())
                ->where('is_active', true))
            ->select('id', 'conversation_uuid')
            ->first();

        if (! $conversation) {
            return;
        }

        $this->selectedConversationUuid = $conversationUuid;
        $this->selectedConversationId = $conversation->id;

        // Dispatch with internal id (internal only, not in URL)
        $this->dispatch('conversation-selected', conversationId: $conversation->id);
    }

    public function pollForConversationUpdates()
    {
        $currentConversations = $this->service->fetchConversationList(
            search: $this->searchTerm,
            filters: $this->getFiltersArray()
        );

        $currentHash = $this->generateConversationHash($currentConversations);

        if ($this->lastConversationHash !== null && $this->lastConversationHash !== $currentHash) {
            unset($this->conversations);
            $this->lastConversationHash = $currentHash;

            return ['hasUpdates' => true];
        }

        $this->lastConversationHash = $currentHash;

        return ['hasUpdates' => false];
    }

    protected function generateConversationHash($conversations): string
    {
        if ($conversations->isEmpty()) {
            return '';
        }

        $data = $conversations->map(fn ($c) => implode('|', [
            $c->id,
            $c->messages->first()?->id ?? 0,
            $c->messages->first()?->created_at?->timestamp ?? 0,
            $c->unread_count ?? 0,
        ]))->implode('-');

        return md5($data);
    }

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

    #[On('new-message')]
    public function handleNewMessage()
    {
        unset($this->conversations);
        $this->lastConversationHash = null;
        $this->dispatch('$refresh');
    }

    #[On('refresh-conversations')]
    public function refreshConversations()
    {
        unset($this->conversations);
        $this->lastConversationHash = null;
    }

    public function markAllAsRead()
    {
        try {
            $conversations = $this->service->fetchConversationList();
            foreach ($conversations as $conversation) {
                $this->service->markMessagesAsRead($conversation, Auth::id());
            }
            $this->dispatch('success', message: __('All messages marked as read'));
            $this->refreshConversations();
        } catch (\Exception $e) {
            $this->dispatch('error', message: __('Failed to mark messages as read'));
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

    public function render()
    {
        return view('livewire.backend.user.chat.index', [
            'totalUnreadCount' => $this->unreadCount,
        ]);
    }
}
