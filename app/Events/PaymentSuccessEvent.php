<?php

namespace App\Events;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $orderId;
    public int $paymentId;

    public function __construct(Order $order, Payment $payment)
    {
        // Store only IDs to prevent serialization issues
        $this->orderId = $order->id;
        $this->paymentId = $payment->id;
    }

    /**
     * Get the order instance
     */
    public function getOrder(): Order
    {
        return Order::with(['user', 'source.user'])->findOrFail($this->orderId);
    }

    /**
     * Get the payment instance
     */
    public function getPayment(): Payment
    {
        return Payment::findOrFail($this->paymentId);
    }
}
