<?php

namespace App\Listeners\User;

use App\Enums\UserAccountStatus;
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

        if ($event->newStatus === UserAccountStatus::SUSPENDED->value) {

            Mail::to($event->user->email)->send(
                new UserAccountStatusChanged(
                    $event->user,
                    $event->oldStatus,
                    $event->newStatus,
                    $event->reason
                )
            );

            Log::info('Account Suspended email sent', [
                'user' => $event->user->email,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus,
                'reason' => $event->reason
            ]);
        } else {
            // Account status change email log 
            Log::info('Account Status Changed (No email sent)', [
                'user' => $event->user->email,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus,
            ]);
        }






        // Mail::to($event->user->email)->send(new UserAccountStatusChanged($event->user, $event->oldStatus, $event->newStatus, $event->reason));
        // Log::info('Account Status Change email sent', [
        //     'user' => $event->user->email,
        //     'old_status' => $event->oldStatus,
        //     'new_status' => $event->newStatus,
        //     'reason' => $event->reason
        // ]);


    }
}
