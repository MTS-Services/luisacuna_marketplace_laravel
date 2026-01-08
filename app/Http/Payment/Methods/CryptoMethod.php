<?php

namespace App\Http\Payment\Methods;


use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;


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

    public function __construct($gateway = null)
    {
        parent::__construct($gateway);

        //
    }

    /**
     * Start payment - Create Payment Intent for frontend
     * This method DOES NOT handle card details directly
     */
    public function startPayment(Order $order, array $paymentData = []): array
    {
        //
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
        //
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
