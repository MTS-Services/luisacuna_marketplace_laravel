<?php

namespace App\Http\Payment\Methods;


use App\Models\Order;
use App\Models\Wallet;
use App\Models\Payment;
use App\Enums\OrderStatus;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus;
use App\Enums\CalculationType;
use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\DB;
use App\Http\Payment\PaymentMethod;
use Illuminate\Support\Facades\Log;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Http;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Session; 

class CryptoMethod extends PaymentMethod
{
    /**
     * The payment method id name.
     */
    protected $id = 'crypto';

    /**
     * The payment method display name.
     */
    protected $name = 'Crypto';

    /**
     * Indicates if this gateway requires frontend JS
     */
    protected $requiresFrontendJs = false;

    /**
     * The frontend JS SDK URL
     */

    protected $currencyService;


    public  $NOW_PUBLIC_API_KEY;
    public  $NOW_PRIVATE_API_KEY;


    protected string $baseUrl;
    protected string $apiKey;

    public function __construct($gateway = null, ConversationService $conversationService, AchievementService $achievementService)
    {
        parent::__construct($gateway, $conversationService, $achievementService);
        $this->currencyService = app(CurrencyService::class);
        $this->NOW_PUBLIC_API_KEY = config('services.crypto.public_api_key');
        $this->NOW_PRIVATE_API_KEY = config('services.crypto.private_api_key');


        // Set base URL based on environment
        $this->baseUrl = config('services.crypto.env') === 'live'
            ? 'https://api.nowpayments.io/v1'
            : 'https://api-sandbox.nowpayments.io/v1';
    }





