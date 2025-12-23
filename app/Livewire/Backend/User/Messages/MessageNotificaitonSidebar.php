<?php

namespace App\Livewire\Backend\User\Messages;

use Livewire\Attributes\On;
use Livewire\Component;

class MessageNotificaitonSidebar extends Component
{
    public $MessageNotificationShow = false;
    
    public function render()
    {
        return view('livewire.backend.user.messages.message-notificaiton-sidebar');
    }

    #[On('user-message-notification-show')]
    public function openMessageNotificationSidebar(): void
    {
        $this->MessageNotificationShow = true;
    }
}
