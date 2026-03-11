<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderStateMachine;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OrderAutoCompleteCommand extends Command
{
    protected $signature = 'orders:auto-complete';

    protected $description = 'Auto-complete delivered orders that have passed the 72-hour window';

    public function handle(OrderStateMachine $stateMachine): int
    {
        $orders = Order::query()
            ->where('status', OrderStatus::DELIVERED->value)
            ->whereNotNull('auto_completes_at')
            ->where('auto_completes_at', '<=', now())
            ->get();

        $completed = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                $stateMachine->transition(
                    order: $order,
                    targetStatus: OrderStatus::COMPLETED,
                    actor: null,
                    meta: [],
                );

                $completed++;

                $this->components->info("Order #{$order->order_id} auto-completed.");
            } catch (\Throwable $e) {
                $failed++;

                Log::error('Auto-complete failed for order', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                ]);

                $this->components->error("Failed: Order #{$order->order_id} — {$e->getMessage()}");
            }
        }

        $this->components->info("Auto-complete finished: {$completed} completed, {$failed} failed.");

        return self::SUCCESS;
    }
}
