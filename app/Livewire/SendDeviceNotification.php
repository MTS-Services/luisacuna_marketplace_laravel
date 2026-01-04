<?php

namespace App\Livewire;

use App\Services\FirebaseNotificationService;
use Livewire\Component;

class SendDeviceNotification extends Component
{
    public $deviceToken;
    public $title;
    public $body;

    protected FirebaseNotificationService $firebaseNotificationService;
    public function boot(FirebaseNotificationService $firebaseNotificationService)
    {
        $this->firebaseNotificationService = $firebaseNotificationService;
    }

    public function render()
    {
        return view('livewire.send-device-notification');
    }

    public function sendNotification()
    {
        $this->firebaseNotificationService->sendToDevice($this->deviceToken, $this->title, $this->body);
        return true;
    }
}
