<?php

namespace App\Http\Payment\Methods;


use App\Http\Payment\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ConversationService;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Http;

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
   
    public function __construct($gateway = null, ConversationService $conversationService)
    {
        parent::__construct($gateway, $conversationService);
        $this->currencyService = app(CurrencyService::class);
        $this->NOW_PUBLIC_API_KEY = config('services.crypto.private_api_key');
        $this->NOW_PRIVATE_API_KEY = config('services.crypto.public_api_key');

 
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
 
            
    $body = [
        "price_amount"       => 3999.5,
        "price_currency"     => "usd",
        "pay_currency"       => "btc",
        "ipn_callback_url"   => "https://yourdomain.com/api/nowpayments/webhook",
        "order_id"           => "RGDBP-21314",
        "order_description" => "Apple Macbook Pro 2019 x 1"
    ];
dd($this->headers());
    $response = Http::withHeaders($this->headers())
        ->post('https://api.nowpayments.io/v1/payment', $body);

       dd($response->json());
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
