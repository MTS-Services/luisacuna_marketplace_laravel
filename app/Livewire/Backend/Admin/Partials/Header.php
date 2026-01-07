<?php

namespace App\Livewire\Backend\Admin\Partials;

use App\Enums\CustomNotificationType;
use App\Models\Admin;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public string $breadcrumb = '';

    public bool $showNotificationIndicator = false;

    protected NotificationService $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount(string $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
        $this->unreadExists();
    }

    #[On('notification-updated')]
    public function unreadExists()
    {
        $this->showNotificationIndicator = $this->notificationService->unreadExists(type: null, receiverType: Admin::class, receiverId: admin()->id);
    }


    public function render()
    {
        return view('backend.admin.layouts.partials.header');
    }
}
