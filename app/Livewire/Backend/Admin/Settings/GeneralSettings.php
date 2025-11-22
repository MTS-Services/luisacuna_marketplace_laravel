<?php

namespace App\Livewire\Backend\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Services\SettingsService;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Log;

class GeneralSettings extends Component
{
    use WithFileUploads;

    // Form fields
    #[Validate('nullable|string|min:2|max:255')]
    public string $app_name = '';

    #[Validate('nullable|string|min:2|max:100')]
    public string $short_name = '';

    #[Validate('nullable|string|max:100')]
    public string $timezone = '';

    #[Validate('nullable|string')]
    public string $date_format = '';

    #[Validate('nullable|string')]
    public string $time_format = '';

    #[Validate('nullable|string')]
    public string $theme_mode = '';

    #[Validate('nullable|string')]
    public string $environment = '';

    #[Validate('nullable')]
    public $app_debug = 0;

    #[Validate('nullable')]
    public $debugbar = 0;

    #[Validate('nullable')]
    public $auto_translate = 0;

    #[Validate('nullable|image|max:2048')]
    public $app_logo = null;

    #[Validate('nullable|image|max:2048')]
    public $favicon = null;

    // Display data
    public array $timezones = [];
    public ?string $current_logo = null;
    public ?string $current_favicon = null;

    // Loading state
    public bool $saving = false;

    protected SettingsService $settingsService;

    public function boot(SettingsService $settingsService): void
    {
        $this->settingsService = $settingsService;
    }

    public function mount(): void
    {
        $this->loadTimezones();
        $this->loadSettings();
    }

    protected function loadTimezones(): void
    {
        $this->timezones = function_exists('availableTimezones')
            ? availableTimezones()
            : collect(timezone_identifiers_list())->map(fn($tz) => [
                'timezone' => $tz,
                'name' => $tz
            ])->toArray();
    }

    protected function loadSettings(): void
    {
        $settings = $this->settingsService->getMany([
            'app_name',
            'short_name',
            'timezone',
            'date_format',
            'time_format',
            'theme_mode',
            'environment',
            'app_debug',
            'debugbar',
            'auto_translate',
            'app_logo',
            'favicon'
        ]);

        $this->app_name = $settings['app_name'] ?? config('app.name', '');
        $this->short_name = $settings['short_name'] ?? '';
        $this->timezone = $settings['timezone'] ?? config('app.timezone', 'UTC');
        $this->date_format = $settings['date_format'] ?? ApplicationSetting::DATE_DMY;
        $this->time_format = $settings['time_format'] ?? ApplicationSetting::TIME_24H;
        $this->theme_mode = $settings['theme_mode'] ?? ApplicationSetting::THEME_SYSTEM;
        $this->environment = $settings['environment'] ?? ApplicationSetting::ENV_LOCAL;
        $this->app_debug = (int)($settings['app_debug'] ?? 0);
        $this->debugbar = (int)($settings['debugbar'] ?? 0);
        $this->auto_translate = (int)($settings['auto_translate'] ?? 0);
        $this->current_logo = $settings['app_logo'] ?? null;
        $this->current_favicon = $settings['favicon'] ?? null;
    }

    public function save(): void
    {
        $this->validate();
        $this->saving = true;

        try {
            $data = [
                'app_name' => $this->app_name,
                'short_name' => $this->short_name,
                'timezone' => $this->timezone,
                'date_format' => $this->date_format,
                'time_format' => $this->time_format,
                'theme_mode' => $this->theme_mode,
                'environment' => $this->environment,
                'app_debug' => (int)$this->app_debug,
                'debugbar' => (int)$this->debugbar,
                'auto_translate' => (int)$this->auto_translate,
            ];

            // Handle logo upload
            if ($this->app_logo) {
                $logoPath = $this->settingsService->uploadFile($this->app_logo, 'app_logo');
                if ($logoPath) {
                    $data['app_logo'] = $logoPath;
                    $this->current_logo = $logoPath;
                }
            }

            // Handle favicon upload
            if ($this->favicon) {
                $faviconPath = $this->settingsService->uploadFile($this->favicon, 'favicon');
                if ($faviconPath) {
                    $data['favicon'] = $faviconPath;
                    $this->current_favicon = $faviconPath;
                }
            }

            // Save all settings
            $success = $this->settingsService->saveMany($data);

            if ($success) {
                // Reset file inputs
                $this->reset(['app_logo', 'favicon']);

                session()->flash('success', __('Settings saved successfully!'));
                $this->dispatch('settings-saved');
            } else {
                session()->flash('error', __('Failed to save settings. Please try again.'));
            }
        } catch (\Exception $e) {
            Log::error('Settings save error: ' . $e->getMessage());
            session()->flash('error', __('An error occurred. Please try again.'));
        } finally {
            $this->saving = false;
        }
    }

    public function resetForm(): void
    {
        $this->reset(['app_logo', 'favicon']);
        $this->loadSettings();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.backend.admin.settings.general-settings');
    }
}
