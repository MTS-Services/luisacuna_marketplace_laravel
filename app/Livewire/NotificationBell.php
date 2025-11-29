<?php

namespace App\Livewire;

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
        $user = user();
        
        if ($user) {
            $this->notifications = $user->notifications()
                ->latest()
                ->take(10)
                ->get()
                ->toArray();
            
            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    #[On('notification-received')]
    public function notificationReceived()
    {
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = user()
            ->notifications()
            ->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}