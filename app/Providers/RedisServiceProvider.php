<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis;

class RedisServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Make sure Redis facade is available
        class_alias(Redis::class, 'Redis');
    }

    public function boot(): void
    {
        // Redis is ready to use
    }
}
