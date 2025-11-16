<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Process card payment
     */
    public function processCardPayment(array $data)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $data['amount'] * 100, // convert to cents
                'currency' => $data['currency'] ?? 'usd',
                'payment_method' => $data['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('user.payment.success'),
            ]);

            $payment = Payment::create([
                'user_id' => user()->id,
                'order_id' => rand(1, 100),
                'payment_method' => 'card',
                'payment_gateway' => PaymentStatus::PAYMENT_GATEWAY_STRIPE->value,
                'payment_type' => $data['card_type'] ?? 'unknown',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => 'pending',
                'transaction_id' => Str::uuid(),
                'payment_intent_id' => $paymentIntent->id,
                'metadata' => [
                    'card_last4' => $data['card_last4'] ?? null,
                    'card_brand' => $data['card_brand'] ?? null,
                ],
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $payment->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            return [
                'success' => true,
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process digital wallet payment (Google Pay / Apple Pay)
     */
    public function processDigitalWalletPayment(array $data)
    {
        try {
            // Create payment intent for wallet
            $paymentIntent = PaymentIntent::create([
                'amount' => $data['amount'] * 100,
                'currency' => $data['currency'] ?? 'usd',
                'payment_method_types' => ['card'], // Wallets use card as payment method type
                'metadata' => [
                    'wallet_type' => $data['wallet_type'],
                ],
            ]);

            $payment = Payment::create([
                'user_id' => user()->id,
                'order_id' => rand(1, 100),
                'payment_method' => 'digital_wallet',
                'payment_gateway' => PaymentStatus::PAYMENT_GATEWAY_STRIPE->value,
                'payment_type' => $data['wallet_type'],
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => 'pending',
                'transaction_id' => Str::uuid(),
                'payment_intent_id' => $paymentIntent->id,
                'metadata' => [
                    'wallet_type' => $data['wallet_type'],
                ],
            ]);

            return [
                'success' => true,
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update wallet payment after confirmation
     */
    public function confirmWalletPayment(string $paymentIntentId)
    {
        try {
            $payment = Payment::where('payment_intent_id', $paymentIntentId)->first();
            
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            return [
                'success' => true,
                'payment' => $payment,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process crypto payment via Coinbase Commerce REST API
     */
    public function processCryptoPayment(array $data)
    {
        try {
            $transactionId = Str::uuid();
            
            $chargeData = [
                'name' => $data['description'] ?? 'Payment',
                'description' => $data['description'] ?? 'Crypto payment',
                'local_price' => [
                    'amount' => (string) $data['amount'],
                    'currency' => $data['currency'] ?? 'USD',
                ],
                'pricing_type' => 'fixed_price',
                'redirect_url' => route('user.payment.success'),
                'cancel_url' => route('user.payment.cancel'),
                'metadata' => [
                    'transaction_id' => $transactionId,
                    'user_id' => user()->id,
                ],
            ];

            $response = Http::withHeaders([
                'X-CC-Api-Key' => config('services.coinbase.api_key'),
                'X-CC-Version' => '2018-03-22',
                'Content-Type' => 'application/json',
            ])->post('https://api.commerce.coinbase.com/charges', $chargeData);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Coinbase API error: ' . $response->body(),
                ];
            }

            $charge = $response->json()['data'];

            $payment = Payment::create([
                'user_id' => user()->id,
                'order_id' => rand(1, 100),
                'payment_method' => 'crypto',
                'payment_gateway' => PaymentStatus::PAYMENT_GATEWAY_COINBASE->value,
                'payment_type' => $data['crypto_type'] ?? 'bitcoin',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'USD',
                'status' => 'pending',
                'transaction_id' => $transactionId,
                'payment_intent_id' => $charge['id'],
                'metadata' => [
                    'hosted_url' => $charge['hosted_url'],
                    'addresses' => $charge['addresses'] ?? [],
                    'code' => $charge['code'] ?? null,
                ],
            ]);

            return [
                'success' => true,
                'payment' => $payment,
                'hosted_url' => $charge['hosted_url'],
                'charge_code' => $charge['code'],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getPaymentByTransactionId(string $transactionId)
    {
        return Payment::where('transaction_id', $transactionId)->first();
    }

    public function getPaymentByChargeId(string $chargeId)
    {
        return Payment::where('payment_intent_id', $chargeId)->first();
    }

    public function updatePaymentStatus(string $transactionId, string $status)
    {
        $payment = $this->getPaymentByTransactionId($transactionId);

        if ($payment) {
            $payment->update([
                'status' => $status,
                'completed_at' => $status === 'completed' ? now() : null,
            ]);
        }

        return $payment;
    }
}