<?php

namespace App\Observers;

use App\Jobs\SyncPaymentDataJob;
use App\Models\Payment;
use App\Models\Transaction;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PaymentObserver
{
    /**
     * Handle Payment created event.
     * ✅ SKIP observer logic for payments created with transactions already
     *    (Stripe/Wallet methods create their own transactions)
     */
    public function created(Payment $payment): void
    {
        // ✅ CRITICAL: Skip observer if transactions already exist
        // This prevents duplicate transaction creation when payment methods
        // (like StripeMethod or WalletMethod) already handle transactions
        $hasTransactions = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->exists();

        if ($hasTransactions) {
            Log::info('Payment created with existing transactions, skipping observer', [
                'payment_id' => $payment->payment_id,
                'status' => $payment->status->value,
            ]);
            return;
        }

        // Only handle if created with a terminal status
        if (!in_array($payment->status, [
            PaymentStatus::COMPLETED,
            PaymentStatus::FAILED,
            PaymentStatus::CANCELLED,
        ], true)) {
            Log::info('Payment created with non-terminal status, skipping', [
                'payment_id' => $payment->payment_id,
                'status' => $payment->status->value,
            ]);
            return;
        }

        Log::info('Payment created with terminal status (no transactions found)', [
            'payment_id' => $payment->payment_id,
            'status' => $payment->status->value,
            'gateway' => $payment->payment_gateway,
        ]);

        // Process the terminal status payment
        $this->processTerminalStatusPayment($payment);
    }

    /**
     * Handle Payment updated event.
     * ✅ Only trigger when status actually changes
     */
    public function updated(Payment $payment): void
    {
        // ✅ Only proceed if status changed
        if (!$payment->wasChanged('status')) {
            return; // Silent skip - no log spam
        }

        $oldStatus = $payment->getOriginal('status');
        $newStatus = $payment->status;

        // ✅ Skip if status didn't actually change (extra safety)
        if ($oldStatus === $newStatus->value) {
            return;
        }

        // Only handle specific statuses
        if (!in_array($payment->status, [
            PaymentStatus::COMPLETED,
            PaymentStatus::FAILED,
            PaymentStatus::CANCELLED,
            PaymentStatus::REFUNDED,
            PaymentStatus::PARTIALLY_REFUNDED,
        ], true)) {
            Log::info('Payment status not supported, skipping', [
                'payment_id' => $payment->payment_id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus->value,
            ]);
            return;
        }

        Log::info('Payment status updated', [
            'payment_id' => $payment->payment_id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus->value,
        ]);

        // Process the status change
        $this->processTerminalStatusPayment($payment);
    }

    /**
     * ✅ Centralized method to process terminal status payments
     */
    protected function processTerminalStatusPayment(Payment $payment): void
    {
        // ✅ Use a specific lock key that includes payment ID AND status
        $lockKey = "payment:process:{$payment->id}:{$payment->status->value}";

        // ✅ Try to acquire lock - if already locked, skip entirely
        if (!Cache::add($lockKey, true, now()->addMinutes(5))) {
            Log::info('Payment already being processed, skipping', [
                'payment_id' => $payment->payment_id,
                'status' => $payment->status->value,
            ]);
            return;
        }

        try {
            // Dispatch to queue for heavy operations
            SyncPaymentDataJob::dispatch($payment)
                ->onQueue('payments')
                ->delay(now()->addSeconds(2));

            Log::info('Payment sync job dispatched', [
                'payment_id' => $payment->payment_id,
                'status' => $payment->status->value,
            ]);
        } catch (\Exception $e) {
            // Release lock on failure
            Cache::forget($lockKey);

            Log::error('Failed to dispatch payment sync job', [
                'payment_id' => $payment->payment_id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * ✅ Create or update transaction based on payment status
     * NOTE: This is only called when transactions don't exist yet
     */
    public function syncTransaction(Payment $payment): void
    {
        // ✅ Check if transactions already exist (Bridge Pattern creates 2 transactions)
        $existingTransactionCount = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->count();

        if ($existingTransactionCount > 0) {
            Log::info('Transactions already exist for this payment, skipping sync', [
                'payment_id' => $payment->payment_id,
                'transaction_count' => $existingTransactionCount,
            ]);
            return;
        }

        $transactionLockKey = "transaction:create:{$payment->id}";

        if (!Cache::add($transactionLockKey, true, now()->addMinutes(5))) {
            Log::info('Transaction creation already in progress', [
                'payment_id' => $payment->payment_id,
            ]);
            return;
        }

        try {
            DB::transaction(function () use ($payment) {
                // Double-check inside transaction
                $transaction = Transaction::where('source_id', $payment->id)
                    ->where('source_type', Payment::class)
                    ->lockForUpdate()
                    ->first();

                $transactionStatus = $this->mapPaymentStatusToTransactionStatus($payment->status);

                if (!$transaction) {
                    $this->createTransaction($payment, $transactionStatus);
                } else {
                    // ✅ Only update if status actually changed
                    if ($transaction->status !== $transactionStatus->value) {
                        $transaction->update([
                            'status' => $transactionStatus,
                            'processed_at' => now(),
                            'failure_reason' => $payment->status === PaymentStatus::FAILED
                                ? ($payment->notes ?? 'Payment failed')
                                : null,
                        ]);

                        Log::info('Transaction status synced', [
                            'transaction_id' => $transaction->transaction_id,
                            'payment_id' => $payment->payment_id,
                            'old_status' => $transaction->getOriginal('status'),
                            'new_status' => $transactionStatus->value,
                        ]);
                    }
                }
            });
        } finally {
            Cache::forget($transactionLockKey);
        }
    }

    /**
     * ✅ Create transaction (only for legacy/fallback cases)
     */
    protected function createTransaction(Payment $payment, TransactionStatus $status): void
    {
        // ✅ Final safety check
        $exists = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->exists();

        if ($exists) {
            Log::warning('Transaction already exists, skipping creation', [
                'payment_id' => $payment->payment_id,
            ]);
            return;
        }

        Log::info('Creating fallback transaction via observer', [
            'payment_id' => $payment->payment_id,
            'status' => $status->value,
            'note' => 'This should only happen for legacy/manual payments',
        ]);

        Transaction::create([
            'transaction_id' => generate_transaction_id_hybrid(),
            'user_id' => $payment->user_id,
            'order_id' => $payment->order_id,
            'type' => TransactionType::PURCHSED->value,
            'status' => $status,
            'calculation_type' => null, // Let it be determined elsewhere or manually
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'payment_gateway' => $payment->payment_gateway,
            'gateway_transaction_id' => $payment->transaction_id,
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'fee_amount' => 0,
            'net_amount' => $payment->amount,
            'balance_snapshot' => 0, // ⚠️ Cannot calculate without wallet context
            'metadata' => [
                'payment_id' => $payment->payment_id,
                'payment_method_id' => $payment->payment_method_id,
                'payment_intent_id' => $payment->payment_intent_id,
                'created_by' => 'payment_observer',
                'warning' => 'Fallback transaction - balance_snapshot not accurate',
            ],
            'notes' => 'Fallback transaction created by observer',
            'processed_at' => $payment->paid_at ?? now(),
            'failure_reason' => $payment->status === PaymentStatus::FAILED
                ? ($payment->notes ?? 'Payment failed')
                : null,
        ]);
    }

    /**
     * ✅ Map payment status to transaction status
     */
    protected function mapPaymentStatusToTransactionStatus(PaymentStatus $paymentStatus): TransactionStatus
    {
        return match ($paymentStatus) {
            PaymentStatus::COMPLETED => TransactionStatus::PAID,
            PaymentStatus::FAILED, PaymentStatus::CANCELLED => TransactionStatus::FAILED,
            PaymentStatus::REFUNDED, PaymentStatus::PARTIALLY_REFUNDED => TransactionStatus::REVERSED,
            default => TransactionStatus::PENDING,
        };
    }

    /**
     * ✅ Sync order status based on payment status
     */
    public function syncOrderStatus(Payment $payment): void
    {
        if (!$payment->order_id) {
            Log::warning('Payment has no order_id, skipping order sync', [
                'payment_id' => $payment->payment_id,
            ]);
            return;
        }

        $orderLockKey = "order:update:{$payment->order_id}:{$payment->status->value}";

        if (!Cache::add($orderLockKey, true, now()->addMinutes(5))) {
            Log::info('Order update already in progress', [
                'payment_id' => $payment->payment_id,
                'order_id' => $payment->order_id,
            ]);
            return;
        }

        try {
            DB::transaction(function () use ($payment) {
                $order = $payment->order()->lockForUpdate()->first();

                if (!$order) {
                    Log::error('Order not found for payment', [
                        'payment_id' => $payment->payment_id,
                        'order_id' => $payment->order_id,
                    ]);
                    return;
                }

                // ✅ Skip if order already in terminal status
                if (in_array($order->status, [
                    OrderStatus::PAID,
                    OrderStatus::COMPLETED,
                    OrderStatus::CANCELLED,
                    OrderStatus::REFUNDED,
                    OrderStatus::FAILED,
                ], true)) {
                    Log::info('Order already in terminal status, skipping update', [
                        'order_id' => $order->order_id,
                        'current_status' => $order->status->value,
                        'payment_status' => $payment->status->value,
                    ]);
                    return;
                }

                $newStatus = $this->mapPaymentStatusToOrderStatus($payment->status);

                if (!$newStatus) {
                    return; // No mapping for this payment status
                }

                // ✅ Only update if status actually changes
                if ($order->status->value === $newStatus->value) {
                    Log::info('Order status already matches payment status', [
                        'order_id' => $order->order_id,
                        'status' => $order->status->value,
                    ]);
                    return;
                }

                $updateData = ['status' => $newStatus];

                // ✅ Only set payment_method if not already set
                if ($payment->status === PaymentStatus::COMPLETED && !$order->payment_method) {
                    $updateData['payment_method'] = ucfirst($payment->payment_gateway);
                }

                // ✅ Only set completed_at if transitioning to PAID and not already set
                if ($newStatus === OrderStatus::PAID && !$order->completed_at) {
                    $updateData['completed_at'] = now();
                }

                $order->update($updateData);

                Log::info('Order status synced', [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'old_status' => $order->getOriginal('status'),
                    'new_status' => $newStatus->value,
                    'updated_fields' => array_keys($updateData),
                ]);
            });
        } finally {
            Cache::forget($orderLockKey);
        }
    }

    /**
     * ✅ Map payment status to order status
     */
    protected function mapPaymentStatusToOrderStatus(PaymentStatus $paymentStatus): ?OrderStatus
    {
        return match ($paymentStatus) {
            PaymentStatus::COMPLETED => OrderStatus::PAID,
            PaymentStatus::FAILED => OrderStatus::FAILED,
            PaymentStatus::CANCELLED => OrderStatus::CANCELLED,
            PaymentStatus::PARTIALLY_REFUNDED => OrderStatus::PARTIALLY_REFUNDED,
            PaymentStatus::REFUNDED => OrderStatus::REFUNDED,
            default => null,
        };
    }
}
