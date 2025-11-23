<?php

if (!function_exists('app_setting')) {
    /**
     * Helper to get application settings
     */
    function app_setting(string $key, mixed $default = null): mixed
    {
        return app(\App\Services\SettingsService::class)->get($key, $default);
    }
}

if (!function_exists('site_name')) {
    function site_name()
    {
        return app_setting('app_name', config('app.name', 'Laravel Application'));
    }
}

if (!function_exists('short_name')) {
    function short_name()
    {
        return app_setting('short_name', config('app.short_name', 'LA'));
    }
}

if (!function_exists('site_tagline')) {
    function site_tagline()
    {
        return app_setting('app_tagline', config('app.tagline', 'Laravel Application Tagline'));
    }
}
