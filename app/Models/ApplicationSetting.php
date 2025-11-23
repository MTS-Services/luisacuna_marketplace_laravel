<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    // Theme modes
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';
    const THEME_SYSTEM = 'system';

    // Registration
    const REGISTRATION_ENABLED = 1;
    const REGISTRATION_DISABLED = 0;
    const APPROVAL_AUTO = 0;
    const APPROVAL_MANUAL = 1;

    // Environment
    const ENV_LOCAL = 'local';
    const ENV_PRODUCTION = 'production';

    // Toggles (0/1)
    const ENABLED = 1;
    const DISABLED = 0;

    // Date formats
    const DATE_DMY = 'd/m/Y';
    const DATE_MDY = 'm/d/Y';
    const DATE_YMD = 'Y-m-d';

    // Time formats
    const TIME_12H = 'h:i A';
    const TIME_24H = 'H:i';

    protected $fillable = ['key', 'value'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get options for dropdowns
     */
    public static function getThemeOptions(): array
    {
        return [
            self::THEME_LIGHT => __('Light'),
            self::THEME_DARK => __('Dark'),
            self::THEME_SYSTEM => __('System'),
        ];
    }

    public static function getEnvironmentOptions(): array
    {
        return [
            self::ENV_LOCAL => __('Local/Development'),
            self::ENV_PRODUCTION => __('Production'),
        ];
    }

    public static function getToggleOptions(): array
    {
        return [
            self::ENABLED => __('Enabled'),
            self::DISABLED => __('Disabled'),
        ];
    }

    public static function getDateFormatOptions(): array
    {
        return [
            self::DATE_DMY => 'd/m/Y (31/12/2024)',
            self::DATE_MDY => 'm/d/Y (12/31/2024)',
            self::DATE_YMD => 'Y-m-d (2024-12-31)',
        ];
    }

    public static function getTimeFormatOptions(): array
    {
        return [
            self::TIME_12H => __('12 Hour (02:30 PM)'),
            self::TIME_24H => __('24 Hour (14:30)'),
        ];
    }
}
