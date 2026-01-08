<div>
    {{-- Toast Notifications --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-center z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="alert alert-success shadow-2xl border border-success/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-center z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="alert alert-error shadow-2xl border border-error/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="relative overflow-hidden glass-card rounded-2xl p-6 lg:p-8 mb-6 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>

        <div class="relative z-0">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-xl">
                        <flux:icon name="cog-8-tooth" class="h-8 w-8 stroke-primary" />
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-text-primary">{{ __('General Settings') }}</h1>
                        <p class="text-text-secondary text-sm mt-1">{{ __('Configure your application preferences') }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <div
                        class="badge badge-lg gap-2 {{ $environment === 'production' ? 'badge-success' : 'badge-warning' }}">
                        <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                        {{ $environment === 'production' ? __('Production') : __('Development') }}
                    </div>
                    @if ($app_debug === '1')
                        <div class="badge badge-lg badge-error gap-2 animate-pulse">
                            <flux:icon name="exclamation-triangle" class="h-4 w-4" />
                            {{ __('Debug ON') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Main Content --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Application Identity --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-primary/10 rounded-xl">
                            <flux:icon name="home-modern" class="h-6 w-6 stroke-primary" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text-primary">{{ __('Application Identity') }}</h2>
                            <p class="text-sm text-text-secondary">{{ __('Define your brand presence') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-ui.label>
                                {{ __('Application Name') }}
                                <span class="text-error">*</span>
                            </x-ui.label>
                            <x-ui.input type="text" wire:model="app_name" placeholder="{{ __('My Awesome App') }}"
                                class="mt-2" />
                            <x-ui.input-error :messages="$errors->get('app_name')" class="mt-1" />
                        </div>

                        <div>
                            <x-ui.label>
                                {{ __('Short Name') }}
                                <span class="text-text-secondary text-xs ml-1">({{ __('For tabs & mobile') }})</span>
                            </x-ui.label>
                            <x-ui.input type="text" wire:model="short_name" placeholder="{{ __('App') }}"
                                class="mt-2" />
                            <x-ui.input-error :messages="$errors->get('short_name')" class="mt-1" />
                        </div>
                    </div>
                </div>

                {{-- Environment & Region --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-secondary/10 rounded-xl">
                            <flux:icon name="globe-alt" class="h-6 w-6 stroke-secondary" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text-primary">{{ __('Environment & Region') }}</h2>
                            <p class="text-sm text-text-secondary">{{ __('Server environment and timezone') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="form-control">
                            <x-ui.label>{{ __('Timezone') }}</x-ui.label>
                            <x-ui.select wire:model="timezone" class="mt-2">
                                <option value="">{{ __('Select Timezone') }}</option>
                                @foreach ($timezones as $tz)
                                    <option value="{{ $tz['timezone'] }}">{{ $tz['name'] }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('timezone')" class="mt-1" />
                        </div>

                        <div class="form-control">
                            <x-ui.label>{{ __('Environment') }}</x-ui.label>
                            <x-ui.select wire:model="environment" class="mt-2">
                                @foreach (App\Models\ApplicationSetting::getEnvironmentOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('environment')" class="mt-1" />
                        </div>
                    </div>
                </div>

                {{-- Developer Tools with Radio Buttons --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-warning/10 rounded-xl">
                            <flux:icon name="code-bracket" class="h-6 w-6 stroke-warning" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text-primary">{{ __('Developer Tools') }}</h2>
                            <p class="text-sm text-text-secondary">{{ __('Debugging and development features') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- App Debug Radio --}}
                        <div class="form-control">
                            <x-ui.label class="mb-3">
                                <flux:icon name="bug-ant" class="h-4 w-4 inline mr-1" />
                                {{ __('Application Debug Mode') }}
                            </x-ui.label>
                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                    {{ $app_debug == '1' ? 'bg-success/10 ring-2 ring-success/50' : 'bg-main/80 hover:bg-hover' }}">
                                    <input type="radio" wire:model.live="app_debug" value="1"
                                        class="radio radio-success radio-sm" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="check-circle" class="h-5 w-5 stroke-success" />
                                            <span class="font-semibold text-text-primary">{{ __('Enabled') }}</span>
                                        </div>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('Show detailed error messages and stack traces') }}</p>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                    {{ $app_debug == '0' ? 'bg-warning/10 ring-2 ring-warning/50' : 'bg-main/80 hover:bg-hover' }}">
                                    <input type="radio" wire:model.live="app_debug" value="0"
                                        class="radio radio-sm radio-warning" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="x-circle" class="h-5 w-5 stroke-base-content/50" />
                                            <span class="font-semibold text-text-primary">{{ __('Disabled') }}</span>
                                        </div>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('Hide errors from users (recommended for production)') }}</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Auto Translate Radio --}}
                        <div class="form-control">
                            <x-ui.label class="mb-3">
                                <flux:icon name="language" class="h-4 w-4 inline mr-1" />
                                {{ __('Auto Translation') }}
                            </x-ui.label>
                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                    {{ $auto_translate === '1' ? 'bg-accent/10 ring-2 ring-accent/50' : 'bg-main/80 hover:bg-hover' }}">
                                    <input type="radio" wire:model.live="auto_translate" value="1"
                                        class="radio radio-accent radio-sm" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="check-circle" class="h-5 w-5 stroke-accent" />
                                            <span class="font-semibold text-text-primary">{{ __('Enabled') }}</span>
                                        </div>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('Automatically translate content to user language') }}</p>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                    {{ $auto_translate === '0' ? 'bg-warning/10 ring-2 ring-warning/50' : 'bg-main/80 hover:bg-hover' }}">
                                    <input type="radio" wire:model.live="auto_translate" value="0"
                                        class="radio radio-sm radio-warning" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="x-circle" class="h-5 w-5 stroke-base-content/50" />
                                            <span class="font-semibold text-text-primary">{{ __('Disabled') }}</span>
                                        </div>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('Use original language only') }}</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Warning Alert --}}
                    @if ($app_debug === '1')
                        <div class="mt-6 p-4 bg-warning/10 border-l-4 border-warning rounded-r-xl">
                            <div class="flex items-start gap-3">
                                <flux:icon name="exclamation-triangle"
                                    class="h-6 w-6 stroke-warning shrink-0 mt-0.5" />
                                <div>
                                    <h4 class="font-bold text-warning">{{ __('Security Warning') }}</h4>
                                    <p class="text-sm text-text-secondary mt-1">
                                        {{ __('Debug mode exposes sensitive information. Always disable before deploying to production.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Display Preferences --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-info/10 rounded-xl">
                            <flux:icon name="paint-brush" class="h-6 w-6 stroke-info" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text-primary">{{ __('Display Preferences') }}</h2>
                            <p class="text-sm text-text-secondary">{{ __('Formatting and appearance settings') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="form-control">
                            <x-ui.label>{{ __('Date Format') }}</x-ui.label>
                            <x-ui.select wire:model="date_format" class="mt-2">
                                @foreach (App\Models\ApplicationSetting::getDateFormatOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-ui.select>
                        </div>

                        <div class="form-control">
                            <x-ui.label>{{ __('Time Format') }}</x-ui.label>
                            <x-ui.select wire:model="time_format" class="mt-2">
                                @foreach (App\Models\ApplicationSetting::getTimeFormatOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-ui.select>
                        </div>

                        <div class="form-control">
                            <x-ui.label>{{ __('Theme Mode') }}</x-ui.label>
                            <x-ui.select wire:model="theme_mode" class="mt-2">
                                @foreach (App\Models\ApplicationSetting::getThemeOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-ui.select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- App Logo Upload --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-accent/10 rounded-xl">
                            <flux:icon name="photo" class="h-5 w-5 stroke-accent" />
                        </div>
                        <h3 class="font-bold text-text-primary">{{ __('Application Logo') }}</h3>
                    </div>

                    <div class="relative">
                        <input type="file" wire:model="app_logo" id="app_logo_input" accept="image/*"
                            class="hidden">

                        <label for="app_logo_input"
                            class="cursor-pointer rounded-xl border-2 border-dashed border-border 
                                   hover:border-accent hover:bg-accent/5 transition-all duration-300 p-6 flex flex-col items-center justify-center">

                            {{-- Loading State --}}
                            <div wire:loading wire:target="app_logo">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <span class="loading loading-spinner loading-lg text-accent"></span>
                                    <p class="text-sm text-text-secondary mt-3">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            {{-- Content State --}}
                            <div wire:loading.remove wire:target="app_logo">
                                <div class="flex flex-col items-center">
                                    @if ($app_logo && !$errors->has('app_logo'))
                                        <div
                                            class="w-32 h-32 rounded-xl overflow-hidden ring-4 ring-accent ring-offset-2 ring-offset-base-100 shadow-lg mb-4">
                                            <img src="{{ $app_logo->temporaryUrl() }}" alt="New Logo"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-success/20 text-success rounded-full text-sm font-semibold">
                                            <flux:icon name="check" class="h-4 w-4" />
                                            {{ __('Ready to save!') }}
                                        </span>
                                    @elseif ($current_logo)
                                        <div class="w-32 h-32 rounded-xl overflow-hidden shadow-lg mb-4 glass-card">
                                            <img src="{{ storage_url($current_logo) }}" alt="Current Logo"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-sm text-text-secondary">{{ __('Click to change') }}</span>
                                    @else
                                        <div class="p-4 bg-accent/10 rounded-2xl mb-4">
                                            <flux:icon name="cloud-arrow-up" class="h-12 w-12 stroke-accent" />
                                        </div>
                                        <p class="font-semibold text-text-primary">{{ __('Upload Logo') }}</p>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('PNG, JPG, SVG • Max 2MB') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </label>

                        @error('app_logo')
                            <div class="mt-3 p-3 bg-error/10 border border-error/30 rounded-lg">
                                <p class="text-sm text-error">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Favicon Upload --}}
                <div class="glass-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-success/10 rounded-xl">
                            <flux:icon name="star" class="h-5 w-5 stroke-success" />
                        </div>
                        <h3 class="font-bold text-text-primary">{{ __('Favicon') }}</h3>
                    </div>

                    <div class="relative">
                        <input type="file" wire:model="favicon" id="favicon_input" accept="image/*"
                            class="hidden">

                        <label for="favicon_input"
                            class="cursor-pointer rounded-xl border-2 border-dashed border-border 
                                   hover:border-success hover:bg-success/5 transition-all duration-300 p-6 flex flex-col items-center justify-center">

                            {{-- Loading State --}}
                            <div wire:loading wire:target="favicon">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <span class="loading loading-spinner loading-md text-success"></span>
                                    <p class="text-sm text-text-secondary mt-3">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            {{-- Content State --}}
                            <div wire:loading.remove wire:target="favicon">
                                <div class="flex flex-col items-center">
                                    @if ($favicon && !$errors->has('favicon'))
                                        <div
                                            class="w-20 h-20 rounded-lg overflow-hidden ring-4 ring-success ring-offset-2 ring-offset-base-100 shadow-lg mb-4">
                                            <img src="{{ $favicon->temporaryUrl() }}" alt="New Favicon"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-success/20 text-success rounded-full text-sm font-semibold">
                                            <flux:icon name="check" class="h-4 w-4" />
                                            {{ __('Ready to save!') }}
                                        </span>
                                    @elseif ($current_favicon)
                                        <div class="w-20 h-20 rounded-lg overflow-hidden shadow-lg mb-4 glass-card">
                                            <img src="{{ storage_url($current_favicon) }}" alt="Current Favicon"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-sm text-text-secondary">{{ __('Click to change') }}</span>
                                    @else
                                        <div class="p-3 bg-success/10 rounded-xl mb-3">
                                            <flux:icon name="cloud-arrow-up" class="h-10 w-10 stroke-success" />
                                        </div>
                                        <p class="font-semibold text-text-primary">{{ __('Upload Favicon') }}</p>
                                        <p class="text-xs text-text-secondary mt-1">
                                            {{ __('16x16 or 32x32 • ICO, PNG') }}
                                        </p>
                                    @endif

                                </div>
                            </div>
                        </label>

                        @error('favicon')
                            <div class="mt-3 p-3 bg-error/10 border border-error/30 rounded-lg">
                                <p class="text-sm text-error">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Pro Tips --}}
                <div
                    class="glass-card rounded-2xl p-6 shadow-lg bg-gradient-to-br from-primary/5 via-transparent to-secondary/5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-info/10 rounded-lg">
                            <flux:icon name="light-bulb" class="h-5 w-5 stroke-info" />
                        </div>
                        <h3 class="font-bold text-text-primary">{{ __('Pro Tips') }}</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 p-3 bg-main/80 rounded-lg">
                            <div class="p-1 bg-success rounded-full mt-0.5 shrink-0">
                                <flux:icon name="check" class="h-3 w-3 stroke-white" />
                            </div>
                            <span
                                class="text-sm text-text-secondary">{{ __('Use production mode for live sites') }}</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-main/80 rounded-lg">
                            <div class="p-1 bg-warning rounded-full mt-0.5 shrink-0">
                                <flux:icon name="exclamation-triangle" class="h-3 w-3 stroke-white" />
                            </div>
                            <span class="text-sm text-text-secondary">{{ __('Disable debug in production') }}</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-main/80 rounded-lg">
                            <div class="p-1 bg-accent rounded-full mt-0.5 shrink-0">
                                <flux:icon name="star" class="h-3 w-3 stroke-white" />
                            </div>
                            <span
                                class="text-sm text-text-secondary">{{ __('Use square favicon (16x16 or 32x32) for best results') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action Bar --}}
        <div class="mt-8">
            <div class="glass-card rounded-2xl p-5 shadow-xl border border-primary/20">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="hidden sm:flex items-center gap-3 px-4 py-2 bg-info/10 rounded-xl">
                        <flux:icon name="information-circle" class="h-5 w-5 stroke-info" />
                        <span class="text-sm font-medium text-info">{{ __('Changes auto-save to .env file') }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-ui.button type="button" wire:click="resetForm" class="w-fit py-2! text-nowrap!"
                            variant="tertiary">
                            {{-- <flux:icon name="arrow-path"
                                class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            {{ __('Reset') }} --}}
                            <span wire:loading.remove wire:target="resetForm"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-tertiary">
                                <flux:icon name="arrow-path"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                                {{ __('Reset') }}
                            </span>
                            <span wire:loading wire:target="resetForm"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-tertiary">
                                <flux:icon name="arrow-path"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary animate-spin" />
                                {{ __('Resetting...') }}
                            </span>
                        </x-ui.button>

                        <x-ui.button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="w-fit py-2! text-nowrap">
                            <span wire:loading.remove wire:target="save"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-secondary">
                                <flux:icon name="save"
                                    class="h-5 w-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                                {{ __('Save Changes') }}
                            </span>
                            <span wire:loading wire:target="save"
                                class="flex items-center gap-2 text-text-btn-primary group-hover:text-text-btn-secondary">
                                <span class="loading loading-spinner loading-sm"></span>
                                {{ __('Saving...') }}
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
