<?php

namespace App\Livewire\Backend\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use App\Services\SettingsService;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GeneralSettings extends Component
{
    use WithFileUploads;

    // Text Fields
    #[Validate('nullable|string|min:2|max:255')]
    public string $app_name = '';

    #[Validate('nullable|string|min:2|max:100')]
    public string $short_name = '';

    #[Validate('nullable|string|max:100')]
    public string $timezone = '';

    // Select Fields
    #[Validate('nullable|string')]
    public string $date_format = '';

    #[Validate('nullable|string')]
    public string $time_format = '';

    #[Validate('nullable|string')]
    public string $theme_mode = '';

    #[Validate('nullable|string')]
    public string $environment = '';

    // Boolean/Radio Fields (string for wire:model compatibility)
    #[Validate('nullable|in:0,1')]
    public string $app_debug = '0';

    #[Validate('nullable|in:0,1')]
    public string $auto_translate = '0';

    // Computed property for template reactivity
    public function updatedAppDebug($value): void
    {
        $this->app_debug = (string) $value;
    }

    public function updatedAutoTranslate($value): void
    {
        $this->auto_translate = (string) $value;
    }

    // File Uploads
    #[Validate('nullable|image|max:2048')]
    public $app_logo = null;

    #[Validate('nullable|image|max:2048')]
    public $favicon = null;

    // Display Properties
    public array $timezones = [];
    public ?string $current_logo = null;
    public ?string $current_favicon = null;
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
        if (function_exists('availableTimezones')) {
            $this->timezones = availableTimezones();
        } else {
            $this->timezones = collect(timezone_identifiers_list())
                ->map(fn($tz) => ['timezone' => $tz, 'name' => str_replace('_', ' ', $tz)])
                ->toArray();
        }
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
            'auto_translate',
            'app_logo',
            'favicon'
        ]);

        // Text fields
        $this->app_name = $settings['app_name'] ?? config('app.name', '');
        $this->short_name = $settings['short_name'] ?? '';
        $this->timezone = $settings['timezone'] ?? config('app.timezone', 'UTC');

        // Select fields
        $this->date_format = $settings['date_format'] ?? ApplicationSetting::DATE_DMY;
        $this->time_format = $settings['time_format'] ?? ApplicationSetting::TIME_24H;
        $this->theme_mode = $settings['theme_mode'] ?? ApplicationSetting::THEME_SYSTEM;
        $this->environment = $settings['environment'] ?? ApplicationSetting::ENV_LOCAL;

        // Boolean fields (cast to string for radio buttons)
        $this->app_debug = (string)($settings['app_debug'] ?? '0');
        $this->auto_translate = (string)($settings['auto_translate'] ?? '0');

        // File paths
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
                'auto_translate' => (int)$this->auto_translate,
            ];

            // Handle logo upload
            if ($this->app_logo) {
                $logoPath = $this->settingsService->uploadFile($this->app_logo, 'app_logo');
                if ($logoPath) {
                    if ($this->current_logo !== null) {
                        if (Storage::disk('public')->exists($this->current_logo)) {
                            Log::info('Deleting old app logo after upload: ' . $this->current_logo);
                            Storage::disk('public')->delete($this->current_logo);
                        }
                    }
                    $data['app_logo'] = $logoPath;
                    $this->current_logo = $logoPath;
                }
            }

            // Handle favicon upload
            if ($this->favicon) {
                $faviconPath = $this->settingsService->uploadFile($this->favicon, 'favicon');

                if ($faviconPath) {
                    if ($this->current_favicon !== null) {
                        if (Storage::disk('public')->exists($this->current_favicon)) {
                            Storage::disk('public')->delete($this->current_favicon);
                        }
                    }
                    $data['favicon'] = $faviconPath;
                    $this->current_favicon = $faviconPath;
                }
            }

            $success = $this->settingsService->saveMany($data);

            if ($success) {
                $this->reset(['app_logo', 'favicon']);
                session()->flash('success', __('Settings saved successfully!'));
                // $this->dispatch('settings-saved');
                Artisan::call('config:refresh');
                $this->redirectIntended(route('admin.as.general-settings'), navigate: true);
            } else {
                session()->flash('error', __('Failed to save settings. Please try again.'));
            }
        } catch (\Exception $e) {
            Log::error('General settings save failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
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
        session()->flash('success', __('Form has been reset.'));
    }

    #[Computed]
    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }

    #[Computed]
    public function hasDebugEnabled(): bool
    {
        return $this->app_debug === '1';
    }

    public function render()
    {
        return view('livewire.backend.admin.settings.general-settings');
    }
}
