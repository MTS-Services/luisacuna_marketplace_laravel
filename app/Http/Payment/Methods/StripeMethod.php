<?php

namespace App\Http\Payment\Methods;

use App\Enums\CalculationType;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;
use Exception;
use Illuminate\Support\Str;

class StripeMethod extends PaymentMethod
{
    protected $id = 'stripe';
    protected $name = 'Stripe';
    protected $requiresFrontendJs = false;

    public function __construct($gateway = null, ConversationService $conversationService)
    {
        parent::__construct($gateway, $conversationService);
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Start payment - Create Stripe Checkout Session
     * This initiates the "top-up" process via Stripe
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
            // Eager load to prevent N+1
            $order->load(['user', 'source.user']);

            return DB::transaction(function () use ($order) {
                $order->load('user');

                // Create payment record
                $payment = Payment::firstOrCreate(
                    ['order_id' => $order->id, 'status' => PaymentStatus::PENDING->value],
                    [
                        'payment_id' => generate_payment_id(),
                        'user_id' => $order->user_id,
                        'name' => $order?->user?->full_name ?? null,
                        'email_address' => $order->user->email ?? null,
                        'payment_gateway' => $this->id,
                        'amount' => $order->grand_total,
                        'currency' => strtoupper($order->currency ?? 'USD'),
                        'creater_id' => $order->user_id,
                        'creater_type' => get_class($order->user),
                    ]
                );

                // Create Stripe Checkout Session
                $session = StripeSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => strtolower($payment->currency),
                                'product_data' => [
                                    'name' => $order->source?->name ?? 'Order #' . $order->order_id,
                                    'description' => 'Order ID: ' . $order->order_id,
                                ],
                                'unit_amount' => $this->convertToStripeAmount($order->grand_total, $payment->currency),
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'payment',
                    'success_url' => route('user.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->order_id,
                    'cancel_url' => route('user.payment.failed') . '?order_id=' . $order->order_id,
                    'metadata' => [
                        'order_id' => $order->order_id,
                        'order_db_id' => $order->id,
                        'payment_id' => $payment->payment_id,
                        'payment_db_id' => $payment->id,
                        'user_id' => $order->user_id,
                    ],
                    'customer_email' => $order->user->email ?? null,
                ]);

                $payment->update([
                    'payment_intent_id' => $session->id,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'stripe_session_id' => $session->id,
                        'checkout_url' => $session->url,
                    ]),
                ]);

                Log::info('Stripe Checkout Session created', [
                    'order_id' => $order->order_id,
                    'session_id' => $session->id,
                    'payment_id' => $payment->payment_id,
                ]);

