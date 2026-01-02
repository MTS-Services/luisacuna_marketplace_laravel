<?php

namespace App\Http\Payment\Methods;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod as StripePaymentMethod;
use Exception;

class StripeMethodCopy extends PaymentMethod
{
    /**
     * The payment method id name.
     */
    protected $id = 'stripe';

    /**
     * The payment method display name.
     */
    protected $name = 'Stripe';

    /**
     * Indicates if this gateway requires frontend JS
     */
    protected $requiresFrontendJs = true;

    /**
     * The frontend JS SDK URL
     */
    protected $jsSDKUrl = 'https://js.stripe.com/v3/';

    public function __construct($gateway = null)
    {
        parent::__construct($gateway);
        
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Start payment - Create Payment Intent for frontend
     * This method DOES NOT handle card details directly
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
            $currency = session()->get('currency', 'usd');
            
            // Update order status to processing
            $this->updateOrder($order, [
                'status' => OrderStatus::PROCESSING,
                'currency' => $currency,
                'payment_method' => 'stripe',
            ]);
            $order->load('user');

            // Create payment record
            $payment = Payment::create([
                'user_id' => $order->user_id,
                'name' => $order->user->name,
                'email_address' => $order->user->email,
                'payment_gateway' => 'stripe',
                'amount' => $order->grand_total,
                'currency' => $currency,
                'status' => PaymentStatus::PENDING,
                'order_id' => $order->id,
                'creater_id' => $order->user_id,
                'creater_type' => get_class($order->user),
            ]);

            // Create payment intent (without payment method)
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->convertToStripeAmount($order->grand_total, $currency),
                'currency' => strtolower($currency),
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->id,
                    'user_id' => $order->user_id,
                ],
                'description' => "Payment for Order #{$order->order_id}",
            ]);

            // Store payment intent ID
            $payment->update([
                'payment_intent_id' => $paymentIntent->id,
                'status' => PaymentStatus::PENDING,
                'metadata' => [
                    'client_secret' => $paymentIntent->client_secret,
                ],
            ]);

            Log::info('Stripe Payment Intent Created', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->id,
                'payment_intent_id' => $paymentIntent->id,
            ]);

            return [
                'success' => true,
                'payment_id' => $payment->id,
                'payment_intent_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret,
                'publishable_key' => config('services.stripe.key'),
                'message' => 'Payment intent created successfully',
            ];

        } catch (Exception $e) {
            Log::error('Stripe Payment Intent Creation Error', [
                'order_id' => $order->order_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Update order status to failed
            if (isset($order)) {
                $this->updateOrder($order, [
                    'status' => OrderStatus::FAILED,
                    'notes' => 'Payment intent creation failed: ' . $e->getMessage(),
                ]);
            }

            // Update payment status to failed
            if (isset($payment)) {
                $payment->markAsFailed($e->getMessage());
            }

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Unable to initialize payment. Please try again.',
            ];
        }
    }

    /**
     * Confirm payment after frontend processing
     * 
     * @param string $transactionId The payment intent ID
     * @param string|null $paymentMethodId The payment method ID
     * @return array
     */
    public function confirmPayment(string $transactionId, ?string $paymentMethodId = null): array
    {
        try {
            // Retrieve payment intent (transactionId is the payment_intent_id)
            $paymentIntent = PaymentIntent::retrieve($transactionId);

            // Get payment record
            $paymentId = $paymentIntent->metadata->payment_id ?? null;
            if (!$paymentId) {
                throw new Exception('Payment record not found in metadata');
            }

            $payment = Payment::find($paymentId);
            if (!$payment) {
                throw new Exception('Payment record not found');
            }

            // Store payment method ID if provided
            if ($paymentMethodId) {
                $payment->update([
                    'payment_method_id' => $paymentMethodId,
                ]);
            }

            // Get order
            $order = $payment->order;

            // Handle payment intent status
            return $this->handlePaymentIntentResponse($paymentIntent, $order, $payment);

        } catch (Exception $e) {
            Log::error('Stripe Payment Confirmation Error', [
                'payment_intent_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Payment confirmation failed. Please contact support.',
            ];
        }
    }

    /**
     * Convert amount to Stripe format (cents)
     */
    protected function convertToStripeAmount(float $amount, string $currency): int
    {
        // Zero-decimal currencies (e.g., JPY, KRW)
        $zeroDecimalCurrencies = ['jpy', 'krw', 'vnd', 'clp'];
        
        if (in_array(strtolower($currency), $zeroDecimalCurrencies)) {
            return (int) $amount;
        }
        
        // Standard currencies (multiply by 100 for cents)
        return (int) ($amount * 100);
    }

    /**
     * Handle payment intent response
     */
    protected function handlePaymentIntentResponse(PaymentIntent $paymentIntent, Order $order, Payment $payment): array
    {
        switch ($paymentIntent->status) {
            case 'succeeded':
                // Update order
                $this->updateOrder($order, [
                    'status' => OrderStatus::COMPLETED,
                    'notes' => "Payment successful. Stripe Payment Intent: {$paymentIntent->id}",
                ]);

                // Update payment
                $payment->markAsCompleted($paymentIntent->id);
                $payment->update([
                    'transaction_id' => $paymentIntent->id,
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'payment_intent_status' => $paymentIntent->status,
                        'payment_method_id' => $paymentIntent->payment_method,
                    ]),
                ]);

                Log::info('Stripe Payment Succeeded', [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->id,
                    'payment_intent_id' => $paymentIntent->id,
                ]);

                return [
                    'success' => true,
                    'payment_id' => $payment->id,
                    'payment_intent_id' => $paymentIntent->id,
                    'status' => 'succeeded',
                    'message' => 'Payment completed successfully!',
                    'redirect_url' => route('payment.success', ['order_id' => $order->order_id]),
                ];

            case 'processing':
                $payment->update([
                    'status' => PaymentStatus::PROCESSING,
                    'notes' => 'Payment is being processed',
                ]);

                return [
                    'success' => true,
                    'status' => 'processing',
                    'message' => 'Your payment is being processed. You will receive a confirmation shortly.',
                ];

            case 'requires_payment_method':
                $this->updateOrder($order, [
                    'status' => OrderStatus::FAILED,
                    'notes' => 'Payment method declined.',
                ]);

                $payment->markAsFailed('Payment method declined');

                return [
                    'success' => false,
                    'error' => 'payment_declined',
                    'message' => 'Your payment was declined. Please try another payment method.',
                ];

            case 'requires_action':
            case 'requires_confirmation':
                return [
                    'success' => false,
                    'requires_action' => true,
                    'client_secret' => $paymentIntent->client_secret,
                    'message' => 'Additional authentication required.',
                ];

            default:
                $this->updateOrder($order, [
                    'status' => OrderStatus::FAILED,
                    'notes' => "Payment intent status: {$paymentIntent->status}",
                ]);

                $payment->markAsFailed("Payment intent status: {$paymentIntent->status}");

                return [
                    'success' => false,
                    'status' => $paymentIntent->status,
                    'message' => 'Payment could not be processed. Please try again.',
                ];
        }
    }

    /**
     * Handle Stripe webhook notifications
     */
    public function handleWebhook(array $payload): void
    {
        $event = $payload['type'] ?? null;

        Log::info('Stripe Webhook Received', ['event' => $event]);

        switch ($event) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSuccess($payload['data']['object']);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($payload['data']['object']);
                break;

            case 'payment_intent.processing':
                $this->handlePaymentProcessing($payload['data']['object']);
                break;

            case 'payment_intent.canceled':
                $this->handlePaymentCanceled($payload['data']['object']);
                break;

            default:
                Log::info('Unhandled Stripe webhook event', ['event' => $event]);
        }
    }

    /**
     * Handle successful payment webhook
     */
    protected function handlePaymentSuccess(array $paymentIntent): void
    {
        $paymentId = $paymentIntent['metadata']['payment_id'] ?? null;
        
        if (!$paymentId) {
            Log::warning('Payment ID not found in webhook metadata', ['payment_intent' => $paymentIntent['id']]);
            return;
        }

        $payment = Payment::find($paymentId);
        
        if ($payment && !$payment->isSuccessful()) {
            $payment->markAsCompleted($paymentIntent['id']);
            $payment->update([
                'transaction_id' => $paymentIntent['id'],
                'payment_method_id' => $paymentIntent['payment_method'] ?? $payment->payment_method_id,
                'metadata' => array_merge($payment->metadata ?? [], [
                    'webhook_received_at' => now()->toDateTimeString(),
                    'payment_intent_status' => $paymentIntent['status'],
                ]),
            ]);

            // Update order
            $order = $payment->order;
            if ($order && $order->status !== OrderStatus::COMPLETED) {
                $this->updateOrder($order, [
                    'status' => OrderStatus::COMPLETED,
                    'notes' => "Payment confirmed via webhook. Stripe Payment Intent: {$paymentIntent['id']}",
                ]);
            }

            Log::info('Stripe Webhook: Payment Success Processed', [
                'payment_id' => $payment->id,
                'order_id' => $order->order_id ?? null,
            ]);
        }
    }

    /**
     * Handle failed payment webhook
     */
    protected function handlePaymentFailed(array $paymentIntent): void
    {
        $paymentId = $paymentIntent['metadata']['payment_id'] ?? null;
        
        if (!$paymentId) {
            Log::warning('Payment ID not found in webhook metadata', ['payment_intent' => $paymentIntent['id']]);
            return;
        }

        $payment = Payment::find($paymentId);
        
        if ($payment && !$payment->isFailed()) {
            $errorMessage = $paymentIntent['last_payment_error']['message'] ?? 'Payment failed';
            $payment->markAsFailed($errorMessage);
            $payment->update([
                'metadata' => array_merge($payment->metadata ?? [], [
                    'webhook_received_at' => now()->toDateTimeString(),
                    'error' => $paymentIntent['last_payment_error'] ?? null,
                ]),
            ]);

            // Update order
            $order = $payment->order;
            if ($order && $order->status !== OrderStatus::FAILED) {
                $this->updateOrder($order, [
                    'status' => OrderStatus::FAILED,
                    'notes' => "Payment failed via webhook: {$errorMessage}",
                ]);
            }

            Log::info('Stripe Webhook: Payment Failed Processed', [
                'payment_id' => $payment->id,
                'order_id' => $order->order_id ?? null,
                'error' => $errorMessage,
            ]);
        }
    }

    /**
     * Handle processing payment webhook
     */
    protected function handlePaymentProcessing(array $paymentIntent): void
    {
        $paymentId = $paymentIntent['metadata']['payment_id'] ?? null;
        
        if (!$paymentId) {
            return;
        }

        $payment = Payment::find($paymentId);
        
        if ($payment) {
            $payment->update([
                'status' => PaymentStatus::PROCESSING,
                'notes' => 'Payment is being processed',
            ]);

            Log::info('Stripe Webhook: Payment Processing', [
                'payment_id' => $payment->id,
            ]);
        }
    }

    /**
     * Handle canceled payment webhook
     */
    protected function handlePaymentCanceled(array $paymentIntent): void
    {
        $paymentId = $paymentIntent['metadata']['payment_id'] ?? null;
        
        if (!$paymentId) {
            return;
        }

        $payment = Payment::find($paymentId);
        
        if ($payment) {
            $payment->update([
                'status' => PaymentStatus::CANCELLED,
                'notes' => 'Payment was canceled',
            ]);

            $order = $payment->order;
            if ($order) {
                $this->updateOrder($order, [
                    'status' => OrderStatus::CANCELLED,
                    'notes' => 'Payment was canceled',
                ]);
            }

            Log::info('Stripe Webhook: Payment Canceled', [
                'payment_id' => $payment->id,
                'order_id' => $order->order_id ?? null,
            ]);
        }
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