    protected function headers(): array
    {
        return [
            'x-api-key' => $this->NOW_PRIVATE_API_KEY,
            'Accept' => 'application/json',
        ];
    }
    /**
     * Start payment - Create Payment Intent for frontend
     * This method DOES NOT handle card details directly
     */

public function startPayment(Order $order, array $paymentData = []): array
{
    try {
        $order->load(['user', 'source.user']);

        return DB::transaction(function () use ($order, $paymentData) {
            // Check if this is a top-up payment
            $isTopUp = $paymentData['is_topup'] ?? false;
            $topUpAmount = $paymentData['top_up_amount'] ?? null;

            // Get display currency from payment data or use current
            $displayCurrency = $paymentData['display_currency'] ?? $order->currency ?? currency_code();
            $exchangeRate = $paymentData['exchange_rate'] ?? 1;

            // Determine the payment amount IN DISPLAY CURRENCY
            $paymentAmount = $isTopUp ? $topUpAmount : $order->grand_total;

            // Convert to default currency for internal storage
            $paymentAmountDefault = $this->currencyService->convertToDefault(
                $paymentAmount,
                $displayCurrency
            );

            // Create payment record
            $payment = Payment::create([
                'payment_id' => generate_payment_id(),
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'name' => $order->user->full_name ?? null,
                'email_address' => $order->user->email ?? null,
                'payment_gateway' => $this->id,
                'amount' => $paymentAmountDefault, // Store in default currency
                'currency' => $this->currencyService->getDefaultCurrency()->code,
                'status' => PaymentStatus::PENDING->value,
                'creater_id' => $order->user_id,
                'creater_type' => get_class($order->user),
                'metadata' => [
                    'is_topup' => $isTopUp,
                    'top_up_amount' => $topUpAmount,
                    'display_currency' => $displayCurrency,
                    'display_amount' => $paymentAmount,
                    'exchange_rate' => $exchangeRate,
                ],
            ]);

            // Determine description and product name
            if ($isTopUp) {
                $description = "Wallet Top-up for Order #{$order->order_id}";
                $productName = 'Wallet Top-Up';
            } else {
                $description = 'Order ID: ' . $order->order_id;
                $productName = $order->source?->name ?? 'Order #' . $order->order_id;
            }

            // Determine amount (topup or regular payment)
            $priceAmount = $isTopUp ? $topUpAmount : $order->grand_total;

            Log::info('Starting crypto payment', [
                'order_id' => $order->order_id,
                'amount' => $priceAmount,
                'currency' => $displayCurrency,
                'is_topup' => $isTopUp,
            ]);

            /**
             * Create Invoice directly via NOWPayments API
             */
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/invoice", [
                    'price_amount' => (float) $priceAmount,
                    'price_currency' => strtolower($displayCurrency),
                    'order_id' => $order->order_id,
                    'order_description' => $description,
                    'ipn_callback_url' => url('/nowpayments/ipn'),
                    'success_url' => route('user.payment.success') . '?invoice_id={INVOICE_ID}&order_id=' . $order->order_id,
                    'cancel_url' => route('user.payment.failed') . '?invoice_id={INVOICE_ID}&order_id=' . $order->order_id,
                ]);

            if ($response->failed()) {
                Log::error('NOWPayments Invoice creation failed', [
                    'order_id' => $order->order_id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to create payment invoice. Please try again.',
                ];
            }

            $invoice = $response->json();

            Log::info('NOWPayments Invoice created successfully', [
                'order_id' => $order->order_id,
                'invoice_id' => $invoice['id'] ?? null,
                'invoice_url' => $invoice['invoice_url'] ?? null,
            ]);

            // Replace placeholder with actual invoice ID
            $successUrlReal = str_replace('{INVOICE_ID}', $invoice['id'], route('user.payment.success') . '?invoice_id={INVOICE_ID}&order_id=' . $order->order_id);
            $cancelUrlReal = str_replace('{INVOICE_ID}', $invoice['id'], route('user.payment.failed') . '?invoice_id={INVOICE_ID}&order_id=' . $order->order_id);

            // Optionally, update the payment record with invoice ID
            $payment->update([
                'payment_intent_id' => $invoice['id'] ?? null,
                'metadata' => array_merge($payment->metadata ?? [], [
                    'checkout_url' => $invoice['invoice_url'] ?? null,
                ]),
            ]);

            // Return success response with checkout URL
            return [
                'success' => true,
                'message' => 'Redirecting to payment gateway...',
                'checkout_url' => $invoice['invoice_url'] ?? null,
                'invoice_id' => $invoice['id'] ?? null,
                'success_url' => $successUrlReal,
                'cancel_url' => $cancelUrlReal,
            ];
        });
    } catch (\Exception $e) {
        Log::error('Crypto payment error', [
            'order_id' => $order->order_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return [
            'success' => false,
            'message' => 'Payment processing failed. Please try again.',
        ];
    }
}

    /**
     * Get available currencies
     */
    public function getAvailableCurrencies(): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/currencies");

            if ($response->failed()) {
                Log::error('Failed to fetch currencies', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return [];
            }

            $data = $response->json();
            return is_array($data) ? $data : [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch currencies: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get minimum amount for currency pair
     */
    public function getMinimumAmount(string $currencyFrom, string $currencyTo): float
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/min-amount", [
                    'currency_from' => strtolower($currencyFrom),
                    'currency_to' => strtolower($currencyTo),
                ]);

            if ($response->failed()) {
                Log::error('Failed to get minimum amount', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return 0;
            }

            $data = $response->json();
            return (float) ($data['min_amount'] ?? 0);
        } catch (\Exception $e) {
            Log::error('Failed to get minimum amount: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get estimated price
     */
    public function getEstimatedPrice(float $amount, string $currencyFrom, string $currencyTo): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/estimate", [
                    'amount' => $amount,
                    'currency_from' => strtolower($currencyFrom),
                    'currency_to' => strtolower($currencyTo),
                ]);

            if ($response->failed()) {
                Log::error('Failed to get estimate', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return [];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to get estimate: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/payment/{$paymentId}");

            if ($response->failed()) {
                throw new \Exception('Failed to get payment status');
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Failed to get payment status: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Confirm payment after frontend processing
     * 
     * @param string $transactionId The payment intent ID
     * @param string|null $paymentMethodId The payment method ID
     * @return array
     */
    public function confirmPayment(string $invoiceId, ?string $paymentMethodId = null): array
    {
        try {
            Log::info('NOWPayments confirmPayment called', [
                'invoice_id' => $invoiceId,
            ]);

            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/invoice/{$invoiceId}");

            if ($response->failed()) {
                throw new \Exception('Unable to fetch invoice status from NOWPayments');
            }

            $invoice = $response->json();
            $paymentStatus = $invoice['payment_status'] ?? null;

            $payment = Payment::with(['order.user.wallet', 'order.source.user.wallet'])
                ->where('payment_intent_id', $invoiceId)
                ->first();

            if (!$payment) {
                throw new \Exception('Payment record not found');
            }

            if ($payment->status === PaymentStatus::COMPLETED->value) {
                return [
                    'success' => true,
                    'message' => 'Payment already processed',
                ];
            }

            $order = $payment->order;

            switch ($paymentStatus) {
                case 'confirmed':
                case 'finished':
                    $payment->update([
                        'status' => PaymentStatus::COMPLETED->value,
                        'paid_at' => now(),
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'nowpayments_status' => $paymentStatus,
                            'paid_amount' => $invoice['price_amount'] ?? null,
                            'pay_currency' => $invoice['price_currency'] ?? null,
                            'invoice_id' => $invoiceId,
                        ]),
                    ]);

                    if ($payment->metadata['is_topup'] ?? false) {
                        return $this->processTopUpPayment($invoice, $payment, $order);
                    } else {
                        return $this->processRegularPayment($invoice, $payment, $order);
                    }

                case 'waiting':
                case 'pending':
                    return [
                        'success' => false,
                        'message' => 'Payment is still pending',
                    ];

                case 'failed':
                case 'expired':
                    $payment->update([
                        'status' => PaymentStatus::FAILED->value,
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Payment failed or expired',
                    ];

                default:
                    return [
                        'success' => false,
                        'message' => 'Unknown payment status: ' . $paymentStatus,
                    ];
            }
        } catch (\Exception $e) {
            Log::error('NOWPayments confirmPayment failed', [
                'invoice_id' => $invoiceId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    protected function processTopUpPayment($invoice, Payment $payment, Order $order): array
    {
        return DB::transaction(function () use ($invoice, $payment, $order) {
            $payment->lockForUpdate();
            $order->lockForUpdate();

            // 🔒 Safety check
            if ($payment->status === PaymentStatus::COMPLETED->value) {
                return [
                    'success' => true,
                    'message' => 'Top-up already processed',
                ];
            }

            $topUpData = Session::get("topup_order_{$order->order_id}");

            if (!$topUpData) {
                throw new \Exception('Top-up session data not found');
            }

            // Amounts from session are in DISPLAY currency
            $topUpAmountDisplay = $topUpData['top_up_amount'];
            $orderTotalDisplay = $topUpData['order_total'];

            // Get display currency from metadata
            $displayCurrency = $payment->metadata['display_currency'] ?? $order->display_currency;

            // Convert amounts to DEFAULT currency for wallet operations
            $topUpAmountDefault = $this->currencyService->convertToDefault($topUpAmountDisplay, $displayCurrency);
            $orderTotalDefault = $order->default_grand_total ?? $this->currencyService->convertToDefault($orderTotalDisplay, $displayCurrency);

            // Get wallet (always in default currency)
            $buyerWallet = $order->user->wallet ?? Wallet::firstOrCreate(
                ['user_id' => $order->user_id],
                [
                    'currency_code' => $this->currencyService->getDefaultCurrency()->code,
                    'balance' => 0,
                    'locked_balance' => 0,
                    'pending_balance' => 0,
                    'total_deposits' => 0,
                    'total_withdrawals' => 0,
                ]
            );

            $buyerWallet->lockForUpdate();

            $correlationId = Str::uuid();
            $defaultCurrency = $this->currencyService->getDefaultCurrency()->code;

            $balanceBefore = $buyerWallet->balance;
            $balanceAfterTopUp = $balanceBefore + $topUpAmountDefault;
            $balanceAfterPayment = $balanceAfterTopUp - $orderTotalDefault;

            // STEP 1: TOP-UP (in default currency)
            $topUpTransaction = Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'correlation_id' => $correlationId,
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'type' => TransactionType::TOPUP->value,
                'status' => TransactionStatus::PAID->value,
                'calculation_type' => CalculationType::DEBIT->value,
                'amount' => $topUpAmountDefault,
                'currency' => $defaultCurrency,
                'payment_gateway' => $this->id, // 'crypto'
                'gateway_transaction_id' => $invoice['id'] ?? null,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'fee_amount' => 0,
                'net_amount' => $topUpAmountDefault,
                'balance_snapshot' => $balanceAfterTopUp,
                'metadata' => [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
                    'payment_status' => $invoice['payment_status'] ?? null,
                    'display_amount' => $topUpAmountDisplay,
                    'display_currency' => $displayCurrency,
                    'description' => "Wallet top-up of {$topUpAmountDisplay} {$displayCurrency} (={$topUpAmountDefault} {$defaultCurrency}) via Crypto",
                ],
                'notes' => "Top-up: +{$topUpAmountDefault} {$defaultCurrency} via Crypto",
                'processed_at' => now(),
            ]);

            $buyerWallet->update([
                'balance' => $balanceAfterTopUp,
                'total_deposits' => $buyerWallet->total_deposits + $topUpAmountDefault,
                'last_deposit_at' => now(),
            ]);

            // STEP 2: PAYMENT (in default currency)
            $paymentTransaction = Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'correlation_id' => $correlationId,
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'type' => TransactionType::PURCHSED->value,
                'status' => TransactionStatus::PAID->value,
                'calculation_type' => CalculationType::CREDIT->value,
                'amount' => $orderTotalDefault,
                'currency' => $defaultCurrency,
                'payment_gateway' => 'wallet',
                'gateway_transaction_id' => $topUpTransaction->transaction_id,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'fee_amount' => 0,
                'net_amount' => $orderTotalDefault,
                'balance_snapshot' => $balanceAfterPayment,
                'metadata' => [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
                    'description' => "Order payment for #{$order->order_id}",
                    'top_up_transaction_id' => $topUpTransaction->transaction_id,
                    'display_amount' => $orderTotalDisplay,
                    'display_currency' => $displayCurrency,
                ],
                'notes' => "Payment: -{$orderTotalDefault} {$defaultCurrency} for Order #{$order->order_id}",
                'processed_at' => now(),
            ]);

            $buyerWallet->update([
                'balance' => $balanceAfterPayment,
                'total_withdrawals' => $buyerWallet->total_withdrawals + $orderTotalDefault,
                'last_withdrawal_at' => now(),
            ]);

            $payment->update([
                'status' => PaymentStatus::COMPLETED->value,
                'transaction_id' => $invoice['id'] ?? null,
                'paid_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
                    'nowpayments_status' => $invoice['payment_status'] ?? null,
                    'top_up_transaction_id' => $topUpTransaction->id,
                    'payment_transaction_id' => $paymentTransaction->id,
                    'correlation_id' => $correlationId,
                ]),
            ]);

            $this->updateUserPoints($order);

            $order->update([
                'status' => OrderStatus::PAID->value,
                'payment_method' => 'Wallet (Top-up via Crypto)',
                'completed_at' => now(),
            ]);

            Session::forget("topup_order_{$order->order_id}");

            Log::info('Crypto top-up payment flow completed', [
                'order_id' => $order->order_id,
                'correlation_id' => $correlationId,
                'display_currency' => $displayCurrency,
                'top_up_display' => $topUpAmountDisplay,
                'top_up_default' => $topUpAmountDefault,
                'final_balance' => $balanceAfterPayment,
            ]);

            $this->dispatchPaymentNotificationsOnce($payment);
            $this->sendOrderMessage($order);

            return [
                'success' => true,
                'message' => 'Payment completed successfully',
                'correlation_id' => $correlationId,
            ];
        });
    }




    public function processRegularPayment($session, Payment $payment, Order $order): array
    {
        return DB::transaction(function () use ($session, $payment, $order) {

            // 🔒 Prevent duplicate processing
            if ($payment->status === PaymentStatus::COMPLETED->value) {
                return [
                    'success' => true,
                    'message' => 'Order payment already processed',
                ];
            }

            // ✅ Update payment
            $payment->update([
                'status' => PaymentStatus::COMPLETED->value,
                'paid_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'gateway_session_id' => $session->id ?? null,
                    'gateway_status' => 'paid',
                ]),
            ]);

            // ✅ Update order status
            $order->update([
                'payment_status' => 'paid',
                'status' => OrderStatus::COMPLETED->value,
            ]);

            /**
             * 💸 Seller wallet credit (if marketplace)
             */
            if ($order->source && $order->source->user) {
                $sellerWallet = $order->source->user->wallet;

                if ($sellerWallet) {
                    $sellerWallet->increment('balance', $order->grand_total);
                }
            }

            Log::info('Order payment completed', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->payment_id,
            ]);

            return [
                'success' => true,
                'message' => 'Order payment completed successfully',
            ];
        });
    }




    /**
     * Convert amount to Stripe format (cents)
     */
    protected function convertToStripeAmount(float $amount, string $currency): int
    {
        //
    }

    /**
     * Handle payment intent response
     */
    protected function handlePaymentIntentResponse(PaymentIntent $paymentIntent, Order $order, Payment $payment): array
    {
        //
    }

    /**
     * Handle Stripe webhook notifications
     */
    public function handleWebhook(array $payload): void
    {
        //
    }
    /**
     * Handle successful payment webhook
     */
    protected function handlePaymentSuccess(array $paymentIntent): void
    {
        //
    }

    /**
     * Handle failed payment webhook
     */
    protected function handlePaymentFailed(array $paymentIntent): void
    {
        //
    }

    /**
     * Handle processing payment webhook
     */
    protected function handlePaymentProcessing(array $paymentIntent): void
    {
        //
    }

    /**
     * Handle canceled payment webhook
     */
    protected function handlePaymentCanceled(array $paymentIntent): void
    {
        //
    }

    /**
     * Get the frontend JS SDK URL
     */
    public function getJsSDKUrl(): string
    {
        return $this->jsSDKUrl;
    }

    /**
     * Check if this gateway requires frontend JS
     */
    public function requiresFrontendJs(): bool
    {
        return $this->requiresFrontendJs;
    }
}
