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

class AdminPaymentNotificationMail extends Mailable implements ShouldQueue
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
            subject: 'New Payment Received - Order #' . $this->order->order_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment.admin-payment-notification',
            with: [
                'order' => $this->order,
                'payment' => $this->payment,
                'buyerName' => $this->order->user?->full_name ?? $this->order->user?->first_name ?? 'Unknown',
                'buyerUsername' => $this->order->user?->username ?? 'unknown',
                'buyerEmail' => $this->order->user?->email ?? 'N/A',
                'sellerName' => $this->order->source?->user?->full_name ?? $this->order->source?->user?->first_name ?? 'Seller',
                'sellerUsername' => $this->order->source?->user?->username ?? 'seller',
                'sellerEmail' => $this->order->source?->user?->email ?? 'N/A',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
