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
use Exception;

class CryptoMethod extends PaymentMethod
{
    protected $id = 'crypto';
    protected $name = 'Crypto';
    protected $requiresFrontendJs = false;
    protected $currencyService;
    protected $NOW_PUBLIC_API_KEY;
    protected $NOW_PRIVATE_API_KEY;
    protected string $baseUrl;

    public function __construct($gateway = null, ConversationService $conversationService, AchievementService $achievementService)
    {
        parent::__construct($gateway, $conversationService, $achievementService);
        $this->currencyService = app(CurrencyService::class);
        $this->NOW_PUBLIC_API_KEY = config('services.crypto.public_api_key');
        $this->NOW_PRIVATE_API_KEY = config('services.crypto.private_api_key');

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
     * Start payment - Create NOWPayments Invoice with currency conversion
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

                $order->update([
                    'status' => OrderStatus::PENDING->value,
                    'payment_status' => 'pending',
                    'payment_method' => $this->name,
                ]);

                $metadata = [
                    'is_topup' => $isTopUp,
                    'display_currency' => $displayCurrency,
                    'display_amount' => $paymentAmount,
                    'exchange_rate' => $exchangeRate,
                ];

                if ($isTopUp) {
                    $topUpAmountDefault = $this->currencyService->convertToDefault(
                        $topUpAmount,
                        $displayCurrency
                    );

                    $orderTotalDefault = $this->currencyService->convertToDefault(
                        $order->grand_total,
                        $displayCurrency
                    );

                    $metadata['top_up_amount'] = $topUpAmount;
                    $metadata['top_up_amount_default'] = $topUpAmountDefault;
                    $metadata['order_total_default'] = $orderTotalDefault;
                }

                // Create payment record
                $payment = Payment::create([
                    'payment_id' => generate_payment_id(),
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'name' => $order->user->full_name ?? null,
                    'email_address' => $order->user->email ?? null,
                    'payment_gateway' => $this->id,
                    'amount' => $paymentAmountDefault,
                    'currency' => $this->currencyService->getDefaultCurrency()->code,
                    'status' => PaymentStatus::PENDING->value,
                    'creater_id' => $order->user_id,
                    'creater_type' => get_class($order->user),
                    'metadata' => $metadata,
                ]);

                // Determine description and URLs
                if ($isTopUp) {
                    // $successUrl = route('user.payment.topup.success') . '?order_id=' . $order->order_id;
                     $successUrl = route('user.payment.success') . "?invoice_id=test&order_id=" . $order->order_id;
                    $cancelUrl = route('user.payment.failed') . '?order_id=' . $order->order_id;
                    $description = "Wallet Top-up for Order #{$order->order_id}";
                    $productName = 'Wallet Top-Up';
                } else {
                    $successUrl = route('user.payment.success') . '?order_id=' . $order->order_id;
                    $cancelUrl = route('user.payment.failed') . '?order_id=' . $order->order_id;
                    $description = 'Order ID: ' . $order->order_id;
                    $productName = $order->source?->name ?? 'Order #' . $order->order_id;
                }

                Log::info('Starting crypto payment', [
                    'order_id' => $order->order_id,
                    'amount' => $paymentAmount,
                    'currency' => $displayCurrency,
                    'is_topup' => $isTopUp,
                ]);

                // Create Invoice via NOWPayments API
                $response = Http::withHeaders($this->headers())
                    ->post("{$this->baseUrl}/invoice", [
                        'price_amount' => (float) $paymentAmount,
                        'price_currency' => strtolower($displayCurrency),
                        'order_id' => $order->order_id,
                        'order_description' => $description,
                        'ipn_callback_url' => url('/nowpayments/ipn'),
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ]);

                if ($response->failed()) {
                    $order->update([
                        'status' => OrderStatus::FAILED->value,
                        'payment_status' => 'failed',
                    ]);

                    $payment->update([
                        'status' => PaymentStatus::FAILED->value,
                    ]);

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

               
                if (!isset($invoice['id']) || empty($invoice['id'])) {
                    Log::error('NOWPayments Invoice ID missing', [
                        'order_id' => $order->order_id,
                        'response' => $invoice,
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Invoice ID not received from payment gateway.',
                    ];
                }

                $invoiceId = $invoice['id'];
                $invoiceUrl = $invoice['invoice_url'] ?? null;

                Log::info('NOWPayments Invoice created with currency', [
                    'order_id' => $order->order_id,
                    'invoice_id' => $invoiceId,
                    'invoice_url' => $invoiceUrl,
                    'payment_id' => $payment->payment_id,
                    'is_topup' => $isTopUp,
                    'display_amount' => $paymentAmount,
                    'display_currency' => $displayCurrency,
                    'default_amount' => $paymentAmountDefault,
                    'default_currency' => $this->currencyService->getDefaultCurrency()->code,
                ]);

                $payment->update([
                    'payment_intent_id' => $invoiceId,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'checkout_url' => $invoiceUrl,
                        'nowpayments_invoice' => $invoice,
                    ]),
                ]);

                $order->update([
                    'payment_intent_id' => $invoiceId,
                ]);

                return [
                    'success' => true,
                    'message' => 'Redirecting to payment gateway...',
                    'checkout_url' => $invoiceUrl,
                    'invoice_id' => $invoiceId,
                    'payment_id' => $payment->payment_id,
                ];
            });
        } catch (Exception $e) {
            try {
                $order->update([
                    'status' => OrderStatus::FAILED->value,
                    'payment_status' => 'failed',
                ]);
            } catch (Exception $ex) {
                // Ignore if order update fails
            }

            Log::error('Crypto payment initialization failed', [
                'order_id' => $order->order_id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initialize crypto payment: ' . $e->getMessage(),
            ];
        }
    }


