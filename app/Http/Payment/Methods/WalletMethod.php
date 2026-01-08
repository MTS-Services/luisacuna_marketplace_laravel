<?php

namespace App\Http\Payment\Methods;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\CalculationType;
use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\ConversationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class WalletMethod extends PaymentMethod
{
    protected $id = 'wallet';
    protected $name = 'Wallet';
    protected $requiresFrontendJs = false;

    public function __construct($gateway = null, ConversationService $conversationService)
    {
        parent::__construct($gateway, $conversationService);
    }

    /**
     * Start payment - Direct wallet payment (Scenario 1)
     * This is a single CREDIT transaction (money OUT)
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
            // Get or create wallet
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $order->user_id],
                [
                    'currency_code' => $order->currency ?? 'USD',
                    'balance' => 0,
                    'locked_balance' => 0,
                    'pending_balance' => 0,
                    'total_deposits' => 0,
                    'total_withdrawals' => 0,
                ]
            );

            // Validate sufficient balance
            if ($wallet->balance < $order->grand_total) {
                return [
                    'success' => false,
                    'message' => 'Insufficient wallet balance. Your balance: ' . number_format($wallet->balance, 2) . ' ' . $wallet->currency_code,
                    'current_balance' => $wallet->balance,
                    'required_amount' => $order->grand_total,
                ];
            }

            $order->load('user');

            return DB::transaction(function () use ($order, $wallet) {
                // Lock wallet to prevent race conditions
                $wallet->lockForUpdate();

                $balanceBefore = $wallet->balance;
                $balanceAfter = $balanceBefore - $order->grand_total;
                $correlationId = Str::uuid();

                // ===================================================
                // SINGLE TRANSACTION: PAYMENT (Direct from wallet)
                // Type: PURCHASED, Calculation: CREDIT (money OUT)
                // ===================================================

                // 1. Create payment record
                $payment = Payment::create([
                    'payment_id' => generate_payment_id(),
                    'user_id' => $order->user_id,
                    'name' => $order->user->full_name ?? null,
                    'email_address' => $order->user->email ?? null,
                    'payment_gateway' => $this->id,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'status' => PaymentStatus::COMPLETED->value,
                    'order_id' => $order->id,
                    'paid_at' => now(),
                    'transaction_id' => null, // Will be set below
                    'metadata' => [
                        'wallet_payment' => true,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                        'correlation_id' => $correlationId,
                    ],
                    'creater_id' => $order->user_id,
                    'creater_type' => get_class($order->user),
                ]);

                // 2. Create transaction record (CREDIT - money OUT)
                $paymentTransaction = Transaction::create([
                    'transaction_id' => generate_transaction_id_hybrid(),
                    'correlation_id' => $correlationId,
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'type' => TransactionType::PURCHSED->value,
                    'status' => TransactionStatus::PAID->value,
                    'calculation_type' => CalculationType::CREDIT->value,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'payment_gateway' => $this->id,
                    'gateway_transaction_id' => null, // Will be self-referencing
                    'source_id' => $payment->id,
                    'source_type' => Payment::class,
                    'fee_amount' => 0,
                    'net_amount' => $order->grand_total,
                    'balance_snapshot' => $balanceAfter,
                    'metadata' => [
                        'payment_id' => $payment->payment_id,
                        'wallet_payment' => true,
                        'description' => "Payment for Order #{$order->order_id}",
                    ],
                    'notes' => "Payment: -{$order->grand_total} {$wallet->currency_code} for Order #{$order->order_id}",
                    'processed_at' => now(),
                ]);

                // Update payment with transaction_id
                $payment->update([
                    'transaction_id' => $paymentTransaction->transaction_id,
                ]);

                // Update transaction with self-referencing gateway_transaction_id
                $paymentTransaction->update([
                    'gateway_transaction_id' => $paymentTransaction->transaction_id,
                ]);

                // 3. Update wallet balance
                $wallet->update([
                    'balance' => $balanceAfter,
                    'total_withdrawals' => $wallet->total_withdrawals + $order->grand_total,
                    'last_withdrawal_at' => now(),
                ]);

                // 4. Update order status
                $order->update([
                    'status' => OrderStatus::PAID->value,
                    'payment_method' => $this->name,
                    'completed_at' => now(),
                ]);

                Log::info('Direct wallet payment processed successfully', [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'transaction_id' => $paymentTransaction->transaction_id,
                    'correlation_id' => $correlationId,
                    'amount' => $order->grand_total,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                ]);

                $this->dispatchPaymentNotificationsOnce($payment);
                $this->sendOrderMessage($order);

                return [
                    'success' => true,
                    'message' => 'Payment successful! Amount deducted from your wallet.',
                    'payment_id' => $payment->payment_id,
                    'transaction_id' => $paymentTransaction->transaction_id,
                    'correlation_id' => $correlationId,
                    'order_id' => $order->order_id,
                    'amount_paid' => $order->grand_total,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'redirect_url' => route('user.payment.success', ['order_id' => $order->order_id]),
                ];
            });
        } catch (Exception $e) {
            Log::error('Wallet payment failed', [
                'order_id' => $order->order_id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Wallet payment failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm payment - Not needed for direct wallet payments
     */
    public function confirmPayment(string $transactionId, ?string $paymentMethodId = null): array
    {
        return [
            'success' => true,
            'message' => 'Wallet payment is processed immediately.',
        ];
    }

    /**
     * Get wallet balance for a user
     */
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
            'total_deposits' => $wallet->total_deposits,
            'total_withdrawals' => $wallet->total_withdrawals,
        ];
    }

    /**
     * Check if user has sufficient balance
     */
    public function hasSufficientBalance(int $userId, float $amount): bool
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return false;
        }

        return $wallet->balance >= $amount;
    }

    /**
     * Get available balance (excluding locked amounts)
     */
    public function getAvailableBalance(int $userId): float
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return 0;
        }

        return $wallet->balance - $wallet->locked_balance;
    }
}
