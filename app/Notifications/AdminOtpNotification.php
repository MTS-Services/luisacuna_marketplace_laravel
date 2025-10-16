<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class AdminOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $otp
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        Log::info("Sending OTP email to: " . $notifiable->email. " with OTP: " . $this->otp);
        return (new MailMessage)
            ->subject('Your Admin Verification Code')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your verification code is:')
            ->line('**' . $this->otp . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not attempt to login, please ignore this email or contact support.');
    }
}