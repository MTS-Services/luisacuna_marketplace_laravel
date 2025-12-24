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
     * Handle Payment updated event.
     */
    public function updated(Payment $payment): void
    {
        // Only proceed if status changed
        if (!$payment->wasChanged('status')) {
            Log::info('Payment status unchanged, skipping', [
                'payment_id' => $payment->payment_id,
            ]);
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
                'new_status' => $payment->status->value,
            ]);
            return;
        }

        Log::info('Payment status updated', [
            'payment_id' => $payment->payment_id,
            'old_status' => $payment->getOriginal('status'),
            'new_status' => $payment->status->value,
        ]);

        // Idempotency check - prevent duplicate processing
        $lockKey = "payment:sync:{$payment->id}:{$payment->status->value}";

        if (!Cache::add($lockKey, true, now()->addMinutes(5))) {
            Log::info('Payment sync already in progress, skipping', [
                'payment_id' => $payment->payment_id,
                'lock_key' => $lockKey,
            ]);
            return;
        }

        try {
            // Dispatch to queue for heavy operations
            SyncPaymentDataJob::dispatch($payment)
                ->onQueue('payments')
                ->delay(now()->addSeconds(2)); // Small delay to ensure payment is committed

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
     * Create or update transaction based on payment status.
     * This method can still be called synchronously if needed.
     */
    public function syncTransaction(Payment $payment): void
    {
        // Idempotency check for transaction creation
        $transactionLockKey = "transaction:create:{$payment->id}";

        if (!Cache::add($transactionLockKey, true, now()->addMinutes(5))) {
            Log::info('Transaction creation already in progress', [
                'payment_id' => $payment->payment_id,
            ]);
            return;
        }

        try {
            DB::transaction(function () use ($payment) {
                // Lock the transaction row to prevent race conditions
                $transaction = Transaction::where('source_id', $payment->id)
                    ->where('source_type', Payment::class)
                    ->lockForUpdate()
                    ->first();

                $transactionStatus = $this->mapPaymentStatusToTransactionStatus($payment->status);

                if (!$transaction) {
                    $this->createTransaction($payment, $transactionStatus);
                } else {
                    // Update transaction if status changed
                    if ($transaction->status !== $transactionStatus) {
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
                            'new_status' => $transactionStatus->value,
                        ]);
                    }
                }
            });
        } finally {
            // Always release the lock
            Cache::forget($transactionLockKey);
        }
    }

    /**
     * Create a new transaction for the payment.
     */
    protected function createTransaction(Payment $payment, TransactionStatus $status): void
    {
        // Double-check transaction doesn't exist (extra safety)
        $exists = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->exists();

        if ($exists) {
            Log::warning('Transaction already exists, skipping creation', [
                'payment_id' => $payment->payment_id,
            ]);
            return;
        }

        Log::info('Creating transaction via observer', [
            'payment_id' => $payment->payment_id,
            'status' => $status->value,
        ]);

        Transaction::create([
            'transaction_id' => generate_transaction_id_hybrid(),
            'user_id' => $payment->user_id,
            'order_id' => $payment->order_id,
            'type' => TransactionType::PAYMENT,
            'status' => $status,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'payment_gateway' => $payment->payment_gateway,
            'gateway_transaction_id' => $payment->transaction_id,
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'fee_amount' => 0, // Calculate if needed
            'net_amount' => $payment->amount,
            'metadata' => [
                'payment_id' => $payment->payment_id,
                'payment_method_id' => $payment->payment_method_id,
                'payment_intent_id' => $payment->payment_intent_id,
                'created_by' => 'payment_observer',
            ],
            'processed_at' => $payment->paid_at ?? now(),
            'failure_reason' => $payment->status === PaymentStatus::FAILED
                ? ($payment->notes ?? 'Payment failed')
                : null,
        ]);
    }

    /**
     * Map payment status to transaction status.
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
     * Update order status based on payment status.
     */
    public function syncOrderStatus(Payment $payment): void
    {
        // Idempotency check for order update
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
                // Lock the order row
                $order = $payment->order()->lockForUpdate()->first();

                if (!$order) {
                    Log::error('Order not found for payment', [
                        'payment_id' => $payment->payment_id,
                        'order_id' => $payment->order_id,
                    ]);
                    return;
                }

                // Don't update terminal order statuses
                if (in_array($order->status, [
                    OrderStatus::COMPLETED,
                    OrderStatus::CANCELLED,
                    OrderStatus::REFUNDED,
                    OrderStatus::FAILED,
                ], true)) {
                    Log::info('Order already in terminal status, skipping update', [
                        'order_id' => $order->id,
                        'current_status' => $order->status->value,
                    ]);
                    return;
                }

                $newStatus = $this->mapPaymentStatusToOrderStatus($payment->status);

                if ($newStatus && $order->status !== $newStatus) {
                    $updateData = ['status' => $newStatus];

                    // Set payment method only for successful payments
                    if ($payment->status === PaymentStatus::COMPLETED && !$order->payment_method) {
                        $updateData['payment_method'] = ucfirst($payment->payment_gateway);
                    }

                    $order->update($updateData);

                    Log::info('Order status synced', [
                        'order_id' => $order->id,
                        'payment_id' => $payment->payment_id,
                        'old_status' => $order->getOriginal('status'),
                        'new_status' => $newStatus->value,
                    ]);
                }
            });
        } finally {
            // Always release the lock
            Cache::forget($orderLockKey);
        }
    }

    /**
     * Map payment status to order status.
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
