<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * RetryFailedPayment Job
 * 
 * Retries a failed payment completion
 */
class RetryFailedPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;
    public $backoff = [60, 300, 900]; // 1 min, 5 min, 15 min

    protected int $paymentId;

    public function __construct(int $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function handle(PaymentService $paymentService): void
    {
        try {
            $payment = Payment::find($this->paymentId);

            if (!$payment) {
                Log::warning('Payment not found for retry', [
                    'payment_id' => $this->paymentId,
                ]);
                return;
            }

            Log::info('Retrying payment completion', [
                'payment_id' => $payment->payment_id,
                'attempt' => $this->attempts(),
            ]);

            $success = $paymentService->completePayment($payment);

            if ($success) {
                Log::info('Payment retry successful', [
                    'payment_id' => $payment->payment_id,
                ]);
            } else {
                Log::warning('Payment retry failed', [
                    'payment_id' => $payment->payment_id,
                ]);
                throw new \Exception('Payment completion failed');
            }
        } catch (\Exception $e) {
            Log::error('Payment retry error', [
                'payment_id' => $this->paymentId,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Retry the job
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('RetryFailedPayment job failed after all retries', [
            'payment_id' => $this->paymentId,
            'error' => $exception->getMessage(),
        ]);

        // Send alert to admin
        // \App\Notifications\AdminPaymentRetryFailedNotification::send();
    }
}
