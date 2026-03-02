<?php

namespace App\Jobs\Payment;

use App\Enums\EmailTemplateEnum;
use App\Mail\Payment\PaymentSuccessMail;
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

class SendPaymentSuccessEmailJob implements ShouldQueue
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
            $template = EmailTemplate::where('key', EmailTemplateEnum::PAYMENT_SUCCESS_BUYER->value)->first();

            if ($template === null) {
                Log::warning('Payment success email skipped: no template found', [
                    'order_id' => $this->orderId,
                    'recipient' => $this->recipientEmail,
                ]);

                return;
            }

            Mail::to($this->recipientEmail)
                ->send(new PaymentSuccessMail($order, $payment, $template));

            Log::info('Payment success email sent', [
                'order_id' => $order->order_id,
                'payment_id' => $payment->payment_id,
                'recipient' => $this->recipientEmail,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment success email', [
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
        Log::error('SendPaymentSuccessEmailJob failed permanently', [
            'order_id' => $this->orderId,
            'payment_id' => $this->paymentId,
            'recipient' => $this->recipientEmail,
            'error' => $exception->getMessage(),
        ]);
    }
}
