<?php

namespace App\Http\Payment\Methods;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletTransactionType;
use App\Enums\CalculationType;
use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class WalletMethod extends PaymentMethod
{
    protected $id = 'wallet';
    protected $name = 'Wallet';
    protected $requiresFrontendJs = false;

    public function __construct($gateway = null)
    {
        parent::__construct($gateway);
    }

    /**
     * Start payment - Process wallet payment immediately
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
            // Get or create user wallet
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

            // Check if user has sufficient balance
            if ($wallet->balance < $order->grand_total) {
                return [
                    'success' => false,
                    'message' => 'Insufficient wallet balance. Your balance: ' . number_format($wallet->balance, 2) . ' ' . $wallet->currency_code,
                    'current_balance' => $wallet->balance,
                    'required_amount' => $order->grand_total,
                ];
            }

            $order->load('user');

            DB::beginTransaction();

            try {
                // 1. Create payment record (PENDING initially)
                $payment = Payment::create([
                    'payment_id' => generate_payment_id(),
                    'user_id' => $order->user_id,
                    'name' => $order->user->name ?? null,
                    'email_address' => $order->user->email ?? null,
                    'payment_gateway' => $this->id,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'status' => PaymentStatus::PENDING->value,
                    'order_id' => $order->id,
                    'creater_id' => $order->user_id,
                    'creater_type' => get_class($order->user),
                ]);

                // 2. Create main transaction record
                $paymentTransaction = Transaction::create([
                    'transaction_id' => generate_transaction_id_hybrid(),
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'type' => TransactionType::PAYMENT->value,
                    'status' => TransactionStatus::PENDING->value,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'payment_gateway' => $this->id,
                    'source_id' => $payment->id,
                    'source_type' => Payment::class,
                    'net_amount' => $order->grand_total,
                    'metadata' => [
                        'payment_id' => $payment->payment_id,
                        'wallet_payment' => true,
                    ],
                ]);

                // 3. Calculate new balance
                $balanceBefore = $wallet->balance;
                $balanceAfter = $balanceBefore - $order->grand_total;

                // 4. Create wallet transaction
                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'transaction_id' => $paymentTransaction->id,
                    'type' => WalletTransactionType::PAYMENT->value,
                    'calculation_type' => CalculationType::CREDIT->value,
                    'amount' => $order->grand_total,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'currency_code' => $wallet->currency_code,
                    'notes' => 'Payment for Order #' . $order->order_id,
                    'source_id' => $order->id,
                    'source_type' => Order::class,
                ]);

                // Wallet Transaction to payout the order amount form wallet same as wallet debit transaction

                // 5. Update wallet balance
                $wallet->update([
                    'balance' => $balanceAfter,
                    'total_withdrawals' => $wallet->total_withdrawals + $order->grand_total,
                    'last_withdrawal_at' => now(),
                ]);

                // 6. Mark transaction as completed
                $paymentTransaction->update([
                    'status' => TransactionStatus::COMPLETED->value,
                    'gateway_transaction_id' => $paymentTransaction->transaction_id,
                    'processed_at' => now(),
                ]);

                // 7. Mark payment as completed (this triggers PaymentObserver)
                $payment->update([
                    'status' => PaymentStatus::COMPLETED->value,
                    'transaction_id' => $paymentTransaction->transaction_id,
                    'paid_at' => now(),
                    'metadata' => [
                        'wallet_transaction_id' => $paymentTransaction->id,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                    ],
                ]);

                // 8. Update order status (handled by PaymentObserver, but we do it here for immediate response)
                $order->update([
                    'status' => OrderStatus::PAID->value,
                    'payment_method' => $this->name,
                    'completed_at' => now(),
                ]);

                DB::commit();

                Log::info('Wallet payment processed successfully', [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'transaction_id' => $paymentTransaction->transaction_id,
                    'amount' => $order->grand_total,
                    'balance_after' => $balanceAfter,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment successful! Amount deducted from your wallet.',
                    'payment_id' => $payment->payment_id,
                    'transaction_id' => $paymentTransaction->transaction_id,
                    'order_id' => $order->order_id,
                    'amount_paid' => $order->grand_total,
                    'new_balance' => $balanceAfter,
                    'redirect_url' => route('user.payment.success', ['order_id' => $order->order_id]),
                ];
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
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
     * Confirm payment - Not needed for wallet (payment is instant)
     */
    public function confirmPayment(string $transactionId, ?string $paymentMethodId = null): array
    {
        return [
            'success' => true,
            'message' => 'Wallet payment is processed immediately.',
        ];
    }

    /**
     * Get user wallet balance
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
}
