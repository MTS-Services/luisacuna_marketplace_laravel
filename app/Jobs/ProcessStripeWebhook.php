<?php

namespace App\Jobs;

use App\Models\PaymentGateway;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * ProcessStripeWebhook Job
 * 
 * Handles: Scenario 4 - Network timeout during webhook
 * Processes Stripe webhooks asynchronously
 */
class ProcessStripeWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $maxExceptions = 3;

    protected array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function handle(): void
    {
        try {
            Log::info('Processing Stripe webhook from queue', [
                'event_type' => $this->payload['type'] ?? 'unknown',
                'event_id' => $this->payload['id'] ?? null,
            ]);

            $gateway = PaymentGateway::where('slug', 'stripe')->first();

            if (!$gateway) {
                Log::error('Stripe gateway not found');
                return;
            }

            $paymentMethod = $gateway->paymentMethod();
            $paymentMethod->handleWebhook($this->payload);

            Log::info('Stripe webhook processed successfully', [
                'event_type' => $this->payload['type'] ?? 'unknown',
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe webhook processing failed', [
                'event_type' => $this->payload['type'] ?? 'unknown',
                'error' => $e->getMessage(),
            ]);

            throw $e; // Retry the job
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ProcessStripeWebhook job failed after all retries', [
            'event_type' => $this->payload['type'] ?? 'unknown',
            'error' => $exception->getMessage(),
        ]);
    }
}