//     public function startPayment(Order $order, array $paymentData = []): array
// {
//     try {
//         $order->load(['user', 'source.user']);

//         return DB::transaction(function () use ($order, $paymentData) {
//             $isTopUp = $paymentData['is_topup'] ?? false;
//             $topUpAmount = $paymentData['top_up_amount'] ?? null;

//             $displayCurrency = $paymentData['display_currency'] ?? $order->currency ?? currency_code();
//             $paymentAmount = $isTopUp ? $topUpAmount : $order->grand_total;

//             $paymentAmountDefault = $this->currencyService->convertToDefault($paymentAmount, $displayCurrency);

//             $order->update([
//                 'status' => OrderStatus::PENDING->value,
//                 'payment_status' => 'pending',
//                 'payment_method' => $this->name,
//             ]);

//             $metadata = [
//                 'is_topup' => $isTopUp,
//                 'display_currency' => $displayCurrency,
//                 'display_amount' => $paymentAmount,
//             ];

//             // Create payment record
//             $payment = Payment::create([
//                 'payment_id' => generate_payment_id(),
//                 'user_id' => $order->user_id,
//                 'order_id' => $order->id,
//                 'name' => $order->user->full_name ?? null,
//                 'email_address' => $order->user->email ?? null,
//                 'payment_gateway' => $this->id,
//                 'amount' => $paymentAmountDefault,
//                 'currency' => $this->currencyService->getDefaultCurrency()->code,
//                 'status' => PaymentStatus::PENDING->value,
//                 'creater_id' => $order->user_id,
//                 'creater_type' => get_class($order->user),
//                 'metadata' => $metadata,
//             ]);

//             $description = $isTopUp ? "Wallet Top-up for Order #{$order->order_id}" : 'Order ID: ' . $order->order_id;
//             $cancelUrl = route('user.payment.failed') . '?order_id=' . $order->order_id;

//             // ১) প্রথমে invoice create করি
//             $response = Http::withHeaders($this->headers())
//                 ->post("{$this->baseUrl}/invoice", [
//                     'price_amount' => (float)$paymentAmount,
//                     'price_currency' => strtolower($displayCurrency),
//                     'order_id' => $order->order_id,
//                     'order_description' => $description,
//                     'ipn_callback_url' => url('/nowpayments/ipn'),
//                     'success_url' => '', // পরে update করব
//                     'cancel_url' => $cancelUrl,
//                 ]);

