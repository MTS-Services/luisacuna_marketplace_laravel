<?php

namespace App\Providers;

use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\Eloquent\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}