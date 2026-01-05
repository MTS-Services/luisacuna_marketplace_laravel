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

if (!function_exists('auto_translate')) {
    function auto_translate()
    {
        return app_setting('auto_translate', config('translation.auto_translate', false));
    }
}

if (!function_exists('timezone')) {
    function timezone()
    {
        return app_setting('timezone', config('app.timezone', 'UTC'));
    }
}
if (!function_exists('environment')) {
    function environment()
    {
        return app_setting('environment', config('app.environment', 'production'));
    }
}
if (!function_exists('app_debug')) {
    function app_debug()
    {
        return app_setting('app_debug', config('app.debug', false));
    }
}

if (!function_exists('date_format')) {
    function date_format()
    {
        return app_setting('date_format', config('app.date_format', 'Y-m-d'));
    }
}

if (!function_exists('time_format')) {
    function time_format()
    {
        return app_setting('time_format', config('app.time_format', 'H:i:s'));
    }
}
if (!function_exists('theme_mode')) {
    function theme_mode()
    {
        return app_setting('theme_mode', config('app.theme_mode', 'system'));
    }
}
if (!function_exists('app_logo')) {
    function app_logo()
    {
        return app_setting('app_logo', config('app.app_logo', 'laravel-2_ywme21'));
    }
}
if (!function_exists('app_favicon')) {
    function app_favicon()
    {
        return app_setting('favicon', config('app.favicon', asset('assets/default/favicon.ico')));
    }
}
