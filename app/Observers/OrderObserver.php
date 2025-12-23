<?php

namespace App\Observers;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Events\OrderCompleted;
use App\Events\OrderPartiallyPaid;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        Log::info('Order created', [
            'order_id' => $order->order_id,
            'user_id' => $order->user_id,
            'grand_total' => $order->grand_total,
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Log status changes
        if ($order->wasChanged('status')) {
            Log::info('Order status changed', [
                'order_id' => $order->order_id,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $order->status->value,
                'total_paid' => $order->getTotalPaid(),
                'grand_total' => $order->grand_total,
            ]);

            // Handle completed orders
            if ($order->status === OrderStatus::COMPLETED) {
                event(new OrderCompleted($order));
            }

            // Handle partially paid orders
            if ($order->status === OrderStatus::PARTIALLY_PAID) {
                event(new OrderPartiallyPaid($order));
            }
        }
    }

    /**
     * Handle the Order "deleting" event.
     */
    public function deleting(Order $order): void
    {
        // Prevent deletion of paid orders
        if ($order->getTotalPaid() > 0) {
            Log::warning('Attempt to delete paid order prevented', [
                'order_id' => $order->order_id,
                'total_paid' => $order->getTotalPaid(),
            ]);

            throw new \Exception('Cannot delete an order with payments. Please refund first.');
        }
    }
}
