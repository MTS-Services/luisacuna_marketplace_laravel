<?php

namespace App\Livewire\Backend\User\Messages;

use App\Services\ConversationService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageNotificationSidebar extends Component
{
    public bool $isOpen = false;
    public bool $initialized = false;

    protected ConversationService $service;

    public function boot(ConversationService $service): void
    {
        $this->service = $service;
    }

    #[Computed]
    public function conversations()
    {
        if (!$this->initialized) {
            return collect();
        }

        try {
            return $this->service->fetchConversationList();
        } catch (\Exception $e) {
            Log::error('Sidebar Fetch Error: ' . $e->getMessage());
            return collect();
        }
    }

    #[On('user-message-notification-show')]
    public function openSidebar(): void
    {
        $this->initialized = false;
        unset($this->conversations);

        $this->isOpen = true;
        $this->initialized = true;
    }

    /**
     * This now runs in the background 
     * without blocking the UI.
     */
    public function closeSidebar(): void
    {
        $this->isOpen = false;
        $this->initialized = false;
        unset($this->conversations);
    }

    #[On('message-received'), On('message-created')]
    public function refreshMessages(): void
    {
        unset($this->conversations);
    }

    public function render()
    {
        return view('livewire.backend.user.messages.message-notification-sidebar');
    }
}
