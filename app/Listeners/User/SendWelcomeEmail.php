<?php

namespace App\Listeners\User;

use App\Events\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    public function handle(UserCreated $event): void
    {
        Log::info('Sending welcome email to user', [
            'user_id' => $event->user->id,
            'email' => $event->user->email
        ]);

        // Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
    }
}
