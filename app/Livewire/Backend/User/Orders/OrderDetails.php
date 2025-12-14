<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Services\OrderService;
use App\Services\OrderMessageService;
use Livewire\WithFileUploads;

class OrderDetails extends Component
{
    use WithFileUploads;

    public $data;
    public $messages = [];
    public $newMessage = '';
    public $attachments = [];

    protected OrderService $service;
    protected OrderMessageService $messageService;

    public function boot(OrderService $service, OrderMessageService $messageService)
    {
        $this->service = $service;
        $this->messageService = $messageService;
    }

    public function mount($orderId): void
    {
        $this->data = $this->service->findData($orderId);

        if (!$this->data) {
            abort(404);
        }

        // $this->loadMessages();
    }

    // public function loadMessages()
    // {
    //     $this->messages = $this->messageService->getMessages(
    //         auth()->id(), 
    //         $this->data->seller_id
    //     );

    //     $this->messageService->markAsSeen($this->data->seller_id, auth()->id());
    // }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:5000',
        ]);

        $this->messageService->sendOrderMessage(
            auth()->id(),
            $this->data->seller_id,
            $this->newMessage
        );

        $this->reset('newMessage');
        // $this->loadMessages();
        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.backend.user.orders.order-details');
    }
}