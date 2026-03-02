<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DisputeResolutionEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public EmailTemplate $emailTemplate;

    public function __construct(public Order $order, public string $userName, EmailTemplate $emailTemplate)
    {
        //

        $this->emailTemplate = $emailTemplate;

        $replacements = [
            '{{user_name}}' => $this->userName,
            '{{order_id}}' => (string) ($this->order?->order_id ?? ''),
            '{{dispute_reason}}' => (string) ($this->order?->disputes?->reason ?? ''),
            '{{price}}' => (string) ($this->order?->grand_total ?? ''),
            '{{dispute_url}}' => route('user.order.detail', $this->order?->order_id ?? ''),
            '{{app_name}}' => config('app.name'),
        ];
        $this->emailTemplate->template = str_replace(array_keys($replacements), array_values($replacements), $this->emailTemplate->template);
        $this->emailTemplate->subject = str_replace(array_keys($replacements), array_values($replacements), $this->emailTemplate->subject);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailTemplate->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.dispute-resolution',
            with: [
                'template' => $this->emailTemplate->template,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
