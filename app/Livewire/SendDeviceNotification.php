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

    public function mount()
    {
        $this->deviceToken = 'c5niCKwZRzPqpbbihfRusH:APA91bGxuXLYsEADO7zzp6nKIcsSdk1w1-cGoAjUWKxBD157qNKuN0vczVfJx1fGWoGrJYFEB0nEIHeKz1Nn2xROBv9s4ckdVUAAsIjlGzF9mf32drM_aC8';
        $this->title = 'Test Title';
        $this->body = 'Test Body | Hello World! 👋';
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
