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
        $this->order->loadMissing(['user', 'source.user', 'source']);

        $productName = 'N/A';
        if ($this->order->source !== null) {
            $productName = method_exists($this->order->source, 'translatedName')
                ? $this->order->source->translatedName(app()->getLocale())
                : ($this->order->source->name ?? 'N/A');
        }

        $sellerName = $this->order->source?->user?->full_name
            ?? $this->order->source?->user?->first_name
            ?? 'Seller';

        $paidAtFormatted = optional($this->payment->paid_at)->format('M d, Y • h:i A')
            ?? now()->format('M d, Y • h:i A');
        $dateTimeFormatted = now()->format('M d, Y • h:i A');

        $this->replacements = [
            '{{buyer_name}}' => $this->order->user?->full_name ?? $this->order->user?->first_name ?? 'Customer',
            '{{seller_name}}' => $sellerName,
            '{{order_id}}' => $this->order->order_id,
            '{{product_name}}' => $productName,
            '{{price}}' => number_format((float) ($this->order->grand_total ?? $this->payment->amount), 2),
            '{{currency}}' => $this->payment->currency ?? $this->order->currency ?? config('app.currency', 'USD'),
            '{{paid_at}}' => $paidAtFormatted,
            '{{app_name}}' => config('app.name'),
            '{{date_time}}' => $dateTimeFormatted,
            '{{payment_gateway}}' => $this->payment->payment_gateway,
            '{{payment_id}}' => $this->payment->payment_id,
            '{{order_detail_link}}' => route('user.order.detail', $this->order->order_id),
        ];

        $this->template = str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $this->emailTemplate->template
        );
        $this->subject = str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $this->emailTemplate->subject
        );
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
