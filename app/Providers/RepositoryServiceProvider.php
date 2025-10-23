<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\LanguageRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Admin Repository
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class,
        );
        // User Repository
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            LanguageRepositoryInterface::class, 
            LanguageRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
