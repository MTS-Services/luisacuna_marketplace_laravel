<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderStateMachine;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OrderAutoCancelCommand extends Command
{
    protected $signature = 'orders:auto-cancel';

    protected $description = 'Auto-cancel orders where the seller did not respond to a cancel request within 72 hours';

    public function handle(OrderStateMachine $stateMachine): int
    {
        $orders = Order::query()
            ->where('status', OrderStatus::CANCEL_REQ_BY_BUYER->value)
            ->orWhere('status', OrderStatus::CANCEL_REQ_BY_SELLER->value)
            ->whereNotNull('auto_cancels_at')
            ->where('auto_cancels_at', '<=', now())
            ->get();

        $cancelled = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                $stateMachine->transition(
                    order: $order,
                    targetStatus: OrderStatus::CANCELLED,
                    actor: null,
                    meta: ['auto_cancelled' => true],
                );

                $cancelled++;
                $this->components->info("Order #{$order->order_id} auto-cancelled (seller non-response).");
            } catch (\Throwable $e) {
                $failed++;
                Log::error('Auto-cancel failed for order', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                ]);
                $this->components->error("Failed: Order #{$order->order_id} — {$e->getMessage()}");
            }
        }

        $this->components->info("Auto-cancel finished: {$cancelled} cancelled, {$failed} failed.");

        return self::SUCCESS;
    }
}
