<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\DeepLTranslationService;
use App\Services\EnvEditorService;
use App\Services\PaymentService;
use App\Services\SettingsService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Observers\OrderObserver;
use App\Observers\PaymentObserver;
use App\Observers\TransactionObserver;
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

        // Register SettingsService as singleton
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService(
                $app->make(EnvEditorService::class)
            );
        });

        $this->app->singleton(PaymentService::class);

        // Register Model Observers
        Order::observe(OrderObserver::class);
        Payment::observe(PaymentObserver::class);
        Transaction::observe(TransactionObserver::class);

        // Enable query logging in development
        if (config('app.debug')) {
            DB::listen(function ($query) {
                if ($query->time > 100) { // Log slow queries (>100ms)
                    Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms',
                    ]);
                }
            });
        }
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
