<?php

namespace App\Providers;

use App\Events\Admin\AdminCreated;
use App\Events\Admin\AdminUpdated;
use App\Events\User\AccountStatusChnage;
use App\Listeners\Admin\LogAdminActivity;
use App\Listeners\Admin\SendWelcomeEmail;
use App\Listeners\User\SendUserAccountStatusChangedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AdminCreated::class => [
            SendWelcomeEmail::class,
        ],
        AdminUpdated::class => [
            LogAdminActivity::class,
        ],
        AccountStatusChnage::class => [
            SendUserAccountStatusChangedEmail::class
        ],

        \App\Events\PaymentCompleted::class => [
            // \App\Listeners\SendPaymentNotification::class,
            // \App\Listeners\UpdateUserStatistics::class,
        ],

        \App\Events\PaymentFailed::class => [
            // \App\Listeners\SendPaymentFailedNotification::class,
        ],

        // Order Events
        \App\Events\OrderCompleted::class => [
            // \App\Listeners\SendOrderCompletedNotification::class,
        ],

        \App\Events\OrderPartiallyPaid::class => [
            // Add listeners if needed
        ],

    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