//             if ($response->failed()) {
//                 $order->update([
//                     'status' => OrderStatus::FAILED->value,
//                     'payment_status' => 'failed',
//                 ]);
//                 $payment->update(['status' => PaymentStatus::FAILED->value]);

//                 return [
//                     'success' => false,
//                     'message' => 'Failed to create payment invoice. Please try again.',
//                 ];
//             }

//             $invoice = $response->json();
//             $invoiceId = $invoice['id'] ?? null;
//             $invoiceUrl = $invoice['invoice_url'] ?? null;

//             if (!$invoiceId) {
//                 return [
//                     'success' => false,
//                     'message' => 'Invoice ID not received from payment gateway.',
//                 ];
//             }

//             // ২) এখন success_url তৈরি
//             $successUrl = route('user.payment.success') 
//                 . '?order_id=' . $order->order_id 
//                 . '&invoice_id=' . $invoiceId;

//             // ৩) invoice update করি success_url এর সাথে
//             Http::withHeaders($this->headers())
//                 ->put("{$this->baseUrl}/invoice/{$invoiceId}", [
//                     'success_url' => $successUrl,
//                     'cancel_url' => $cancelUrl,
//                 ]);

//             // payment এবং order update
//             $payment->update([
//                 'payment_intent_id' => $invoiceId,
//                 'metadata' => array_merge($payment->metadata ?? [], [
//                     'checkout_url' => $invoiceUrl,
//                     'nowpayments_invoice' => $invoice,
//                 ]),
//             ]);

//             $order->update([
//                 'payment_intent_id' => $invoiceId,
//             ]);

//             return [
//                 'success' => true,
//                 'message' => 'Redirecting to payment gateway...',
//                 'checkout_url' => $invoiceUrl,
//                 'invoice_id' => $invoiceId,
//                 'payment_id' => $payment->payment_id,
//             ];
//         });
//     } catch (\Exception $e) {
//         $order->update([
//             'status' => OrderStatus::FAILED->value,
//             'payment_status' => 'failed',
//         ]);

