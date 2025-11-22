<?php

namespace App\Listeners\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Events\User\AccountStatusChnage;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\User\UserAccountStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserAccountStatusChangedEmail implements ShouldQueue
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AccountStatusChnage $event): void
    {

        // Mail::to($event->user->email)->send(new UserAccountStatusChanged(
        //     $event->user,
        //     $event->oldStatus,
        //     $event->newStatus,
        //     $event->reason
        // ));

        Mail::to($event->user->email)->send(new UserAccountStatusChanged($event->user, $event->oldStatus, $event->newStatus, $event->reason));

        Log::info('Account Status Change email sent', [
            'user' => $event->user->email,
            'old_status' => $event->oldStatus,
            'new_status' => $event->newStatus,
            'reason' => $event->reason
        ]);
        // Send Account Status Chnage email logic here
        // Log::info('Account Status Chnage email sent to: ' . $event->user->email);

        // Example:
        // Mail::to($event->user->email)->send(new AccountStatusChangedMail($event->user));
    }
}