                return [
                    'success' => true,
                    'checkout_url' => $session->url,
                    'session_id' => $session->id,
                    'payment_id' => $payment->payment_id,
                    'message' => 'Redirecting to Stripe Checkout...',
                ];
            });
        } catch (Exception $e) {
            Log::error('Stripe payment initialization failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ['success' => false, 'message' => 'Failed to initialize Stripe payment: ' . $e->getMessage()];
        }
    }

    /**
     * Confirm payment after Stripe success
     * This implements the "Bridge Pattern": Deposit → Payment
     */
    public function confirmPayment(string $sessionId, ?string $paymentMethodId = null): array
    {
        try {
            $session = StripeSession::retrieve($sessionId);

            if (!$session) {
                throw new Exception('Stripe session not found');
            }

            $payment = Payment::with(['order.user.wallet', 'order.source.user.wallet', 'user'])
                ->where('payment_intent_id', $sessionId)
                ->first();

            if (!$payment) {
                throw new Exception('Payment record not found.');
            }

            // If already processed (by Webhook), return success early
            if ($payment->status === PaymentStatus::COMPLETED->value) {
                return ['success' => true, 'message' => 'Payment already processed.'];
            }

            $order = $payment->order;

            // Get or create buyer's wallet
            $buyerWallet = $payment->order?->user?->wallet ?? Wallet::firstOrCreate(
                ['user_id' => $payment->user_id],
                [
                    'currency_code' => $payment->currency,
                    'balance' => 0,
                    'locked_balance' => 0,
                    'pending_balance' => 0,
                    'total_deposits' => 0,
                    'total_withdrawals' => 0,
                ]
            );

            if ($session->payment_status === 'paid') {
                return DB::transaction(function () use ($order, $payment, $session, $sessionId, $buyerWallet) {
                    // Lock records to prevent race conditions
                    $payment->lockForUpdate();
                    $order->lockForUpdate();
                    $buyerWallet->lockForUpdate();

                    $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
                    $correlationId = Str::uuid();
                    $balanceBeforeDeposit = $buyerWallet->balance;
                    $balanceAfterDeposit = $balanceBeforeDeposit + $payment->amount;
                    $balanceAfterPayment = $balanceAfterDeposit - $order->grand_total;

                    // ===================================================
                    // TRANSACTION 1: DEPOSIT (Top-up via Stripe)
                    // Type: TOPUP, Calculation: DEBIT (money IN)
                    // ===================================================
                    $depositTransaction = Transaction::create([
                        'transaction_id' => generate_transaction_id_hybrid(),
                        'correlation_id' => $correlationId,
                        'user_id' => $payment->user_id,
                        'order_id' => $order->id,
                        'type' => TransactionType::TOPUP->value,
                        'status' => TransactionStatus::PAID->value,
                        'calculation_type' => CalculationType::DEBIT->value,
                        'amount' => $payment->amount,
                        'currency' => $payment->currency,
                        'payment_gateway' => $this->id,
                        'gateway_transaction_id' => $session->payment_intent,
                        'source_id' => $payment->id,
                        'source_type' => Payment::class,
                        'fee_amount' => 0,
                        'net_amount' => $payment->amount,
                        'balance_snapshot' => $balanceAfterDeposit,
                        'metadata' => [
                            'stripe_session_id' => $sessionId,
                            'payment_intent_id' => $session->payment_intent,
                            'receipt_url' => $paymentIntent->charges->data[0]->receipt_url ?? null,
                            'description' => "Top-up via Stripe for Order #{$order->order_id}",
                        ],
                        'notes' => "Deposit: +{$payment->amount} {$payment->currency} via Stripe",
                        'processed_at' => now(),
                    ]);

                    // Update wallet balance after deposit
                    $buyerWallet->update([
                        'balance' => $balanceAfterDeposit,
                        'total_deposits' => $buyerWallet->total_deposits + $payment->amount,
                        'last_deposit_at' => now(),
                    ]);

                    // ===================================================
                    // TRANSACTION 2: PAYMENT (Purchase from wallet)
                    // Type: PURCHASED, Calculation: CREDIT (money OUT)
                    // ===================================================
                    $paymentTransaction = Transaction::create([
                        'transaction_id' => generate_transaction_id_hybrid(),
                        'correlation_id' => $correlationId,
                        'user_id' => $payment->user_id,
                        'order_id' => $order->id,
                        'type' => TransactionType::PURCHSED->value,
                        'status' => TransactionStatus::PAID->value,
                        'calculation_type' => CalculationType::CREDIT->value,
                        'amount' => $order->grand_total,
                        'currency' => $order->currency,
                        'payment_gateway' => 'wallet', // Payment is from wallet
                        'gateway_transaction_id' => $depositTransaction->transaction_id,
                        'source_id' => $payment->id,
                        'source_type' => Payment::class,
                        'fee_amount' => 0,
                        'net_amount' => $order->grand_total,
                        'balance_snapshot' => $balanceAfterPayment,
                        'metadata' => [
                            'stripe_session_id' => $sessionId,
                            'payment_intent_id' => $session->payment_intent,
                            'description' => "Payment for Order #{$order->order_id}",
                        ],
                        'notes' => "Payment: -{$order->grand_total} {$order->currency} for Order #{$order->order_id}",
                        'processed_at' => now(),
                    ]);

                    // Update wallet balance after payment
                    $buyerWallet->update([
                        'balance' => $balanceAfterPayment,
                        'total_withdrawals' => $buyerWallet->total_withdrawals + $order->grand_total,
                        'last_withdrawal_at' => now(),
                    ]);

                    // Update payment record
                    $payment->update([
                        'status' => PaymentStatus::COMPLETED->value,
                        'transaction_id' => $session->payment_intent,
                        'payment_method_id' => $paymentIntent->payment_method ?? null,
                        'card_brand' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
                        'card_last4' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
                        'paid_at' => now(),
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'payment_intent_id' => $session->payment_intent,
                            'stripe_receipt_url' => $paymentIntent->charges->data[0]->receipt_url ?? null,
                            'deposit_transaction_id' => $depositTransaction->id,
                            'payment_transaction_id' => $paymentTransaction->id,
                            'correlation_id' => $correlationId,
                        ]),
                    ]);

                    // Update order status
                    $order->update([
                        'status' => OrderStatus::PAID->value,
                        'payment_method' => 'Wallet (via Stripe)',
                        'completed_at' => now(),
                    ]);

                    Log::info('Stripe payment confirmed successfully (Bridge Pattern)', [
                        'order_id' => $order->order_id,
                        'payment_id' => $payment->payment_id,
                        'correlation_id' => $correlationId,
                        'deposit_transaction_id' => $depositTransaction->transaction_id,
                        'payment_transaction_id' => $paymentTransaction->transaction_id,
                        'balance_after' => $balanceAfterPayment,
                    ]);

                    $this->dispatchPaymentNotificationsOnce($payment);
                    $this->sendOrderMessage($order);

                    return [
                        'success' => true,
                        'message' => 'Payment completed successfully',
                        'correlation_id' => $correlationId,
                        'deposit_transaction_id' => $depositTransaction->transaction_id,
                        'payment_transaction_id' => $paymentTransaction->transaction_id,
                    ];
                });
            }

            return [
                'success' => false,
                'message' => 'Payment not completed. Status: ' . $session->payment_status,
            ];
        } catch (Exception $e) {
            Log::error('Payment confirmation failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment confirmation failed: ' . $e->getMessage(),
            ];
        }
    }

    protected function convertToStripeAmount(float $amount, string $currency): int
    {
        $zeroDecimalCurrencies = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return (int) round($amount);
        }

        return (int) round($amount * 100);
    }

    public function handleWebhook(array $payload): void
    {
        $eventType = $payload['type'] ?? null;

        Log::info('Processing Stripe webhook', ['event_type' => $eventType]);

        switch ($eventType) {
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($payload['data']['object']);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentSuccess($payload['data']['object']);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($payload['data']['object']);
                break;

            case 'payment_intent.canceled':
                $this->handlePaymentCanceled($payload['data']['object']);
                break;

            default:
                Log::info('Unhandled Stripe webhook event', ['event_type' => $eventType]);
        }
    }

    protected function handleCheckoutCompleted(array $session): void
    {
        try {
            $orderId = $session['metadata']['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('No order_id in session metadata', ['session_id' => $session['id']]);
                return;
            }

            $order = Order::with(['latestPayment'])->where('order_id', $orderId)->first();

            if (!$order) {
                Log::warning('Order not found for webhook', ['order_id' => $orderId]);
                return;
            }

            $payment = $order->latestPayment;

            // Prevent duplicate processing
            if ($payment && $payment->status === PaymentStatus::COMPLETED->value) {
                Log::info('Payment already processed, skipping webhook', [
                    'order_id' => $orderId,
                    'payment_id' => $payment->payment_id,
                ]);
                return;
            }

            if ($payment && $session['payment_status'] === 'paid') {
                // Call confirmPayment to execute the bridge pattern
                $this->confirmPayment($session['id']);
            }
        } catch (Exception $e) {
            Log::error('Error processing checkout completed webhook', [
                'error' => $e->getMessage(),
                'session' => $session,
            ]);
        }
    }

    protected function handlePaymentSuccess(array $paymentIntent): void
    {
        try {
            $payment = Payment::with(['order'])->where('transaction_id', $paymentIntent['id'])->first();

            if ($payment && $payment->status !== PaymentStatus::COMPLETED->value) {
                Log::info('Payment success webhook - triggering confirmation', [
                    'payment_id' => $payment->payment_id,
                    'payment_intent_id' => $paymentIntent['id'],
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error processing payment success webhook', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function handlePaymentFailed(array $paymentIntent): void
    {
        try {
            $payment = Payment::with(['order'])->where('payment_intent_id', $paymentIntent['id'])->first();

            if ($payment) {
                DB::transaction(function () use ($payment, $paymentIntent) {
                    $payment->update([
                        'status' => PaymentStatus::FAILED->value,
                        'notes' => $paymentIntent['last_payment_error']['message'] ?? 'Payment failed',
                    ]);

                    $payment->order->update([
                        'status' => OrderStatus::FAILED->value,
                    ]);
                });

                Log::info('Payment failed webhook processed', [
                    'payment_id' => $payment->payment_id,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error processing payment failed webhook', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function handlePaymentCanceled(array $paymentIntent): void
    {
        try {
            $payment = Payment::with(['order'])->where('payment_intent_id', $paymentIntent['id'])->first();

            if ($payment) {
                DB::transaction(function () use ($payment) {
                    $payment->update([
                        'status' => PaymentStatus::CANCELLED->value,
                    ]);

                    $payment->order->update([
                        'status' => OrderStatus::CANCELLED->value,
                    ]);
                });

                Log::info('Payment canceled webhook processed', [
                    'payment_id' => $payment->payment_id,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error processing payment canceled webhook', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
