<?php

namespace App\Jobs\Payment;

use App\Enums\EmailTemplateEnum;
use App\Mail\PaymentSuccessMail;
use App\Models\EmailTemplate;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentFailedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public array $backoff = [10, 30, 60];

    public function __construct(
        public int $orderId,
        public int $paymentId,
        public string $recipientEmail
    ) {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        $template = null;

        try {
            $order = Order::with(['user', 'source.user', 'source'])->findOrFail($this->orderId);
            $payment = Payment::findOrFail($this->paymentId);

            // Only send for failed or cancelled payments
            if (! $payment->status?->value || ! in_array($payment->status->value, ['failed', 'cancelled'], true)) {
                Log::info('Payment failed email skipped: payment not failed/cancelled', [
                    'order_id' => $this->orderId,
                    'payment_status' => $payment->status?->value,
                ]);

                return;
            }

            $template = EmailTemplate::where('key', EmailTemplateEnum::PAYMENT_CANCELED_BUYER->value)->first();

            if ($template === null) {
                Log::warning('Payment failed email skipped: no template found', [
                    'order_id' => $this->orderId,
                    'recipient' => $this->recipientEmail,
                ]);

                return;
            }

            // Ensure we only send once per payment
            $metadata = $payment->metadata ?? [];
            if (! empty($metadata['failed_email_sent'])) {
                Log::info('Payment failed email already sent, skipping', [
                    'order_id' => $this->orderId,
                    'payment_id' => $this->paymentId,
                ]);

                return;
            }

            Mail::to($this->recipientEmail)
                ->send(new PaymentSuccessMail($order, $payment, $template));

            $metadata['failed_email_sent'] = true;
            $payment->metadata = $metadata;
            $payment->save();

            Log::info('Payment failed email sent', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->payment_id,
                'recipient' => $this->recipientEmail,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment failed email', [
                'order_id' => $this->orderId,
                'payment_id' => $this->paymentId,
                'recipient' => $this->recipientEmail,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendPaymentFailedEmailJob failed permanently', [
            'order_id' => $this->orderId,
            'payment_id' => $this->paymentId,
            'recipient' => $this->recipientEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}
