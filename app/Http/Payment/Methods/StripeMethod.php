<?php

namespace App\Http\Payment\Methods;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;
use Exception;

class StripeMethod extends PaymentMethod
{
    protected $id = 'stripe';
    protected $name = 'Stripe';
    protected $requiresFrontendJs = false;

    public function __construct($gateway = null)
    {
        parent::__construct($gateway);
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Start payment - Create Stripe Checkout Session
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        try {
            // Create or get existing payment record
            $payment = Payment::firstOrCreate(
                [
                    'order_id' => $order->id,
                    'status' => PaymentStatus::PENDING->value,
                ],
                [
                    'payment_id' => generate_payment_id(),
                    'user_id' => $order->user_id,
                    'name' => $order->user->full_name ?? null,
                    'email_address' => $order->user->email ?? null,
                    'payment_gateway' => $this->id,
                    'amount' => $order->grand_total,
                    'currency' => $order->currency ?? 'USD',
                    'status' => PaymentStatus::PENDING->value,
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
                        'quantity' => $order->quantity ?? 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('user.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->order_id,
                'cancel_url' => route('user.payment.failed') . '?order_id=' . $order->order_id,
                'metadata' => [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'user_id' => $order->user_id,
                    'quantity' => $order->quantity ?? 1,
                ],
                'customer_email' => $order->user->email ?? null,
            ]);

            // Update payment with session ID
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
        } catch (Exception $e) {
            Log::error('Stripe payment initialization failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initialize Stripe payment: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm payment after Stripe Checkout
     */
    public function confirmPayment(string $sessionId, ?string $paymentMethodId = null): array
    {
        try {
            $session = StripeSession::retrieve($sessionId);

            if (!$session) {
                throw new Exception('Stripe session not found');
            }

            // Find payment by session ID
            $payment = Payment::where('payment_intent_id', $sessionId)->first();

            if (!$payment) {
                throw new Exception('Payment record not found');
            }

            $order = $payment->order;

            if ($session->payment_status === 'paid') {
                // Retrieve PaymentIntent for additional details
                $paymentIntent = PaymentIntent::retrieve($session->payment_intent);

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
                    ]),
                ]);

                // Update order status
                $order->update([
                    'status' => OrderStatus::PAID->value,
                    'payment_method' => $this->name,
                    'completed_at' => now(),
                ]);

                Log::info('Payment confirmed successfully', [
                    'order_id' => $order->order_id,
                    'payment_id' => $payment->payment_id,
                    'session_id' => $sessionId,
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment successful!',
                    'order_id' => $order->order_id,
                    'payment' => $payment,
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment not completed. Status: ' . $session->payment_status,
            ];
        } catch (Exception $e) {
            Log::error('Payment confirmation failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment confirmation failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Convert amount to Stripe format (cents)
     */
    protected function convertToStripeAmount(float $amount, string $currency): int
    {
        // Zero-decimal currencies (e.g., JPY, KRW)
        $zeroDecimalCurrencies = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return (int) round($amount);
        }

        return (int) round($amount * 100);
    }

    /**
     * Handle Stripe webhook notifications
     */
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

    /**
     * Handle checkout session completed
     */
    protected function handleCheckoutCompleted(array $session): void
    {
        try {
            $orderId = $session['metadata']['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('No order_id in session metadata', ['session_id' => $session['id']]);
                return;
            }

            $order = Order::where('order_id', $orderId)->first();

            if (!$order) {
                Log::warning('Order not found for webhook', ['order_id' => $orderId]);
                return;
            }

            $payment = $order->latestPayment;

            if ($payment && $session['payment_status'] === 'paid') {
                $payment->update([
                    'status' => PaymentStatus::COMPLETED->value,
                    'paid_at' => now(),
                ]);

                $order->update([
                    'status' => OrderStatus::PAID->value,
                    'completed_at' => now(),
                ]);

                Log::info('Checkout session completed webhook processed', [
                    'order_id' => $orderId,
                    'session_id' => $session['id'],
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error processing checkout completed webhook', [
                'error' => $e->getMessage(),
                'session' => $session,
            ]);
        }
    }

    /**
     * Handle successful payment webhook
     */
    protected function handlePaymentSuccess(array $paymentIntent): void
    {
        try {
            $payment = Payment::where('transaction_id', $paymentIntent['id'])->first();

            if ($payment) {
                $payment->update([
                    'status' => PaymentStatus::COMPLETED->value,
                    'paid_at' => now(),
                ]);

                $payment->order->update([
                    'status' => OrderStatus::PAID->value,
                    'completed_at' => now(),
                ]);

                Log::info('Payment success webhook processed', [
                    'payment_id' => $payment->payment_id,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error processing payment success webhook', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle failed payment webhook
     */
    protected function handlePaymentFailed(array $paymentIntent): void
    {
        try {
            $payment = Payment::where('payment_intent_id', $paymentIntent['id'])->first();

            if ($payment) {
                $payment->update([
                    'status' => PaymentStatus::FAILED->value,
                    'notes' => $paymentIntent['last_payment_error']['message'] ?? 'Payment failed',
                ]);

                $payment->order->update([
                    'status' => OrderStatus::FAILED->value,
                ]);

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

    /**
     * Handle canceled payment webhook
     */
    protected function handlePaymentCanceled(array $paymentIntent): void
    {
        try {
            $payment = Payment::where('payment_intent_id', $paymentIntent['id'])->first();

            if ($payment) {
                $payment->update([
                    'status' => PaymentStatus::CANCELLED->value,
                ]);

                $payment->order->update([
                    'status' => OrderStatus::CANCELLED->value,
                ]);

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
