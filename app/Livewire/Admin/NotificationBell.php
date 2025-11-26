<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBell extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $admin = admin();

        if ($admin) {
            $this->notifications = $admin->notifications()
                ->latest()
                ->take(10)
                ->get()
                ->toArray();

            $this->unreadCount = $admin->unreadNotifications()->count();
        }
    }

    #[On('notification-received')]
    public function notificationReceived()
    {
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = admin()
            ->notifications()
            ->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        admin()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function render()
    {
        return view('livewire.admin.notification-bell');
    }
}
