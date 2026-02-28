<?php

namespace App\Http\Payment\Methods;


use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Services\AchievementService;
use App\Services\ConversationService;
use App\Services\CurrencyService;


class TebexMethod extends PaymentMethod
{
    protected $id = 'tebex';

    protected $name = 'Tebex';

    protected $requiresFrontendJs = false;

    protected CurrencyService $currencyService;

    public function __construct($gateway, ConversationService $conversationService, AchievementService $achievementService)
    {
        parent::__construct($gateway, $conversationService, $achievementService);
    }

    /**
     * Start payment - Create Stripe Checkout Session with currency conversion
     */
    public function startPayment(Order $order, array $paymentData = [])
    {
        //
    }

    /**
     * Confirm payment after Stripe success
     */
    public function confirmPayment(string $sessionId, ?string $paymentMethodId = null): array
    {
        return [
            'success' => false,
            'message' => 'This payment method does not support confirmation.',
        ];
    }

    /**
     * Process top-up payment with currency conversion
     * Wallet is ALWAYS in default currency
     */
    protected function processTopUpPayment($session, Payment $payment, Order $order) {}
    /**
     * Process regular payment with currency conversion
     */
    protected function processRegularPayment($session, Payment $payment, Order $order) {}

    protected function convertToStripeAmount(float $amount, string $currency) {}

    // Webhook methods remain the same...
    public function handleWebhook(array $payload): void {}

    protected function handleCheckoutCompleted(array $session): void {}

    protected function handlePaymentSuccess(array $paymentIntent): void {}

    protected function handlePaymentFailed(array $paymentIntent): void {}

    protected function handlePaymentCanceled(array $paymentIntent): void {}
}
