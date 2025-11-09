<?php

namespace App\Providers;

use App\Events\Admin\AdminCreated;
use App\Listeners\Admin\LogAdminActivity;
use App\Listeners\Admin\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AdminCreated::class => [
           SendWelcomeEmail::class,
        ],
        AdminCreated::class => [
            LogAdminActivity::class,
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