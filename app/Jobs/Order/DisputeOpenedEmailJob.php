<?php

namespace App\Jobs\Order;

use App\Mail\DisputeEmail;
use App\Models\EmailTemplate;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DisputeOpenedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $orderId,
        public string $recipientEmail,
        public string $userName,
        public string $emailTemplateKey
    ) {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        try {
            $order = Order::with(['user', 'source.user', 'disputes'])->findOrFail($this->orderId);

            $emailTemplate = EmailTemplate::where('key', $this->emailTemplateKey)->firstOrFail();

            Mail::to($this->recipientEmail)
                ->send(new DisputeEmail($order, $this->userName, $emailTemplate));

            Log::info('Dispute opened email sent', [
                'order_id' => $this->orderId,
                'recipient' => $this->recipientEmail,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send dispute opened email', [
                'order_id' => $this->orderId ?? 'unknown',
                'recipient' => $this->recipientEmail ?? 'unknown',
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('DisputeOpenedEmailJob failed permanently', [
            'order_id' => $this->orderId,
            'recipient' => $this->recipientEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}

