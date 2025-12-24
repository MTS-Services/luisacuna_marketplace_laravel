<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Observers\PaymentObserver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SyncPaymentDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 10;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 120;

    /**
     * Delete the job if its models no longer exist.
     */
    public bool $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Payment $payment
    ) {
        // Set queue priority based on payment status
        $this->onQueue('payments');
    }

    /**
     * Execute the job.
     */
    public function handle(PaymentObserver $observer): void
    {
        $lockKey = "payment:sync:{$this->payment->id}:{$this->payment->status->value}";

        try {
            Log::info('Processing payment sync job', [
                'payment_id' => $this->payment->payment_id,
                'status' => $this->payment->status->value,
                'attempt' => $this->attempts(),
            ]);

            // Refresh the payment model to get latest data
            $this->payment->refresh();

            // Sync transaction
            $observer->syncTransaction($this->payment);

            // Sync order status
            $observer->syncOrderStatus($this->payment);

            Log::info('Payment sync job completed successfully', [
                'payment_id' => $this->payment->payment_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment sync job failed', [
                'payment_id' => $this->payment->payment_id,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Release the lock on failure so it can be retried
            Cache::forget($lockKey);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Payment sync job permanently failed', [
            'payment_id' => $this->payment->payment_id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // Release the lock
        $lockKey = "payment:sync:{$this->payment->id}:{$this->payment->status->value}";
        Cache::forget($lockKey);

        // You could send an alert/notification here
        // Example: Notification::route('slack', config('logging.slack.webhook'))
        //     ->notify(new PaymentSyncFailedNotification($this->payment, $exception));
    }

    /**
     * Get the unique ID for the job (prevents duplicate jobs in queue).
     */
    public function uniqueId(): string
    {
        return "payment-sync-{$this->payment->id}-{$this->payment->status->value}";
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'payment:' . $this->payment->payment_id,
            'user:' . $this->payment->user_id,
            'order:' . $this->payment->order_id,
            'status:' . $this->payment->status->value,
        ];
    }
}
