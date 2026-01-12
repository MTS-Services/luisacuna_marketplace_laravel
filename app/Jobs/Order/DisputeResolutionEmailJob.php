<?php

namespace App\Jobs\Order;

use App\Mail\DisputeResolutionEmail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Dispute;

class DisputeResolutionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $orderId, public string $recipientEmail, public string $userName)
    {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $order = Order::with(['user', 'source.user', 'disputes'])->findOrFail($this->orderId);

            Mail::to($this->recipientEmail)
                ->send(new DisputeResolutionEmail($order, $this->userName));

            Log::info('Dispute notification email sent', [
                'order_id' => $order->order_id,
                'recipient' => $this->recipientEmail,
            ]);
        } catch (\Exception $e) {
            Log::error('Dispute notification email', [
                'order_id' => $order->order_id,
                'recipient' => $this->recipientEmail,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
    public function failed(\Throwable $exception): void
    {
        Log::error('DisputeResolutionEmailJob failed permanently', [
            'order_id' => $this->orderId,
            'recipient' => $this->recipientEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}
