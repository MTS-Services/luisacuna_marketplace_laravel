<?php

namespace App\Services;

use App\Models\ApplicationSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class SettingsService
{
    /**
     * Get a single setting value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = ApplicationSetting::where('key', $key)->first();
        return $setting?->value ?? $default;
    }

    /**
     * Get multiple settings at once
     */
    public function getMany(array $keys): array
    {
        $settings = ApplicationSetting::whereIn('key', $keys)
            ->pluck('value', 'key')
            ->toArray();

        return array_merge(
            array_fill_keys($keys, null),
            $settings
        );
    }

    /**
     * Save a single setting
     */
    public function set(string $key, mixed $value): bool
    {
        try {
            ApplicationSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            return true;
        } catch (Exception $e) {
            Log::error("Failed to save setting '{$key}': {$e->getMessage()}", [
                'key' => $key,
                'exception' => $e
            ]);
            return false;
        }
    }

    /**
     * Save multiple settings in a single transaction
     */
    public function saveMany(array $data): bool
    {
        try {
            DB::transaction(function () use ($data) {
                foreach ($data as $key => $value) {
                    if ($value === null) {
                        continue;
                    }

                    ApplicationSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            });

            return true;
        } catch (Exception $e) {
            Log::error('Failed to save multiple settings', [
                'keys' => array_keys($data),
                'exception' => $e
            ]);
            return false;
        }
    }

    /**
     * Handle file upload for settings
     */
    public function uploadFile(UploadedFile $file, string $key): ?string
    {
        try {
            $timestamp = time();
            $originalName = $file->getClientOriginalName();
            $fileName = "IMX-{$key}-{$timestamp}-{$originalName}";

            $path = $file->storeAs('settings', $fileName, 'public');

            return $path ?: null;
        } catch (Exception $e) {
            Log::error("File upload failed for '{$key}'", [
                'key' => $key,
                'exception' => $e
            ]);
            return null;
        }
    }

    /**
     * Delete an old file from storage
     */
    public function deleteFile(?string $path): bool
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return false;
        }

        try {
            return Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            Log::error("Failed to delete file: {$path}", [
                'path' => $path,
                'exception' => $e
            ]);
            return false;
        }
    }

    /**
     * Delete a setting
     */
    public function delete(string $key): bool
    {
        try {
            return ApplicationSetting::where('key', $key)->delete() > 0;
        } catch (Exception $e) {
            Log::error("Failed to delete setting '{$key}'", [
                'key' => $key,
                'exception' => $e
            ]);
            return false;
        }
    }

    /**
     * Check if a setting exists
     */
    public function has(string $key): bool
    {
        return ApplicationSetting::where('key', $key)->exists();
    }

    /**
     * Get all settings as key-value pairs
     */
    public function all(): array
    {
        return ApplicationSetting::pluck('value', 'key')->toArray();
    }
}
