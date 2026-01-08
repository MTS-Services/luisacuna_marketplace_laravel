<?php

namespace App\Providers;

use App\Events\Admin\AdminCreated;
use App\Events\Admin\AdminUpdated;
use App\Events\PaymentSuccessEvent;
use App\Events\User\AccountStatusChnage;
use App\Listeners\Admin\LogAdminActivity;
use App\Listeners\Admin\SendWelcomeEmail;
use App\Listeners\SendPaymentNotifications;
use App\Listeners\User\SendUserAccountStatusChangedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

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
        PaymentSuccessEvent::class => [
            SendPaymentNotifications::class,
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
