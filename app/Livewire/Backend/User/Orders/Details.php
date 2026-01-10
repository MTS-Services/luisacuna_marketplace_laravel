<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Enums\FeedbackType;
use App\Services\OrderService;

class Details extends Component
{

    public Order $data;
    public $isVisitSeller = false;
    public $positiveFeedbacksCount;
    public $negativeFeedbacksCount;


    protected OrderService $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function mount($orderId): void
    {
        $this->data = $this->orderService->findData($orderId, 'order_id');
        $this->isVisitSeller = $this->data->user_id !== user()->id;

        $allFeedbacks = $this->data?->user?->feedbacksReceived()->get();
        $this->positiveFeedbacksCount = $this->data?->user?->feedbacksReceived()->where('type', FeedbackType::POSITIVE->value)->count();
        $this->negativeFeedbacksCount = $this->data?->user?->feedbacksReceived()->where('type', FeedbackType::NEGATIVE->value)->count();

        // dd($this->data);
    }
    public function render()
    {
        return view('livewire.backend.user.orders.details');
    }
}
