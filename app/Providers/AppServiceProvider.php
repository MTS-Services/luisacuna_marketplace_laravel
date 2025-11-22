<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\DeepLTranslationService;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::before(function ($admin, $ability) {
            return $admin->hasRole('Super Admin') ? true : null;
        });

        Blade::componentNamespace('App\View\Components\Layout\Admin', 'admin');
        Blade::componentNamespace('App\View\Components\Layout\User', 'user');
        Blade::componentNamespace('App\View\Components\Layout\Frontend', 'frontend');
        Blade::componentNamespace('App\View\Components\Layout\Language', 'language');
    }
}