//         return [
//             'success' => false,
//             'message' => 'Failed to initialize crypto payment: ' . $e->getMessage(),
//         ];
//     }
// }

    /**
     * Confirm payment after NOWPayments success
     */
    public function confirmPayment(string $invoiceId, ?string $paymentMethodId = null): array
    {
        // dd($paymentMethodId);

        // dd($invoiceId);
        try {
            $response = Http::withHeaders($this->headers())
                ->get("{$this->baseUrl}/payment/{$invoiceId}");

            if ($response->failed()) {
                throw new Exception('Invoice fetch failed');
            }

            $invoice = $response->json();
            $status = $invoice['payment_status'] ?? null;

        

            $payment = Payment::where('payment_intent_id', $invoiceId)
            ->with(['order.user.wallet', 'order.source.user.wallet', 'user'])
                ->first();
            
                // dd($payment);

            if (!$payment) {
                throw new Exception('Payment record not found.');
            }

            if ($payment->status === PaymentStatus::COMPLETED->value) {
                return ['success' => true, 'message' => 'Payment already processed.'];
            }

            $order = $payment->order;
            $isTopUp = $payment->metadata['is_topup'] ?? false;

            if (in_array($status, ['confirmed', 'finished'])) {
                if ($isTopUp) {
                    return $this->processTopUpPayment($invoice, $payment, $order);
                } else {
                    return $this->processRegularPayment($invoice, $payment, $order);
                }
            }

            return [
                'success' => false,
                'message' => 'Payment not completed. Status: ' . $status,
            ];
        } catch (Exception $e) {
            Log::error('Payment confirmation failed', [
                'invoice_id' => $invoiceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment confirmation failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Process top-up payment with currency conversion
     * Wallet is ALWAYS in default currency
     */
    protected function processTopUpPayment($invoice, Payment $payment, Order $order): array
    {
        return DB::transaction(function () use ($invoice, $payment, $order) {
            $payment->lockForUpdate();
            $order->lockForUpdate();

            $topUpData = Session::get("topup_order_{$order->order_id}");

            if (!$topUpData) {
                throw new Exception('Top-up session data not found');
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
                'payment_gateway' => 'nowpayments',
                'gateway_transaction_id' => $invoice['id'] ?? null,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'fee_amount' => 0,
                'net_amount' => $topUpAmountDefault,
                'balance_snapshot' => $balanceAfterTopUp,
                'metadata' => [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
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

            Log::info('Top-up payment flow completed with currency conversion', [
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

    /**
     * Process regular payment with currency conversion
     */
    protected function processRegularPayment($invoice, Payment $payment, Order $order): array
    {
        return DB::transaction(function () use ($invoice, $payment, $order) {
            $payment->lockForUpdate();
            $order->lockForUpdate();

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

            // Payment amount is already in default currency
            $paymentAmountDefault = $payment->amount;
            $orderTotalDefault = $order->default_grand_total ?? $order->grand_total;

            $balanceBefore = $buyerWallet->balance;
            $balanceAfterDeposit = $balanceBefore + $paymentAmountDefault;
            $balanceAfterPayment = $balanceAfterDeposit - $orderTotalDefault;

            // Get display currency info
            $displayCurrency = $payment->metadata['display_currency'] ?? $order->display_currency;
            $displayAmount = $payment->metadata['display_amount'] ?? null;

            // TRANSACTION 1: DEPOSIT
            $depositTransaction = Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'correlation_id' => $correlationId,
                'user_id' => $payment->user_id,
                'order_id' => $order->id,
                'type' => TransactionType::TOPUP->value,
                'status' => TransactionStatus::PAID->value,
                'calculation_type' => CalculationType::DEBIT->value,
                'amount' => $paymentAmountDefault,
                'currency' => $defaultCurrency,
                'payment_gateway' => 'nowpayments',
                'gateway_transaction_id' => $invoice['id'] ?? null,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'fee_amount' => 0,
                'net_amount' => $paymentAmountDefault,
                'balance_snapshot' => $balanceAfterDeposit,
                'metadata' => [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
                    'display_amount' => $displayAmount,
                    'display_currency' => $displayCurrency,
                    'description' => "Top-up via Crypto for Order #{$order->order_id}",
                ],
                'notes' => "Deposit: +{$paymentAmountDefault} {$defaultCurrency} via Crypto",
                'processed_at' => now(),
            ]);

            $buyerWallet->update([
                'balance' => $balanceAfterDeposit,
                'total_deposits' => $buyerWallet->total_deposits + $paymentAmountDefault,
                'last_deposit_at' => now(),
            ]);

            // TRANSACTION 2: PAYMENT
            $paymentTransaction = Transaction::create([
                'transaction_id' => generate_transaction_id_hybrid(),
                'correlation_id' => $correlationId,
                'user_id' => $payment->user_id,
                'order_id' => $order->id,
                'type' => TransactionType::PURCHSED->value,
                'status' => TransactionStatus::PAID->value,
                'calculation_type' => CalculationType::CREDIT->value,
                'amount' => $orderTotalDefault,
                'currency' => $defaultCurrency,
                'payment_gateway' => 'wallet',
                'gateway_transaction_id' => $depositTransaction->transaction_id,
                'source_id' => $payment->id,
                'source_type' => Payment::class,
                'fee_amount' => 0,
                'net_amount' => $orderTotalDefault,
                'balance_snapshot' => $balanceAfterPayment,
                'metadata' => [
                    'nowpayments_invoice_id' => $invoice['id'] ?? null,
                    'description' => "Payment for Order #{$order->order_id}",
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
                    'nowpayments_status' => $invoice['payment_status'] ?? null,
                    'deposit_transaction_id' => $depositTransaction->id,
                    'payment_transaction_id' => $paymentTransaction->id,
                    'correlation_id' => $correlationId,
                ]),
            ]);

            $order->update([
                'status' => OrderStatus::PAID->value,
                'payment_method' => 'Wallet (via Crypto)',
                'completed_at' => now(),
            ]);

            $this->updateUserPoints($order);

            Log::info('Crypto payment confirmed with currency conversion', [
                'order_id' => $order->order_id,
                'correlation_id' => $correlationId,
                'display_currency' => $displayCurrency,
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

    public function requiresFrontendJs(): bool
    {
        return $this->requiresFrontendJs;
    }
}