<?php

namespace App\Providers;

use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            // Admin Repository
            AdminRepositoryInterface::class,
            AdminRepository::class,
            // User Repository
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
