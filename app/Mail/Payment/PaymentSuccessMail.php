<?php

namespace App\Mail\Payment;

use App\Models\EmailTemplate;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $template;
    public $subject;
    protected array $replacements;

    public function __construct(
        public Order $order,
        public Payment $payment,
        public EmailTemplate $emailTemplate
    ) {
        // Ensure relationships are loaded
        $this->order->loadMissing('user');

        $this->replacements = [
            '{buyer_name}' => $this->order->user?->full_name ?? $this->order->user?->first_name ?? 'Customer',
            '{order_id}' => $this->order->order_id,
            '{payment_gateway}' => $this->payment->payment_gateway,
            '{currency}' => number_format($this->payment->amount, 2),
            '{payment_id}' => $this->payment->payment_id,
            '{paid_at}' => optional($this->payment->paid_at)->format('M d, Y • h:i A') ?? now()->format('M d, Y • h:i A'),
            '{order_detail_link}' => route('user.order.detail', $this->order->order_id),
            '{app_name}' => config('app.name'),
            '{date_time}' => now()->format('M d, Y • h:i A'),
        ];

        $this->template = str_replace(array_keys($this->replacements), array_values($this->replacements), $emailTemplate->template);
        $this->subject = str_replace(array_keys($this->replacements), array_values($this->replacements), $emailTemplate->subject);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment.payment-success',
            with: [
                'template' => $this->template,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
