<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use App\Models\ApplicationSetting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ApplicationSettings extends Form
{
    // General settings
    public ?string $app_name = null;
    public ?string $short_name = null;
    public ?string $timezone = null;
    public ?string $date_format = null;
    public ?string $time_format = null;
    public ?string $theme_mode = null;
    
    // File uploads
    public $favicon = null;
    public $app_logo = null;
    
    // Registration settings
    public $public_registration = null;
    public $registration_approval = null;
    
    // Environment settings
    public ?string $environment = null;
    public $app_debug = null;
    public $debugbar = null;
    public $auto_translate = null;
    
    // Database settings
    public ?string $database_driver = null;
    public ?string $database_host = null;
    public ?string $database_port = null;
    public ?string $database_name = null;
    public ?string $database_username = null;
    public ?string $database_password = null;
    
    // SMTP settings
    public ?string $smtp_driver = null;
    public ?string $smtp_host = null;
    public ?string $smtp_port = null;
    public ?string $smtp_encryption = null;
    public ?string $smtp_username = null;
    public ?string $smtp_password = null;
    public ?string $smtp_from_address = null;
    public ?string $smtp_from_name = null;

    public function rules(): array
    {
        return [
            'app_name' => 'nullable|string|min:3|max:255',
            'short_name' => 'nullable|string|min:2|max:255',
            'timezone' => 'nullable|string|max:255',
            'date_format' => ['nullable', 'string', Rule::in([
                ApplicationSetting::DATE_FORMAT_ONE,
                ApplicationSetting::DATE_FORMAT_TWO,
                ApplicationSetting::DATE_FORMAT_THREE,
            ])],
            'time_format' => ['nullable', 'string', Rule::in([
                ApplicationSetting::TIME_FORMAT_12,
                ApplicationSetting::TIME_FORMAT_24,
            ])],
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,ico|max:2048',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'theme_mode' => ['nullable', 'string', Rule::in([
                ApplicationSetting::THEME_MODE_LIGHT,
                ApplicationSetting::THEME_MODE_DARK,
                ApplicationSetting::THEME_MODE_SYSTEM,
            ])],
            // 'public_registration' => ['nullable', Rule::in([
            //     ApplicationSetting::ALLOW_PUBLIC_REGISTRATION,
            //     ApplicationSetting::DENY_PUBLIC_REGISTRATION,
            // ])],
            // 'registration_approval' => ['nullable', Rule::in([
            //     ApplicationSetting::REGISTRATION_APPROVAL_AUTO,
            //     ApplicationSetting::REGISTRATION_APPROVAL_MANUAL,
            // ])],
            'environment' => ['nullable', 'string', Rule::in([
                ApplicationSetting::ENVIRONMENT_DEVELOPMENT,
                ApplicationSetting::ENVIRONMENT_PRODUCTION,
            ])],
            'app_debug' => ['nullable', Rule::in([
                ApplicationSetting::APP_DEBUG_TRUE,
                ApplicationSetting::APP_DEBUG_FALSE,
            ])],
            'debugbar' => ['nullable', Rule::in([
                ApplicationSetting::ENABLE_DEBUGBAR,
                ApplicationSetting::DISABLE_DEBUGBAR,
            ])],
            'auto_translate' => ['nullable', Rule::in([
                ApplicationSetting::ENABLE_AUTO_TRANSLATE,
                ApplicationSetting::DISABLE_AUTO_TRANSLATE,
            ])],
            // 'database_driver' => ['nullable', 'string', Rule::in([
            //     ApplicationSetting::DATABASE_DRIVER_MYSQL,
            //     ApplicationSetting::DATABASE_DRIVER_PGSQL,
            //     ApplicationSetting::DATABASE_DRIVER_SQLITE,
            //     ApplicationSetting::DATABASE_DRIVER_SQLSRV,
            // ])],
            // 'database_host' => 'nullable|string|max:255',
            // 'database_port' => 'nullable|string|max:10',
            // 'database_name' => 'nullable|string|max:255',
            // 'database_username' => 'nullable|string|max:255',
            // 'database_password' => 'nullable|string|max:255',
            // 'smtp_driver' => ['nullable', 'string', Rule::in([
            //     ApplicationSetting::SMTP_DRIVER_MAILER,
            //     ApplicationSetting::SMTP_DRIVER_MAILGUN,
            //     ApplicationSetting::SMTP_DRIVER_SES,
            //     ApplicationSetting::SMTP_DRIVER_POSTMARK,
            //     ApplicationSetting::SMTP_DRIVER_SENDMAIL,
            // ])],
            // 'smtp_host' => 'nullable|string|max:255',
            // 'smtp_port' => 'nullable|string|max:10',
            // 'smtp_encryption' => ['nullable', 'string', Rule::in([
            //     ApplicationSetting::SMTP_ENCRYPTION_TLS,
            //     ApplicationSetting::SMTP_ENCRYPTION_SSL,
            //     ApplicationSetting::SMTP_ENCRYPTION_NONE,
            // ])],
            // 'smtp_username' => 'nullable|string|max:255',
            // 'smtp_password' => 'nullable|string|max:255',
            // 'smtp_from_address' => 'nullable|email|max:255',
            // 'smtp_from_name' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'app_name.min' => 'App name must be at least 3 characters.',
            'app_logo.max' => 'Logo must not exceed 2MB.',
            'favicon.max' => 'Favicon must not exceed 2MB.',
        ];
    }

    public function save(): bool
    {
        $validated = $this->validate();
        try {
            foreach ($validated as $key => $value) {
                // Skip null/empty values except for explicit false/0 values
                if (is_null($value) || $value === '') {
                    continue;
                }

                // Handle file uploads
                // if (in_array($key, ['app_logo', 'favicon']) && is_object($value)) {
                //     $value = $this->handleFileUpload($value, $key);
                //     if (!$value) continue;
                // }

                // Get corresponding ENV key
                $envKey = $this->getEnvKey($key);

                // Save to database and optionally update .env
                ApplicationSetting::set($key, $value, $envKey);                
            }

            // Clear all caches
            ApplicationSetting::clearCache();
            ApplicationSetting::clearConfigCache();

            return true;

        } catch (\Exception $e) {
            Log::error('Settings save error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle file upload
     */
    protected function handleFileUpload($file, string $key): ?string
    {
        try {
            if (app()->bound('App\Http\Traits\FileManagementTrait')) {
                return app('App\Http\Traits\FileManagementTrait')
                    ->handleFileUpload($file, 'application_settings', $key);
            }

            // Fallback: Simple file storage
            $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('application_settings', $filename, 'public');
            
            return 'storage/' . $path;

        } catch (\Exception $e) {
            Log::error("File upload error for {$key}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get ENV key mapping
     */
    protected function getEnvKey(string $settingKey): ?string
    {
        $map = [
            // Application
            'app_name' => 'APP_NAME',
            'timezone' => 'TIMEZONE',
            'environment' => 'APP_ENV',
            'app_debug' => 'APP_DEBUG',
            'debugbar' => 'DEBUGBAR_ENABLED',
            'auto_translate' => 'AUTO_TRANSLATE',
            
            // Database
            'database_driver' => 'DB_CONNECTION',
            'database_host' => 'DB_HOST',
            'database_port' => 'DB_PORT',
            'database_name' => 'DB_DATABASE',
            'database_username' => 'DB_USERNAME',
            'database_password' => 'DB_PASSWORD',
            
            // Mail
            'smtp_driver' => 'MAIL_MAILER',
            'smtp_host' => 'MAIL_HOST',
            'smtp_port' => 'MAIL_PORT',
            'smtp_encryption' => 'MAIL_ENCRYPTION',
            'smtp_username' => 'MAIL_USERNAME',
            'smtp_password' => 'MAIL_PASSWORD',
            'smtp_from_address' => 'MAIL_FROM_ADDRESS',
            'smtp_from_name' => 'MAIL_FROM_NAME',
        ];

        return $map[$settingKey] ?? null;
    }
}