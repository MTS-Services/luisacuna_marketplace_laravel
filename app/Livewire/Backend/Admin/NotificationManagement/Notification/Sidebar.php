<?php

namespace App\Livewire\Backend\Admin\NotificationManagement\Notification;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    public bool $openSidebarNotifications = false;
    public Collection $notifications;
    public bool $isLoading = true;

    protected NotificationService $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->notifications = new Collection();
    }

    public function mount()
    {
        // $this->fetchNotifications();
    }

    public function render()
    {
        return view('livewire.backend.admin.notification-management.notification.sidebar');
    }

    #[On('open-sidebar-notifications')]
    public function openSidebar()
    {
        $this->openSidebarNotifications = true;
        $this->fetchNotifications();
    }

    public function fetchNotifications()
    {
        $this->isLoading = true;
        $this->notifications = $this->notificationService->getRecent();
        $this->isLoading = false;
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead();
        $this->fetchNotifications();
        $this->dispatch('notifications-marked-read');
    }

    #[On('close-sidebar-notifications')]
    public function closeSidebar()
    {
        $this->openSidebarNotifications = false;
        $this->reset();
    }
}
