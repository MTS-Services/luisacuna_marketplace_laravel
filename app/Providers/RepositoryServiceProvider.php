<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\GameRepository;
use App\Repositories\Eloquent\RankRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\AuditRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CurrencyRepository;
use App\Repositories\Eloquent\LanguageRepository;
use App\Repositories\Eloquent\PageViewRepository;

use App\Repositories\Eloquent\PermissionRepository;


use App\Repositories\Eloquent\AchievementRepository;
use App\Repositories\Eloquent\ProductTypeRepository;
use App\Repositories\Eloquent\GamePlatformRepository;
use App\Repositories\Contracts\GameRepositoryInterface;
use App\Repositories\Contracts\RankRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\AuditRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\PageViewRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\AchievementRepositoryInterface;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;

use App\Repositories\Contracts\GameServerRepositoryInterface;
use App\Repositories\Eloquent\GameServerRepository;

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
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        );


        // Game  Repository
        $this->app->bind(
            GameRepositoryInterface::class,
            GameRepository::class,
        );

        //GamePlatform Repository
        $this->app->bind(
            GamePlatformRepositoryInterface::class,
            GamePlatformRepository::class
        );


        //Game Server Repository
        $this->app->bind(
           
            GameServerRepositoryInterface::class,
            GameServerRepository::class,
          
        );

        // Rank

        $this->app->bind(
            RankRepositoryInterface::class,
            RankRepository::class,
        );

        $this->app->bind(
            LanguageRepositoryInterface::class,
            LanguageRepository::class
        );
        $this->app->bind(
            AuditRepositoryInterface::class,
            AuditRepository::class
        );
        $this->app->bind(
            CurrencyRepositoryInterface::class,
            CurrencyRepository::class
        );
        $this->app->bind(
            ProductTypeRepositoryInterface::class,
            ProductTypeRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            PageViewRepositoryInterface::class,
            PageViewRepository::class
        );
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        $this->app->bind(
            AchievementRepositoryInterface::class,
            AchievementRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
