<?php

namespace App\Services;

use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Support\Facades\Storage;

class SettingsService
{
    protected EnvEditorService $envEditor;

    // ENV key mappings
    protected array $envKeyMap = [
        'app_name' => 'APP_NAME',
        'timezone' => 'TIMEZONE',
        'environment' => 'APP_ENV',
        'app_debug' => 'APP_DEBUG',
        'debugbar' => 'DEBUGBAR_ENABLED',
        'auto_translate' => 'AUTO_TRANSLATE',
    ];

    public function __construct(EnvEditorService $envEditor)
    {
        $this->envEditor = $envEditor;
    }

    /**
     * Get a single setting
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = ApplicationSetting::where('key', $key)->first();
            return $setting?->value ?? $default;
        });
    }

    /**
     * Get multiple settings
     */
    public function getMany(array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key);
        }
        return $result;
    }

    /**
     * Save a single setting
     */
    public function set(string $key, mixed $value): bool
    {
        try {
            // Save to database
            ApplicationSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            // Update ENV if mapped
            if (isset($this->envKeyMap[$key])) {
                $this->envEditor->set($this->envKeyMap[$key], $value);
            }

            // Clear cache for this key
            Cache::forget("setting.{$key}");

            return true;
        } catch (Exception $e) {
            Log::error("Failed to save setting {$key}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save multiple settings at once
     */
    public function saveMany(array $data): bool
    {
        $envUpdates = [];

        try {
            foreach ($data as $key => $value) {
                // Skip null values (unchanged)
                if (is_null($value)) {
                    continue;
                }

                // Save to database
                ApplicationSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );

                // Collect ENV updates
                if (isset($this->envKeyMap[$key])) {
                    $envUpdates[$this->envKeyMap[$key]] = $value;
                }

                // Clear cache
                Cache::forget("setting.{$key}");
            }

            // Batch update ENV file
            if (!empty($envUpdates)) {
                $this->envEditor->updateMany($envUpdates);
            }

            // Clear config cache
            $this->clearConfigCache();

            return true;
        } catch (Exception $e) {
            Log::error('Failed to save settings: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle file upload for settings
     */
    public function uploadFile(UploadedFile $file, string $key): ?string
    {
        try {

            $prefix = 'IMX' . '-' . $key . '-' . time();
            $fileName = $prefix  . '-' . $file->getClientOriginalName();
            return Storage::disk('public')->putFileAs('settings', $file, $fileName);
        } catch (Exception $e) {
            Log::error("File upload failed for {$key}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Clear all settings cache
     */
    public function clearCache(): void
    {
        $settings = ApplicationSetting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting.{$setting->key}");
        }
    }

    /**
     * Clear Laravel config cache
     */
    public function clearConfigCache(): void
    {
        try {
            if (function_exists('opcache_reset')) {
                @opcache_reset();
            }

            Artisan::call('config:clear');
        } catch (Exception $e) {
            Log::warning('Could not clear config cache: ' . $e->getMessage());
        }
    }
}
