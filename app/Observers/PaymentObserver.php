<?php

namespace App\Observers;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Payment Observer - Handles payment lifecycle events
 * 
 * IMPORTANT: This observer is called AFTER payment methods complete their work
 * It's a safety net for handling edge cases like:
 * - User loses internet after payment
 * - Webhook arrives before redirect
 * - Network issues during payment processing
 */
class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        Log::info('Payment created', [
            'payment_id' => $payment->payment_id,
            'order_id' => $payment->order->order_id ?? 'N/A',
            'amount' => $payment->amount,
            'gateway' => $payment->payment_gateway,
            'status' => $payment->status->value,
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     * This runs AFTER the payment is saved to database
     */
    public function updated(Payment $payment): void
    {
        // Only process if status was changed to COMPLETED
        if (!$payment->wasChanged('status') || $payment->status !== PaymentStatus::COMPLETED) {
            return;
        }

        Log::info('Payment status changed to COMPLETED', [
            'payment_id' => $payment->payment_id,
            'order_id' => $payment->order->order_id ?? 'N/A',
            'old_status' => $payment->getOriginal('status'),
        ]);

        try {
            // Ensure transaction exists
            // (Payment methods should have already created it, but this is a safety check)
            $this->ensureTransactionExists($payment);

            // Ensure order status is updated
            // (Payment methods should have already done this, but this ensures it)
            $this->ensureOrderStatusUpdated($payment);

            // Dispatch events for notifications, etc.
            event(new \App\Events\PaymentCompleted($payment));

            Log::info('Payment completion processing successful', [
                'payment_id' => $payment->payment_id,
                'order_id' => $payment->order->order_id ?? 'N/A',
            ]);
        } catch (\Exception $e) {
            Log::error('Post-payment processing failed', [
                'payment_id' => $payment->payment_id,
                'order_id' => $payment->order->order_id ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Don't throw - payment is already saved
            // Instead, dispatch a job to retry
            // dispatch(new \App\Jobs\RetryPaymentProcessing($payment->id));
        }
    }

    /**
     * Ensure transaction record exists for completed payment
     * This is a safety net - payment methods should create transactions
     */
    protected function ensureTransactionExists(Payment $payment): void
    {
        // Check if transaction already exists
        $existingTransaction = \App\Models\Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->first();

        if ($existingTransaction) {
            Log::debug('Transaction already exists', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $existingTransaction->transaction_id,
            ]);
            return;
        }

        // Create transaction as safety net
        Log::warning('Creating missing transaction in observer (should have been created by payment method)', [
            'payment_id' => $payment->payment_id,
        ]);

        DB::transaction(function () use ($payment) {
            \App\Models\Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'user_id' => $payment->user_id,
                'order_id' => $payment->order_id,
                'type' => TransactionType::PAYMENT->value,
                'status' => TransactionStatus::COMPLETED->value,
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'payment_gateway' => $payment->payment_gateway,
                'gateway_transaction_id' => $payment->transaction_id,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'net_amount' => $payment->amount,
                'metadata' => [
                    'payment_id' => $payment->payment_id,
                    'created_by' => 'observer_safety_net',
                ],
                'processed_at' => $payment->paid_at ?? now(),
            ]);
        });
    }

    /**
     * Ensure order status is updated based on payment
     * This is a safety net - payment methods should update order status
     */
    protected function ensureOrderStatusUpdated(Payment $payment): void
    {
        $order = $payment->order;

        if (!$order) {
            Log::error('Order not found for payment', [
                'payment_id' => $payment->payment_id,
                'order_id' => $payment->order_id,
            ]);
            return;
        }

        // Refresh order to get latest data
        $order->refresh();

        // Check if order needs status update
        if (
            $order->status === \App\Enums\OrderStatus::INITIALIZED ||
            $order->status === \App\Enums\OrderStatus::PENDING
        ) {

            Log::info('Updating order status in observer', [
                'order_id' => $order->order_id,
                'old_status' => $order->status->value,
            ]);

            DB::transaction(function () use ($order, $payment) {
                $order->updateStatusBasedOnPayment();

                // Ensure payment method is set
                if (!$order->payment_method) {
                    $order->update([
                        'payment_method' => ucfirst($payment->payment_gateway),
                    ]);
                }
            });
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        Log::warning('Payment deleted', [
            'payment_id' => $payment->payment_id,
            'order_id' => $payment->order->order_id ?? 'N/A',
            'amount' => $payment->amount,
        ]);
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        Log::info('Payment restored', [
            'payment_id' => $payment->payment_id,
            'order_id' => $payment->order->order_id ?? 'N/A',
        ]);
    }
}
