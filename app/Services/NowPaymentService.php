<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NowPaymentService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('nowpayments.apiKey');

        $this->baseUrl = config('nowpayments.env') === 'live'
            ? 'https://api.nowpayments.io/v1'
            : 'https://api-sandbox.nowpayments.io/v1';

        // Debug log on initialization
        Log::info('NowPaymentService initialized', [
            'has_api_key' => !empty($this->apiKey),
            'api_key_length' => strlen($this->apiKey ?? ''),
            'api_key_prefix' => substr($this->apiKey ?? '', 0, 15),
            'env' => config('nowpayments.env'),
            'base_url' => $this->baseUrl,
        ]);
    }

    public function getAvailableCurrencies(): array
    {
        try {
            Log::info('Fetching available currencies', [
                'url' => "{$this->baseUrl}/currencies",
                'api_key_prefix' => substr($this->apiKey, 0, 15),
            ]);

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/currencies");

            Log::info('Currency API response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
            ]);

            if ($response->failed()) {
                Log::error('Currency API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers_sent' => [
                        'x-api-key' => substr($this->apiKey, 0, 15) . '...',
                        'url' => "{$this->baseUrl}/currencies"
                    ]
                ]);
                throw new Exception('API request failed: ' . $response->body());
            }

            $data = $response->json();
            return is_array($data) ? $data : [];
        } catch (Exception $e) {
            Log::error('Failed to fetch currencies: ' . $e->getMessage());
            throw new Exception('Unable to fetch available currencies');
        }
    }

    public function getMinimumAmount(string $currencyFrom, string $currencyTo): float
    {
        try {
            $url = "{$this->baseUrl}/min-amount";
            $params = [
                'currency_from' => strtolower($currencyFrom),
                'currency_to' => strtolower($currencyTo),
            ];

            Log::info('Fetching minimum amount', [
                'url' => $url,
                'params' => $params,
                'api_key_prefix' => substr($this->apiKey, 0, 15),
                'api_key_length' => strlen($this->apiKey),
                'base_url' => $this->baseUrl,
            ]);

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($url, $params);

            Log::info('Min amount API response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_preview' => substr($response->body(), 0, 200),
            ]);

            if ($response->failed()) {
                Log::error('Min amount API failed - DETAILED DEBUG', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'request_url' => $url,
                    'request_params' => $params,
                    'api_key_from_config' => config('nowpayments.apiKey'),
                    'api_key_from_env' => env('NOWPAYMENTS_API_KEY'),
                    'api_key_in_service' => $this->apiKey,
                    'api_key_match' => ($this->apiKey === config('nowpayments.apiKey')),
                    'env_value' => config('nowpayments.env'),
                    'base_url_used' => $this->baseUrl,
                ]);
                throw new Exception('API request failed: ' . $response->body());
            }

            $data = $response->json();
            return (float) ($data['min_amount'] ?? 0);
        } catch (Exception $e) {
            Log::error('Failed to fetch minimum amount: ' . $e->getMessage());
            throw new Exception('Unable to fetch minimum amount');
        }
    }

    public function getEstimatedPrice(float $amount, string $currencyFrom, string $currencyTo): array
    {
        try {
            $url = "{$this->baseUrl}/estimate";
            $params = [
                'amount' => $amount,
                'currency_from' => strtolower($currencyFrom),
                'currency_to' => strtolower($currencyTo),
            ];

            Log::info('Fetching estimate', [
                'url' => $url,
                'params' => $params,
            ]);

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($url, $params);

            if ($response->failed()) {
                Log::error('Estimate API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception('API request failed: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Failed to get estimate: ' . $e->getMessage());
            throw new Exception('Unable to get price estimate');
        }
    }



    public function createInvoice(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/invoice", [
                'price_amount' => (float) $data['price_amount'],
                'price_currency' => strtolower($data['price_currency']),
                'order_id' => $data['order_id'],
                'order_description' => $data['order_description'] ?? 'Payment Invoice',
                'ipn_callback_url' => $data['ipn_callback_url'],
                'success_url' => $data['success_url'],
                'cancel_url' => $data['cancel_url'],
            ]);

            if ($response->failed()) {
                throw new Exception($response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Invoice creation failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }


    public function createPayment(array $paymentData)
    {
        try {
            $priceAmount = $paymentData['price_amount'] ?? null;
            $priceCurrency = $paymentData['price_currency'] ?? null;
            $payCurrency = $paymentData['pay_currency'] ?? null;

            if (!$priceAmount || !$priceCurrency || !$payCurrency) {
                throw new Exception('Missing required payment fields');
            }

            $minAmount = $this->getMinimumAmount(
                $payCurrency,
                $priceCurrency
            );

            $estimate = $this->getEstimatedPrice(
                (float) $priceAmount,
                $priceCurrency,
                $payCurrency
            );

            $estimatedAmount = (float) ($estimate['estimated_amount'] ?? 0);

            if ($estimatedAmount < $minAmount) {
                throw new Exception(
                    "Payment amount ({$estimatedAmount} {$payCurrency}) is below minimum required: {$minAmount} {$payCurrency}"
                );
            }

            // Create payment
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/payment", [
                'price_amount' => (float) $priceAmount,
                'price_currency' => strtolower($priceCurrency),
                'pay_currency' => strtolower($payCurrency),
                'order_id' => $paymentData['order_id'] ?? 'ORD-' . time() . '-' . rand(1000, 9999),
                'order_description' => $paymentData['order_description'] ?? 'Payment',
                'ipn_callback_url' => config('nowpayments.callbackUrl'),
                'success_url' => $paymentData['success_url'] ?? url('/payment/success'),
                'cancel_url' => $paymentData['cancel_url'] ?? url('/payment/cancel'),
            ]);

            if ($response->failed()) {
                Log::error('Payment creation API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'data' => $paymentData
                ]);

                $errorBody = $response->json();
                $errorMessage = $errorBody['message'] ?? $response->body();
                throw new Exception('Payment creation failed: ' . $errorMessage);
            }

            return [
                'success' => true,
                'payment' => $response->json(),
            ];
        } catch (Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage(), [
                'payment_data' => $paymentData
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getPaymentStatus(string $paymentId): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/payment/{$paymentId}");

            if ($response->failed()) {
                throw new Exception('Failed to get payment status');
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Failed to get payment status: ' . $e->getMessage());
            throw new Exception('Unable to get payment status');
        }
    }
}
