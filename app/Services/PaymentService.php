<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    public function processPayment(Order $order, string $gateway, array $paymentData = []): array
    {
        try {
            if (!$this->canProcessPayment($order)) {
                return [
                    'success' => false,
                    'message' => 'Order cannot accept payment at this time.',
                    'reason' => 'invalid_order_status',
                ];
            }

            $paymentGateway = \App\Models\PaymentGateway::where('slug', $gateway)
                ->where('is_active', true)
                ->first();

            if (!$paymentGateway || !$paymentGateway->isSupported()) {
                return [
                    'success' => false,
                    'message' => 'Payment gateway not available.',
                    'reason' => 'gateway_unavailable',
                ];
            }

            $paymentMethod = $paymentGateway->paymentMethod();
            return $paymentMethod->startPayment($order, $paymentData);
        } catch (Exception $e) {
            Log::error('Payment processing failed', [
                'order_id' => $order->order_id,
                'gateway' => $gateway,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage(),
                'reason' => 'exception',
            ];
        }
    }

    public function completePayment(Payment $payment, array $additionalData = []): bool
    {
        if ($payment->status === PaymentStatus::COMPLETED) {
            Log::info('Payment already completed', ['payment_id' => $payment->payment_id]);
            return true;
        }

        DB::beginTransaction();

        try {
            // Eager load to prevent N+1
            $payment->load(['order.user', 'user']);

            $transaction = $this->ensureTransactionExists($payment);

            $payment->update(array_merge([
                'status' => PaymentStatus::COMPLETED->value,
                'paid_at' => now(),
            ], $additionalData));

            if ($transaction->status !== TransactionStatus::COMPLETED) {
                $transaction->update([
                    'status' => TransactionStatus::COMPLETED->value,
                    'processed_at' => now(),
                ]);
            }

            $this->updateOrderStatus($payment->order);

            DB::commit();

            Log::info('Payment completed successfully', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $transaction->transaction_id,
                'order_id' => $payment->order->order_id,
            ]);

            try {
                event(new \App\Events\PaymentCompleted($payment));
            } catch (Exception $e) {
                Log::error('Event dispatch failed', [
                    'payment_id' => $payment->payment_id,
                    'error' => $e->getMessage(),
                ]);
            }

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Payment completion failed', [
                'payment_id' => $payment->payment_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    public function processPartialPayments(Order $order, array $payments): array
    {
        DB::beginTransaction();

        try {
            $results = [];
            $totalPaid = 0;

            foreach ($payments as $index => $paymentConfig) {
                $gateway = $paymentConfig['gateway'];
                $amount = $paymentConfig['amount'];

                Log::info('Processing partial payment', [
                    'order_id' => $order->order_id,
                    'payment_index' => $index,
                    'gateway' => $gateway,
                    'amount' => $amount,
                ]);

                $partialOrder = $this->createPartialOrderContext($order, $amount);
                $result = $this->processPayment($partialOrder, $gateway, $paymentConfig);

                if (!$result['success']) {
                    Log::error('Partial payment failed, rolling back all', [
                        'order_id' => $order->order_id,
                        'failed_gateway' => $gateway,
                        'reason' => $result['message'],
                    ]);

                    DB::rollBack();
                    return $result;
                }

                $results[] = $result;
                $totalPaid += $amount;
            }

            $order->refresh();
            $order->updateStatusBasedOnPayment();

            DB::commit();

            Log::info('Partial payments completed', [
                'order_id' => $order->order_id,
                'total_paid' => $totalPaid,
                'payments_count' => count($payments),
            ]);

            return [
                'success' => true,
                'message' => 'All payments completed successfully',
                'results' => $results,
                'total_paid' => $totalPaid,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Partial payment processing failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Partial payment failed: ' . $e->getMessage(),
            ];
        }
    }

    public function failPayment(Payment $payment, ?string $reason = null): bool
    {
        DB::beginTransaction();

        try {
            $payment->load(['order', 'transaction']);

            $payment->update([
                'status' => PaymentStatus::FAILED->value,
                'notes' => $reason,
            ]);

            if ($payment->transaction) {
                $payment->transaction->update([
                    'status' => TransactionStatus::FAILED->value,
                    'failure_reason' => $reason,
                ]);
            }


            if (!$payment->order->hasSuccessfulPayment()) {
                $payment->order->update([
                    'status' => OrderStatus::FAILED->value,
                ]);
            }

            DB::commit();

            Log::info('Payment marked as failed', [
                'payment_id' => $payment->payment_id,
                'reason' => $reason,
            ]);

            try {
                event(new \App\Events\PaymentFailed($payment));
            } catch (Exception $e) {
                Log::error('Event dispatch failed', [
                    'payment_id' => $payment->payment_id,
                    'error' => $e->getMessage(),
                ]);
            }

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Payment failure marking failed', [
                'payment_id' => $payment->payment_id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function refundPayment(Payment $payment, ?float $amount = null, ?string $reason = null): array
    {
        DB::beginTransaction();

        try {
            $payment->load(['user', 'order']);
            $refundAmount = $amount ?? $payment->amount;

            if ($refundAmount > $payment->amount) {
                return [
                    'success' => false,
                    'message' => 'Refund amount cannot exceed payment amount',
                ];
            }

            $refundTransaction = Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'user_id' => $payment->user_id,
                'order_id' => $payment->order_id,
                'type' => TransactionType::REFUND->value,
                'status' => TransactionStatus::COMPLETED->value,
                'amount' => $refundAmount,
                'currency' => $payment->currency,
                'payment_gateway' => $payment->payment_gateway,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'net_amount' => $refundAmount,
                'notes' => $reason,
                'processed_at' => now(),
            ]);

            if ($payment->payment_gateway === 'wallet') {
                $this->refundToWallet($payment->user_id, $refundAmount, $refundTransaction);
            }

            $payment->update([
                'status' => PaymentStatus::REFUNDED->value,
                'notes' => $reason,
            ]);

            $payment->order->update([
                'status' => OrderStatus::REFUNDED->value,
            ]);

            DB::commit();

            Log::info('Payment refunded', [
                'payment_id' => $payment->payment_id,
                'refund_amount' => $refundAmount,
                'refund_transaction_id' => $refundTransaction->transaction_id,
            ]);

            return [
                'success' => true,
                'message' => 'Payment refunded successfully',
                'refund_transaction' => $refundTransaction,
                'refund_amount' => $refundAmount,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Refund failed', [
                'payment_id' => $payment->payment_id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
            ];
        }
    }

    protected function refundToWallet(int $userId, float $amount, Transaction $refundTransaction): void
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            Log::warning('Wallet not found for refund', ['user_id' => $userId]);
            return;
        }

        $balanceBefore = $wallet->balance;
        $balanceAfter = $balanceBefore + $amount;

        $wallet->update([
            'balance' => $balanceAfter,
            'total_deposits' => $wallet->total_deposits + $amount,
            'last_deposit_at' => now(),
        ]);

        \App\Models\WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'transaction_id' => $refundTransaction->id,
            'type' => \App\Enums\WalletTransactionType::REFUND->value,
            'calculation_type' => \App\Enums\CalculationType::CREDIT->value,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'currency_code' => $wallet->currency_code,
            'notes' => 'Refund for payment #' . $refundTransaction->source_id,
            'source_id' => $refundTransaction->id,
            'source_type' => Transaction::class,
        ]);

        Log::info('Refund credited to wallet', [
            'user_id' => $userId,
            'amount' => $amount,
            'new_balance' => $balanceAfter,
        ]);
    }

    protected function canProcessPayment(Order $order): bool
    {
        if (!in_array($order->status, [
            OrderStatus::INITIALIZED,
            OrderStatus::PENDING,
            OrderStatus::PARTIALLY_PAID
        ])) {
            Log::warning('Order cannot accept payment', [
                'order_id' => $order->order_id,
                'status' => $order->status->value,
            ]);
            return false;
        }

        if ($order->isFullyPaid()) {
            Log::warning('Order already fully paid', [
                'order_id' => $order->order_id,
            ]);
            return false;
        }

        return true;
    }

    protected function ensureTransactionExists(Payment $payment): Transaction
    {
        $existingTransaction = Transaction::where('source_id', $payment->id)
            ->where('source_type', Payment::class)
            ->first();

        if ($existingTransaction) {
            return $existingTransaction;
        }

        Log::warning('Creating missing transaction in service', [
            'payment_id' => $payment->payment_id,
        ]);

        return Transaction::create([
            'transaction_id' => generate_transaction_id_hybrid(),
            'user_id' => $payment->user_id,
            'order_id' => $payment->order_id,
            'type' => TransactionType::PAYMENT->value,
            'status' => TransactionStatus::PENDING->value,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'payment_gateway' => $payment->payment_gateway,
            'gateway_transaction_id' => $payment->transaction_id,
            'source_id' => $payment->id,
            'source_type' => Payment::class,
            'net_amount' => $payment->amount,
            'metadata' => [
                'payment_id' => $payment->payment_id,
                'created_by' => 'service_safety_net',
            ],
        ]);
    }

    protected function updateOrderStatus(Order $order): void
    {
        $order->refresh();
        $order->updateStatusBasedOnPayment();
    }

    protected function createPartialOrderContext(Order $order, float $amount): Order
    {
        $partialOrder = $order->replicate();
        $partialOrder->grand_total = $amount;
        $partialOrder->exists = true;
        $partialOrder->id = $order->id;
        $partialOrder->setRelation('user', $order->user);
        $partialOrder->setRelation('source', $order->source);

        return $partialOrder;
    }

    public function syncPaymentWithGateway(Payment $payment): bool
    {
        try {
            $payment->load(['order']);

            $gateway = \App\Models\PaymentGateway::where('slug', $payment->payment_gateway)->first();

            if (!$gateway) {
                return false;
            }

            $paymentMethod = $gateway->paymentMethod();

            if ($payment->payment_gateway === 'stripe' && $payment->payment_intent_id) {
                try {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                    try {
                        $session = \Stripe\Checkout\Session::retrieve($payment->payment_intent_id);
                        if ($session->payment_status === 'paid') {
                            return $this->completePayment($payment, [
                                'transaction_id' => $session->payment_intent,
                            ]);
                        }
                    } catch (\Exception $e) {
                        $intent = \Stripe\PaymentIntent::retrieve($payment->payment_intent_id);
                        if ($intent->status === 'succeeded') {
                            return $this->completePayment($payment, [
                                'transaction_id' => $intent->id,
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Stripe sync failed', [
                        'payment_id' => $payment->payment_id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return false;
        } catch (Exception $e) {
            Log::error('Payment sync failed', [
                'payment_id' => $payment->payment_id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function getWalletBalance(int $userId): array
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return [
                'balance' => 0,
                'currency_code' => 'USD',
                'formatted_balance' => '0.00 USD',
            ];
        }

        return [
            'balance' => $wallet->balance,
            'currency_code' => $wallet->currency_code,
            'formatted_balance' => number_format($wallet->balance, 2) . ' ' . $wallet->currency_code,
            'locked_balance' => $wallet->locked_balance,
            'pending_balance' => $wallet->pending_balance,
        ];
    }
}
