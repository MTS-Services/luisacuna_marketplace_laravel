<?php

namespace App\Http\Payment;

use App\Models\Order;
use App\Models\PaymentGateway;

abstract class PaymentMethod
{
    /**
     * The payment method name.
     *
     * @var string
     */
    protected $name;

    /**
     * The associated gateway.
     */
    protected ?PaymentGateway $gateway;

    /**
     * Indicates if this payment method requires frontend JavaScript
     *
     * @var bool
     */
    protected $requiresFrontendJs = false;

    /**
     * The frontend JS SDK URL (if required)
     *
     * @var string|null
     */
    protected $jsSDKUrl = null;

    /**
     * Create a new method instance.
     */
    public function __construct(?PaymentGateway $gateway = null)
    {
        $this->gateway = $gateway;
    }

    /**
     * Start payment process
     * 
     * For frontend-based gateways (Stripe, PayPal):
     *   - Creates payment intent/order
     *   - Returns client secret/order ID for frontend
     * 
     * For backend-based gateways (Coinbase):
     *   - Creates charge/payment
     *   - Returns redirect URL or confirmation
     *
     * @param Order $order
     * @param array $paymentData
     * @return array
     */
    abstract public function startPayment(Order $order, array $paymentData = []);

    /**
     * Confirm payment after frontend processing
     * 
     * Optional method for gateways that use frontend JS
     * Stripe uses this to verify payment intent after Stripe.js confirms
     *
     * @param string $transactionId
     * @param string|null $paymentMethodId
     * @return array
     */
    public function confirmPayment(string $transactionId, ?string $paymentMethodId = null): array
    {
        return [
            'success' => false,
            'message' => 'This payment method does not support confirmation.',
        ];
    }

    /**
     * Handle webhook notifications
     *
     * @param array $payload
     * @return void
     */
    public function handleWebhook(array $payload): void
    {
        // Override in child class if webhook support is needed
    }

    /**
     * Update order with new data
     *
     * @param Order $order
     * @param array $updatedData
     * @return bool
     */
    public function updateOrder(Order $order, array $updatedData): bool
    {
        return $order->update($updatedData);
    }

    /**
     * Check if this payment method requires frontend JavaScript
     *
     * @return bool
     */
    public function requiresFrontendJs(): bool
    {
        return $this->requiresFrontendJs;
    }

    /**
     * Get the frontend JS SDK URL
     *
     * @return string|null
     */
    public function getJsSDKUrl(): ?string
    {
        return $this->jsSDKUrl;
    }

    /**
     * Get the payment method name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the gateway instance
     *
     * @return PaymentGateway|null
     */
    public function getGateway(): ?PaymentGateway
    {
        return $this->gateway;
    }
}
