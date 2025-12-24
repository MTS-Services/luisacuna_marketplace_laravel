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

class WalletMethod extends PaymentMethod
{
    protected $id = 'wallet';
    protected $name = 'Wallet';
    protected $requiresFrontendJs = false;

    public function __construct($gateway = null, ConversationService $conversationService)
    {
        parent::__construct($gateway, $conversationService);
    }

    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
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
                $balanceBefore = $wallet->balance;
                $balanceAfter = $balanceBefore - $order->grand_total;

                // 1. Create payment record
                $payment = Payment::create([
                    'payment_id' => generate_payment_id(),
                    'user_id' => $order->user_id,
                    'name' => $order->user->name ?? null,
                    'email_address' => $order->user->email ?? null,
                    'payment_gateway' => $this->id,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'status' => PaymentStatus::COMPLETED->value, // Direct COMPLETED status
                    'order_id' => $order->id,
                    'paid_at' => now(), // Set immediately
                    'transaction_id' => null, // Will be set below
                    'metadata' => [
                        'wallet_payment' => true,
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                    ],
                    'creater_id' => $order->user_id,
                    'creater_type' => get_class($order->user),
                ]);

                // 2. Create main transaction record
                $paymentTransaction = Transaction::create([
                    'transaction_id' => generate_transaction_id_hybrid(),
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'type' => TransactionType::PAYMENT->value,
                    'status' => TransactionStatus::PAID->value, // Direct PAID status
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'payment_gateway' => $this->id,
                    'gateway_transaction_id' => null,
                    'source_id' => $payment->id,
                    'source_type' => Payment::class,
                    'net_amount' => $order->grand_total,
                    'processed_at' => now(),
                    'metadata' => [
                        'payment_id' => $payment->payment_id,
                        'wallet_payment' => true,
                    ],
                ]);

                // Update payment with transaction_id
                $payment->update([
                    'transaction_id' => $paymentTransaction->transaction_id,
                ]);

                // Update transaction with self-referencing ID
                $paymentTransaction->update([
                    'gateway_transaction_id' => $paymentTransaction->transaction_id,
                ]);

                // 3. Create wallet credit transaction
                Transaction::create([
                    'transaction_id' => generate_transaction_id_hybrid(),
                    'user_id' => $wallet->user_id,
                    'type' => TransactionType::WALLET->value,
                    'status' => TransactionStatus::PAID->value,
                    'calculation_type' => CalculationType::CREDIT->value,
                    'amount' => $order->grand_total,
                    'currency' => $wallet->currency_code,
                    'payment_gateway' => $this->id,
                    'source_id' => $wallet->id,
                    'source_type' => Wallet::class,
                    'fee_amount' => 0,
                    'net_amount' => $order->grand_total,
                    'metadata' => [
                        'transaction_type' => TransactionType::WALLET->value,
                        'wallet_owner_id' => $wallet->user_id,
                    ],
                    'notes' => 'Wallet credit of ' . number_format($order->grand_total, 2) . ' ' . $wallet->currency_code . ' for Order #' . $order->order_id,
                ]);

                // 4. Update wallet balance
                $wallet->update([
                    'balance' => $balanceAfter,
                    'total_withdrawals' => $wallet->total_withdrawals + $order->grand_total,
                    'last_withdrawal_at' => now(),
                ]);

                // 5. Update order status
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

                $this->dispatchPaymentNotificationsOnce($payment);
                $this->sendOrderMessage($order);

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

    public function confirmPayment(string $transactionId, ?string $paymentMethodId = null): array
    {
        return [
            'success' => true,
            'message' => 'Wallet payment is processed immediately.',
        ];
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

    public function hasSufficientBalance(int $userId, float $amount): bool
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return false;
        }

        return $wallet->balance >= $amount;
    }
}
