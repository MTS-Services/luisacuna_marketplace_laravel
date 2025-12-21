<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Services\OrderService;
use App\Services\OrderMessageService;
use Livewire\WithFileUploads;

class OrderCanceledDetails extends Component
{
    use WithFileUploads;

    public $data;
    public $conversationId;
    public $sellerId;
    public $messageText;
    public $messages = [];

    protected OrderService $service;

    public function boot(OrderService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        // $this->data = $this->service->findData($orderId);

        // if (!$this->data) {
        //     abort(404, 'Order not found');
        // }
        // $product = $this->data->source;
        
        // if (!$product) {
        //     abort(404, 'Product not found for this order');
            
        // }

        // $this->sellerId = $product->user_id;

        // $this->loadMessages();
    }

    public function send()
    {
        // $this->validate([
        //     'messageText' => 'required|string|max:1000',
        // ]);

        $this->messageService->send(
            $this->conversationId,
            $this->messageText,
            null 
        );

        $this->messageText = '';
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->messageService->fetch(
            $this->conversationId
        );
    }

    public function render()
    {
        return view('livewire.backend.user.orders.order-canceled-details');
    }
}