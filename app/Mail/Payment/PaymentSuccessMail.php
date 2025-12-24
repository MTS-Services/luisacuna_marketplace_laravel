<?php

namespace App\Mail\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    public function __construct(
        public Order $order,
        public Payment $payment
    ) {
        // Ensure relationships are loaded
        $this->order->loadMissing('user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Successful - Order #' . $this->order->order_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment.payment-success',
            with: [
                'order' => $this->order,
                'payment' => $this->payment,
                'buyerName' => $this->order->user?->full_name ?? $this->order->user?->first_name ?? 'Customer',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
