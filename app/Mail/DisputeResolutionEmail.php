<?php

namespace App\Mail;

use App\Enums\EmailTemplateEnum;
use App\Models\EmailTemplate;
use App\Models\Order;
use App\Services\EmailTemplateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    public function __construct(public Order $order, public string $userName ,EmailTemplate $emailTemplate)
    {
        //

        $this->emailTemplate = $emailTemplate;

        $template =  str_replace('{{user_name}}', $this->userName, $this->emailTemplate->template);
        $template =  str_replace('{{order_id}}', $this->order?->order_id, $template);
        $template =  str_replace('{{dispute_reason}}', $this->order?->disputes?->reason, $template);
        $template =  str_replace('{{price}}', $this->order?->grand_total, $template);
        $template =  str_replace('{{dispute_url}}', route('user.order.detail', $this->order?->order_id), $template);
        $this->emailTemplate->template = $template;
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
                'template' => $this->emailTemplate->template , 
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
