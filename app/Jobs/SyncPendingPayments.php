<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * SyncPendingPayments Job
 * 
 * Handles: Scenario 6 - Payment confirmed but webhook never arrives
 * Runs every 5 minutes to check and sync pending payments
 */
class SyncPendingPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 300; // 5 minutes
    public $maxExceptions = 3;

    public function handle(PaymentService $paymentService): void
    {
        Log::info('Starting pending payments sync');

        // Get payments stuck in pending
        $pendingPayments = Payment::where('status', PaymentStatus::PENDING->value)
            ->where('payment_intent_id', '!=', null)
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->get();

        Log::info('Found pending payments to sync', [
            'count' => $pendingPayments->count(),
        ]);

        $synced = 0;
        $failed = 0;

        foreach ($pendingPayments as $payment) {
            try {
                Log::info('Attempting to sync payment', [
                    'payment_id' => $payment->payment_id,
                    'gateway' => $payment->payment_gateway,
                    'age_minutes' => $payment->created_at->diffInMinutes(now()),
                ]);

                if ($paymentService->syncPaymentWithGateway($payment)) {
                    $synced++;

                    Log::info('Payment synced successfully', [
                        'payment_id' => $payment->payment_id,
                    ]);
                } else {
                    Log::debug('Payment still pending', [
                        'payment_id' => $payment->payment_id,
                    ]);
                }
            } catch (\Exception $e) {
                $failed++;

                Log::error('Payment sync failed', [
                    'payment_id' => $payment->payment_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Pending payments sync completed', [
            'total' => $pendingPayments->count(),
            'synced' => $synced,
            'failed' => $failed,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SyncPendingPayments job failed', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
