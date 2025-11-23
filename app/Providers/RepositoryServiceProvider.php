<?php

namespace App\Providers;

use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\TypeRepositoryInterface;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\Eloquent\TypeRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\GameRepository;
use App\Repositories\Eloquent\RankRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\AuditRepository;
use App\Repositories\Eloquent\ServerRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\CurrencyRepository;
use App\Repositories\Eloquent\LanguageRepository;
use App\Repositories\Eloquent\PageViewRepository;
use App\Repositories\Eloquent\OfferItemRepository;
use App\Repositories\Eloquent\GameServerRepository;


use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\PlatformRepository;
use App\Repositories\Eloquent\ProductTypeRepository;
use App\Repositories\Eloquent\AchievementRepository;


use App\Repositories\Contracts\GameRepositoryInterface;
use App\Repositories\Contracts\RankRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\AuditRepositoryInterface;
use App\Repositories\Eloquent\AchievementTypeRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\PageViewRepositoryInterface;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\AchievementRepositoryInterface;
use App\Repositories\Contracts\ProductTypeRepositoryInterface;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;
use App\Repositories\Contracts\GameRarityRepositoryInterface;
use App\Repositories\Contracts\GameServerRepositoryInterface;
use App\Repositories\Contracts\GameTagRepositoryInterface;
use App\Repositories\Contracts\GameTypeRepositoryInterface;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use App\Repositories\Contracts\ServerRepositoryInterface;
use App\Repositories\Contracts\OfferItemRepositoryInterface;
use App\Repositories\Contracts\RarityRepositoryInterface;
use App\Repositories\Eloquent\GamePlatformRepository;
use App\Repositories\Eloquent\GameRarityRepository;
use App\Repositories\Eloquent\GameTagRepository;
use App\Repositories\Eloquent\GameTypeRepository;
use App\Repositories\Eloquent\RaritytRepository;

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
        // Category Repository
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        );


        // Game  Repository
        $this->app->bind(
            GameRepositoryInterface::class,
            GameRepository::class,
        );

        //Platform Repository
        $this->app->bind(
            PlatformRepositoryInterface::class,
            PlatformRepository::class
        );


        // Server Repository
        $this->app->bind(

            ServerRepositoryInterface::class,
            ServerRepository::class,

        );

        // Game Server Repository
        $this->app->bind(

            GameServerRepositoryInterface::class,
            GameServerRepository::class,
        );


        // Game Tag Repository End
          $this->app->bind(
            GameTagRepositoryInterface::class,
            GameTagRepository::class,
        );

        // Game Type Repository End
          $this->app->bind(
            GameTypeRepositoryInterface::class,
            GameTypeRepository::class,
        );

        // Game Platform Repository End
          $this->app->bind(
            GamePlatformRepositoryInterface::class,
            GamePlatformRepository::class,
        );

        // Game Platform Repository End
          $this->app->bind(
            GameRarityRepositoryInterface::class,
            GameRarityRepository::class,
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
            AchievementTypeRepositoryInterface::class,
            AchievementTypeRepository::class
        );
        $this->app->bind(
            AchievementRepositoryInterface::class,
            AchievementRepository::class
        );
        $this->app->bind(
            OfferItemRepositoryInterface::class,
            OfferItemRepository::class
        );
        $this->app->bind(
            RarityRepositoryInterface::class,
            RaritytRepository::class
        );
        $this->app->bind(
            TypeRepositoryInterface::class,
            TypeRepository::class
        );
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
