<?php

namespace App\Livewire\Backend\User\Orders;

use App\Models\Order;
use Livewire\Component;
use App\Enums\OrderStatus;
use App\Enums\FeedbackType;
use App\Services\OrderService;
use App\Services\FeedbackService;
use App\Traits\Livewire\WithNotification;

class Complete extends Component
{

    use WithNotification;


    public Order $order;
    public $isVisitSeller = false;
    public $conversationId = null;
    public $commentText = '';
    public $type;
    public $rating;
    public $feedback;


    protected OrderService $orderService;
    protected FeedbackService $feedbackService;
    public function boot(OrderService $orderService, FeedbackService $feedbackService)
    {
        $this->orderService = $orderService;
        $this->feedbackService = $feedbackService;
    }

    public function mount(string $orderId)
    {
        $this->order = $this->orderService->findData($orderId, 'order_id');
        $this->order->load([
            'user',
            'source.user',
            'source.game',
            'source.platform',
            'transactions',
            'messages.conversation'
        ]);
        $this->isVisitSeller = $this->order->user_id !== user()->id;
        $this->conversationId = $this->order->messages?->first()?->conversation->id ?? null;
        $this->dispatch('conversation-selected', conversationId: $this->conversationId);
    }

    public function fetchFeedback()
    {
        $this->feedback = $this->feedbackService->getFeedbackByOrder($this->order->id, $this->isVisitSeller);
    }

    public function cancelOrder()
    {
        $this->order->status = OrderStatus::CANCELLED->value;
        $this->order->save();

        return redirect()->route('user.order.purchased-orders');
    }
    public function render()
    {
        $this->fetchFeedback();
        return view('livewire.backend.user.orders.complete');
    }
    public function submitFeedback()
    {


        $this->validate([
            'type' => 'required|in:' . FeedbackType::POSITIVE->value . ',' . FeedbackType::NEGATIVE->value,
            'commentText' => 'required|string|min:5|max:1000',
        ]);

        $this->feedbackService->createData([
            'author_id'      => user()->id,
            'target_user_id' => $this->isVisitSeller ? $this->order->user_id : $this->order->source->user_id,
            'order_id'       => $this->order->id,
            'type'           => $this->type,
            'message'        => $this->commentText,
            'rating'         => $this->rating,
        ]);

        $this->reset(['commentText', 'type']);

        $this->dispatch('close-modal');
        $this->success(__('Feedback submitted successfully!'));

        $this->fetchFeedback();
    }
}
