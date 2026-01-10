<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\DeepLTranslationService;
use App\Services\EnvEditorService;
use App\Services\SettingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register DeepL Translation Service as singleton
        $this->app->singleton(DeepLTranslationService::class, function ($app) {
            return new DeepLTranslationService();
        });

        // Register EnvEditorService as singleton
        $this->app->singleton(EnvEditorService::class, function ($app) {
            return new EnvEditorService();
        });

        $this->app->singleton(CloudinaryService::class, function ($app) {
            return new CloudinaryService();
        });

        // Register SettingsService as singleton
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService(
                $app->make(EnvEditorService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config([
            'debugbar.enabled' => app_setting('app_debug', false),
        ]);

        Gate::before(function ($admin, $ability) {
            return $admin->hasRole('Super Admin') ? true : null;
        });
        Blade::componentNamespace('App\View\Components\Layout\Admin', 'admin');
        Blade::componentNamespace('App\View\Components\Layout\User', 'user');
        Blade::componentNamespace('App\View\Components\Layout\Frontend', 'frontend');
        Blade::componentNamespace('App\View\Components\Layout\Language', 'language');
    }
}
