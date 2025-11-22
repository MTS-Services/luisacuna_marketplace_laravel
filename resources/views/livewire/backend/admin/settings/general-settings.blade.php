<div>
    {{-- Toast Notifications --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-center z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="alert alert-success shadow-2xl border-2 border-success/30">
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
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
            <div class="alert alert-error shadow-2xl border-2 border-error/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div>
        {{-- Modern Header --}}
        <div class="relative overflow-hidden rounded-3xl glass-card p-8 mb-8 shadow-xl">
            <div class="absolute inset-0 bg-linear-to-br from-primary via-secondary to-accent"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 dark:bg-black/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 dark:bg-black/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="p-4 bg-bg-primary/50 backdrop-blur-sm rounded-2xl shadow-lg">
                            <flux:icon name="cog-8-tooth" class="h-10 w-10 stroke-text-primary" />
                        </div>
                        <div class="text-text-primary">
                            <h1 class="text-3xl lg:text-4xl font-bold mb-1">{{ __('General Settings') }}</h1>
                            <p class="text-text-secondary text-sm lg:text-base">
                                {{ __('Configure your application preferences and environment') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <div
                            class="badge badge-lg gap-2 {{ $environment === 'production' ? 'badge-success' : 'badge-warning' }} shadow-lg">
                            <flux:icon name="cloud" class="h-4 w-4 stroke-text-primary" />
                            {{ $environment === 'production' ? __('Production') : __('Development') }}
                        </div>
                        @if ($app_debug === '1')
                            <div class="badge badge-lg badge-error gap-2 shadow-lg animate-pulse">
                                <flux:icon name="exclamation-triangle" class="h-4 w-4 stroke-text-primary" />
                                {{ __('Debug Mode') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Application Identity - Modern Card --}}
                    <div
                        class="group relative glass-card rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-linear-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 bg-linear-to-br from-primary to-primary/70 rounded-xl shadow-md">
                                    <flux:icon name="home-modern" class="h-6 w-6 stroke-text-primary" />
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Application Identity') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60">{{ __('Define your brand presence') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-control">
                                    <x-ui.label class="label flex items-center gap-2">
                                        {{ __('Application Name') }}
                                        <sup class="text-red-500 font-bold">*</sup>
                                    </x-ui.label>
                                    <x-ui.input type="text" wire:model="app_name"
                                        placeholder="{{ __('My Awesome App') }}" class="mt-2" />
                                    <x-ui.input-error :messages="$errors->get('app_name')" class="mt-2" />
                                </div>

                                <div class="form-control">
                                    <x-ui.label class="label flex items-center gap-2">{{ __('Short Name') }}
                                        <span
                                            class="label-text-alt text-base-content/50 text-xs">{{ __('For tabs & mobile') }}</span>
                                    </x-ui.label>
                                    <x-ui.input type="text" wire:model="short_name"
                                        placeholder="{{ __('App') }}" class="mt-2" />
                                    <x-ui.input-error :messages="$errors->get('short_name')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Environment & Region --}}
                    <div
                        class="group relative bg-base-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-linear-to-br from-secondary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 bg-linear-to-br from-secondary to-secondary/70 rounded-xl shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Environment & Region') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60">{{ __('Configure deployment settings') }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ __('Timezone') }}
                                        </span>
                                    </label>
                                    <select wire:model="timezone"
                                        class="select select-bordered select-lg w-full bg-base-200 focus:bg-base-100 focus:ring-2 focus:ring-secondary transition-all">
                                        <option value="">{{ __('Select Timezone') }}</option>
                                        @foreach ($timezones as $tz)
                                            <option value="{{ $tz['timezone'] }}">{{ $tz['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ __('Environment') }}
                                        </span>
                                    </label>
                                    <select wire:model="environment"
                                        class="select select-bordered select-lg w-full bg-base-200 focus:bg-base-100 focus:ring-2 focus:ring-secondary transition-all">
                                        @foreach (App\Models\ApplicationSetting::getEnvironmentOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Developer Tools - Interactive Toggles --}}
                    <div
                        class="group relative bg-base-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-linear-to-br from-warning/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-3 bg-linear-to-br from-warning to-warning/70 rounded-xl shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-base-content">{{ __('Developer Tools') }}
                                        </h2>
                                        <p class="text-sm text-base-content/60">
                                            {{ __('Debugging & development features') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                                {{-- App Debug Toggle --}}
                                <div class="relative">
                                    <div class="bg-linear-to-br from-base-200 to-base-300/50 rounded-xl p-5 h-full">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="font-semibold text-base-content">{{ __('App Debug') }}</span>
                                            <input type="checkbox" wire:model.live="app_debug" value="1"
                                                class="toggle toggle-success"
                                                {{ $app_debug === '1' ? 'checked' : '' }}>
                                        </div>
                                        <p class="text-xs text-base-content/60">
                                            {{ __('Show detailed error messages') }}</p>
                                        @if ($app_debug === '1')
                                            <div
                                                class="mt-3 px-2 py-1 bg-success/20 text-success rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 bg-success rounded-full animate-pulse"></span>
                                                {{ __('Active') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Debugbar Toggle --}}
                                <div class="relative">
                                    <div class="bg-linear-to-br from-base-200 to-base-300/50 rounded-xl p-5 h-full">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="font-semibold text-base-content">{{ __('Debugbar') }}</span>
                                            <input type="checkbox" wire:model.live="debugbar" value="1"
                                                class="toggle toggle-secondary"
                                                {{ $debugbar === '1' ? 'checked' : '' }}>
                                        </div>
                                        <p class="text-xs text-base-content/60">
                                            {{ __('Display Laravel debug toolbar') }}</p>
                                        @if ($debugbar === '1')
                                            <div
                                                class="mt-3 px-2 py-1 bg-secondary/20 text-secondary rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                <span
                                                    class="w-1.5 h-1.5 bg-secondary rounded-full animate-pulse"></span>
                                                {{ __('Active') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Auto Translate Toggle --}}
                                <div class="relative">
                                    <div class="bg-linear-to-br from-base-200 to-base-300/50 rounded-xl p-5 h-full">
                                        <div class="flex items-center justify-between mb-4">
                                            <span
                                                class="font-semibold text-base-content">{{ __('Auto Translate') }}</span>
                                            <input type="checkbox" wire:model.live="auto_translate" value="1"
                                                class="toggle toggle-accent"
                                                {{ $auto_translate === '1' ? 'checked' : '' }}>
                                        </div>
                                        <p class="text-xs text-base-content/60">
                                            {{ __('Automatic language detection') }}</p>
                                        @if ($auto_translate === '1')
                                            <div
                                                class="mt-3 px-2 py-1 bg-accent/20 text-accent rounded-lg text-xs font-semibold inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse"></span>
                                                {{ __('Active') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($app_debug === '1' || $debugbar === '1')
                                <div
                                    class="mt-5 bg-linear-to-r from-warning/10 via-warning/5 to-transparent border-l-4 border-warning rounded-lg p-4">
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-warning flex-shrink-0 mt-0.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-bold text-warning mb-1">{{ __('Production Warning') }}
                                            </h4>
                                            <p class="text-sm text-base-content/70">
                                                {{ __('These debug tools expose sensitive information. Always disable them before deploying to production.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Display Preferences --}}
                    <div
                        class="group relative bg-base-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-linear-to-br from-info/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 bg-linear-to-br from-info to-info/70 rounded-xl shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Display Preferences') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60">{{ __('Formatting & appearance') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">{{ __('Date Format') }}</span>
                                    </label>
                                    <select wire:model="date_format"
                                        class="select select-bordered select-lg w-full bg-base-200 focus:bg-base-100 focus:ring-2 focus:ring-info transition-all">
                                        @foreach (App\Models\ApplicationSetting::getDateFormatOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">{{ __('Time Format') }}</span>
                                    </label>
                                    <select wire:model="time_format"
                                        class="select select-bordered select-lg w-full bg-base-200 focus:bg-base-100 focus:ring-2 focus:ring-info transition-all">
                                        @foreach (App\Models\ApplicationSetting::getTimeFormatOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">{{ __('Theme Mode') }}</span>
                                    </label>
                                    <select wire:model="theme_mode"
                                        class="select select-bordered select-lg w-full bg-base-200 focus:bg-base-100 focus:ring-2 focus:ring-info transition-all">
                                        @foreach (App\Models\ApplicationSetting::getThemeOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- App Logo Upload --}}
                    <div
                        class="group relative bg-linear-to-br from-accent/10 via-base-100 to-base-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-accent/20 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-linear-to-br from-accent to-accent/70 rounded-xl shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg">{{ __('App Logo') }}</h3>
                            </div>

                            <div class="relative cursor-pointer group/upload"
                                onclick="document.getElementById('app_logo_input').click()">
                                <input type="file" wire:model="app_logo" id="app_logo_input" accept="image/*"
                                    class="hidden">

                                <div wire:loading.remove wire:target="app_logo"
                                    class="relative rounded-2xl overflow-hidden bg-linear-to-br from-base-200 to-base-300 p-8 border-2 border-dashed border-base-content/20 group-hover/upload:border-accent group-hover/upload:bg-accent/5 transition-all duration-300">
                                    @if ($app_logo)
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-40 h-40 rounded-2xl overflow-hidden ring-4 ring-accent ring-offset-4 ring-offset-base-100 shadow-2xl mb-4">
                                                <img src="{{ $app_logo->temporaryUrl() }}" alt="New Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div
                                                class="flex items-center gap-2 px-4 py-2 bg-success/20 text-success rounded-full text-sm font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ __('Ready to upload!') }}
                                            </div>
                                        </div>
                                    @elseif ($current_logo)
                                        <div class="flex flex-col items-center">
                                            <div class="w-40 h-40 rounded-2xl overflow-hidden shadow-xl mb-4">
                                                <img src="{{ asset($current_logo) }}" alt="Current Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <p class="text-sm text-base-content/60 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ __('Click to replace') }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center py-4">
                                            <div
                                                class="p-6 bg-accent/10 rounded-3xl mb-4 group-hover/upload:scale-110 transition-transform">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-accent"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="font-bold text-lg mb-1">{{ __('Upload Your Logo') }}</p>
                                            <p class="text-xs text-base-content/50">
                                                {{ __('PNG, JPG, SVG • Max 2MB') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div wire:loading wire:target="app_logo"
                                    class="absolute inset-0 bg-base-100/95 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center">
                                    <span class="loading loading-spinner loading-lg text-accent mb-3"></span>
                                    <p class="text-sm font-semibold text-accent">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            @error('app_logo')
                                <div class="mt-3 p-3 bg-error/10 border border-error/30 rounded-xl">
                                    <p class="text-sm text-error font-semibold">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Favicon Upload --}}
                    <div
                        class="group relative bg-linear-to-br from-success/10 via-base-100 to-base-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-success/20 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-linear-to-br from-success to-success/70 rounded-xl shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg">{{ __('Favicon') }}</h3>
                            </div>

                            <div class="relative cursor-pointer group/upload"
                                onclick="document.getElementById('favicon_input').click()">
                                <input type="file" wire:model="favicon" id="favicon_input" accept="image/*"
                                    class="hidden">

                                <div wire:loading.remove wire:target="favicon"
                                    class="relative rounded-2xl overflow-hidden bg-linear-to-br from-base-200 to-base-300 p-8 border-2 border-dashed border-base-content/20 group-hover/upload:border-success group-hover/upload:bg-success/5 transition-all duration-300">
                                    @if ($favicon)
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-24 h-24 rounded-xl overflow-hidden ring-4 ring-success ring-offset-4 ring-offset-base-100 shadow-2xl mb-4">
                                                <img src="{{ $favicon->temporaryUrl() }}" alt="New Favicon"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div
                                                class="flex items-center gap-2 px-4 py-2 bg-success/20 text-success rounded-full text-sm font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ __('Ready to upload!') }}
                                            </div>
                                        </div>
                                    @elseif ($current_favicon)
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 rounded-xl overflow-hidden shadow-xl mb-4">
                                                <img src="{{ asset($current_favicon) }}" alt="Current Favicon"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <p class="text-sm text-base-content/60 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ __('Click to replace') }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center py-2">
                                            <div
                                                class="p-5 bg-success/10 rounded-2xl mb-3 group-hover/upload:scale-110 transition-transform">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-success"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="font-bold">{{ __('Upload Favicon') }}</p>
                                            <p class="text-xs text-base-content/50 mt-1">
                                                {{ __('16x16 or 32x32 • ICO, PNG') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div wire:loading wire:target="favicon"
                                    class="absolute inset-0 bg-base-100/95 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center">
                                    <span class="loading loading-spinner loading-lg text-success mb-3"></span>
                                    <p class="text-sm font-semibold text-success">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            @error('favicon')
                                <div class="mt-3 p-3 bg-error/10 border border-error/30 rounded-xl">
                                    <p class="text-sm text-error font-semibold">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pro Tips Card --}}
                    <div
                        class="relative overflow-hidden bg-linear-to-br from-primary/5 via-secondary/5 to-accent/5 rounded-2xl shadow-lg border border-base-300 p-6">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-linear-to-br from-primary/20 to-transparent rounded-full blur-3xl">
                        </div>
                        <div class="relative">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="p-2 bg-info/20 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg">{{ __('Pro Tips') }}</h3>
                            </div>
                            <ul class="space-y-3">
                                <li
                                    class="flex items-start gap-3 p-3 bg-base-100/50 rounded-xl hover:bg-base-100 transition-all group/tip cursor-default">
                                    <div
                                        class="p-1 bg-success rounded-full mt-0.5 group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80">{{ __('Use production mode for live websites') }}</span>
                                </li>
                                <li
                                    class="flex items-start gap-3 p-3 bg-base-100/50 rounded-xl hover:bg-base-100 transition-all group/tip cursor-default">
                                    <div
                                        class="p-1 bg-warning rounded-full mt-0.5 group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v2m0 4h.01" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80">{{ __('Disable debug tools in production') }}</span>
                                </li>
                                <li
                                    class="flex items-start gap-3 p-3 bg-base-100/50 rounded-xl hover:bg-base-100 transition-all group/tip cursor-default">
                                    <div
                                        class="p-1 bg-accent rounded-full mt-0.5 group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80">{{ __('Use square logo (400×400px recommended)') }}</span>
                                </li>
                                <li
                                    class="flex items-start gap-3 p-3 bg-base-100/50 rounded-xl hover:bg-base-100 transition-all group/tip cursor-default">
                                    <div
                                        class="p-1 bg-secondary rounded-full mt-0.5 group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80">{{ __('Set correct timezone for accurate reports') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Improved Action Bar - Fixed at bottom on mobile, normal on desktop --}}
            <div class="mt-8">
                <div class="card bg-base-100 shadow-2xl border-2 border-primary/20">
                    <div class="card-body p-5 lg:p-6">
                        <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                            {{-- Info Section --}}
                            <div class="hidden lg:flex items-center gap-3">
                                <div
                                    class="flex items-center gap-3 px-4 py-2.5 bg-linear-to-r from-info/10 via-info/5 to-transparent rounded-xl border border-info/20">
                                    <div class="relative flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-info opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-info"></span>
                                        </span>
                                    </div>
                                    <span
                                        class="text-sm font-semibold text-info">{{ __('Auto-saves to .env file') }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-3 w-full lg:w-auto">
                                <button type="button" wire:click="resetForm"
                                    class="btn btn-lg btn-outline border-2 flex-1 lg:flex-none gap-2 hover:scale-105 transition-transform group">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 group-hover:rotate-180 transition-transform duration-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span class="font-bold">{{ __('Reset') }}</span>
                                </button>

                                <button type="submit" wire:loading.attr="disabled"
                                    class="btn btn-lg btn-primary flex-1 lg:flex-none gap-3 min-w-[200px] shadow-xl hover:shadow-2xl hover:scale-105 transition-all relative overflow-hidden group disabled:opacity-70">
                                    {{-- Shine Effect --}}
                                    <span
                                        class="absolute inset-0 bg-linear-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>

                                    {{-- Button Content --}}
                                    <span wire:loading.remove wire:target="save"
                                        class="relative flex items-center gap-2 font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('Save Changes') }}
                                    </span>
                                    <span wire:loading wire:target="save"
                                        class="relative flex items-center gap-3 font-bold">
                                        <span class="loading loading-spinner loading-md"></span>
                                        {{ __('Saving...') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
