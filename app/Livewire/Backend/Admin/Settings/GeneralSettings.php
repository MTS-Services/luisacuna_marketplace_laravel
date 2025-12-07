<?php

namespace App\Livewire\Backend\Admin\Settings;

use App\Models\ApplicationSetting;
use App\Services\SettingsService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralSettings extends Component
{
    use WithFileUploads, WithNotification;

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

    // Boolean/Radio Fields
    #[Validate('nullable|in:0,1')]
    public string $app_debug = '0';

    #[Validate('nullable|in:0,1')]
    public string $auto_translate = '0';

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

    public function updatedAppDebug($value): void
    {
        $this->app_debug = (string) $value;
    }

    public function updatedAutoTranslate($value): void
    {
        $this->auto_translate = (string) $value;
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

        $this->app_name = $settings['app_name'] ?? config('app.name', '');
        $this->short_name = $settings['short_name'] ?? '';
        $this->timezone = $settings['timezone'] ?? config('app.timezone', 'UTC');
        $this->date_format = $settings['date_format'] ?? ApplicationSetting::DATE_DMY;
        $this->time_format = $settings['time_format'] ?? ApplicationSetting::TIME_24H;
        $this->theme_mode = $settings['theme_mode'] ?? ApplicationSetting::THEME_SYSTEM;
        $this->environment = $settings['environment'] ?? ApplicationSetting::ENV_LOCAL;
        $this->app_debug = (string)($settings['app_debug'] ?? '0');
        $this->auto_translate = (string)($settings['auto_translate'] ?? '0');
        $this->current_logo = $settings['app_logo'];
        $this->current_favicon = $settings['favicon'];
    }

    public function save()
    {
        $this->validate();
        $this->saving = true;

        try {
            $data = $this->prepareSettingsData();

            // Handle file uploads
            $this->handleFileUpload('app_logo', $data);
            $this->handleFileUpload('favicon', $data);

            $success = $this->settingsService->saveMany($data);

            if ($success) {
                $this->reset(['app_logo', 'favicon']);
                // $this->success(__('Settings saved successfully!'));
                // session()->flash('success', 'Settings saved successfully!');
                // $this->redirectIntended(route('admin.as.general-settings'));
                return redirect()->intended(route('admin.as.general-settings'))->with('success', 'Settings saved successfully!');
            } else {
                $this->error(__('Failed to save settings. Please try again.'));
            }
        } catch (\Exception $e) {
            Log::error('General settings save failed', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            session()->flash('error', 'Failed to save settings. Please try again.');
            // $this->error(__('An error occurred. Please try again.'));
        } finally {
            $this->saving = false;
        }
    }

    protected function prepareSettingsData(): array
    {
        return [
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
    }

    protected function handleFileUpload(string $field, array &$data): void
    {
        // Map field names to their property names
        $fileProperty = $field; // 'app_logo' or 'favicon'
        $currentProperty = $field === 'app_logo' ? 'current_logo' : 'current_favicon';

        // Check if file was uploaded
        if (!$this->$fileProperty) {
            return;
        }

        // Upload the new file
        $uploadedPath = $this->settingsService->uploadFile(
            $this->$fileProperty,
            $field
        );

        if (!$uploadedPath) {
            return;
        }

        // Delete old file if exists
        if ($this->$currentProperty) {
            $this->settingsService->deleteFile($this->$currentProperty);
        }

        // Update data and current property
        $data[$field] = $uploadedPath;
        $this->$currentProperty = $uploadedPath;
    }

    public function resetForm(): void
    {
        $this->reset(['app_logo', 'favicon']);
        $this->loadSettings();
        $this->resetValidation();
        $this->success(__('Form has been reset.'));
    }

    #[Computed]
    public function isProduction(): bool
    {
        return $this->environment === ApplicationSetting::ENV_PRODUCTION;
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
