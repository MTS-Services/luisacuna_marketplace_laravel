<?php

namespace App\Livewire;

use App\Services\FirebaseService;
use Livewire\Component;

class SendDeviceNotification extends Component
{
    public $deviceToken;
    public $title;
    public $body;

    protected FirebaseService $firebaseService;
    public function boot(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function mount()
    {
        $this->deviceToken = 'cmbyjIuxZXIGqbrCg-MtG5:APA91bF317KPDLWEROLxHemYOLOydQ0E_94fcQSPmWhR1cyha4VMqYQwJnjQE8ldXhypAFo85JmrvyuhdxuoDcDRW0h0YKKhejdoQ1chbzVPTPSjjeFmQX4';
        $this->title = 'Test Title';
        $this->body = 'Test Body | Hello World! 👋';
    }

    public function render()
    {
        return view('livewire.send-device-notification');
    }

    public function sendNotification()
    {
        $this->firebaseService->sendToDevice($this->deviceToken, $this->title, $this->body);
        return true;
    }
}
