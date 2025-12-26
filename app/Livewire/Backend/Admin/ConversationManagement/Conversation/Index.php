<?php

namespace App\Livewire\Backend\Admin\ConversationManagement\Conversation;

use App\Services\ConversationService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'search')]
    public ?string $searchTerm = null;

    #[Url(as: 'conversation')]
    public ?int $selectedConversationId = null;

    public ?string $statusFilter = null;
    public bool $adminInvolvedOnly = false;
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    protected ConversationService $conversationService;

    public function boot(ConversationService $service)
    {
        $this->conversationService = $service;
    }

    #[Computed]
    public function conversations()
    {
        $filters = [];

        if ($this->statusFilter) {
            $filters['status'] = $this->statusFilter;
        }

        if ($this->adminInvolvedOnly) {
            $filters['admin_involved'] = true;
        }

        if ($this->dateFrom) {
            $filters['date_from'] = $this->dateFrom;
        }

        if ($this->dateTo) {
            $filters['date_to'] = $this->dateTo;
        }

        return $this->conversationService->fetchAllConversationsForAdmin(
            search: $this->searchTerm,
            filters: $filters,
            perPage: 20
        );
    }

    #[Computed]
    public function dashboardStats()
    {
        return $this->conversationService->getAdminDashboardStats();
    }

    public function selectConversation(int $conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->dispatch('admin-conversation-selected', conversationId: $conversationId);
    }

    #[On('refresh-admin-conversations')]
    public function refreshConversations()
    {
        unset($this->conversations);
        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        unset($this->conversations);
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        unset($this->conversations);
        $this->resetPage();
    }

    public function updatedAdminInvolvedOnly()
    {
        unset($this->conversations);
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['searchTerm', 'statusFilter', 'adminInvolvedOnly', 'dateFrom', 'dateTo']);
        unset($this->conversations);
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.backend.admin.conversation-management.conversation.index', [
            'stats' => $this->dashboardStats,
        ]);
    }
}
