<?php

namespace App\Providers;

use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use App\Repositories\Contracts\GameRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\GameCategoryRepository;
use App\Repositories\Eloquent\GameRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

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
        // Game Category Repository
        $this->app->bind(
            GameCategoryRepositoryInterface::class,
           GameCategoryRepository::class,
        );

        // Game Category Repository
        $this->app->bind(
            GameRepositoryInterface::class,
           GameRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
