<div class="relative">
    {{-- Toast Notifications --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-end z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-end z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="alert alert-error shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="bg-base-200 rounded-2xl p-6 mb-6 shadow-sm border border-base-300">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-primary/10 rounded-xl hidden sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold">{{ __('General Settings') }}</h1>
                    <p class="text-base-content/60 mt-1">
                        {{ __('Configure your application preferences and environment settings') }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <div
                    class="badge badge-lg gap-2 {{ $environment === 'production' ? 'badge-success' : 'badge-warning' }}">
                    <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                    {{ $environment === 'production' ? __('Production') : __('Development') }}
                </div>
                @if ($app_debug === '1')
                    <div class="badge badge-lg badge-error gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        </svg>
                        {{ __('Debug ON') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Main Settings Column --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Application Identity Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title text-lg">{{ __('Application Identity') }}</h2>
                                <p class="text-sm text-base-content/60">
                                    {{ __('Basic information about your application') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Application Name') }} <span
                                            class="text-error">*</span></span>
                                </label>
                                <input type="text" wire:model="app_name" placeholder="{{ __('My Awesome App') }}"
                                    class="input input-bordered w-full focus:input-primary @error('app_name') input-error @enderror">
                                @error('app_name')
                                    <label class="label"><span
                                            class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Short Name') }}</span>
                                    <span
                                        class="label-text-alt text-base-content/50">{{ __('For mobile/tabs') }}</span>
                                </label>
                                <input type="text" wire:model="short_name" placeholder="{{ __('App') }}"
                                    class="input input-bordered w-full focus:input-primary @error('short_name') input-error @enderror">
                                @error('short_name')
                                    <label class="label"><span
                                            class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Environment & Timezone Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-secondary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title text-lg">{{ __('Environment & Region') }}</h2>
                                <p class="text-sm text-base-content/60">{{ __('Server environment and timezone') }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Timezone') }}</span>
                                </label>
                                <select wire:model="timezone"
                                    class="select select-bordered w-full focus:select-primary">
                                    <option value="">{{ __('Select Timezone') }}</option>
                                    @foreach ($timezones as $tz)
                                        <option value="{{ $tz['timezone'] }}">{{ $tz['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Environment') }}</span>
                                </label>
                                <select wire:model="environment"
                                    class="select select-bordered w-full focus:select-primary">
                                    @foreach (App\Models\ApplicationSetting::getEnvironmentOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Debug & Development Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-warning/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-warning" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title text-lg">{{ __('Debug & Development') }}</h2>
                                <p class="text-sm text-base-content/60">
                                    {{ __('Development tools and debugging options') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            {{-- App Debug --}}
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('App Debug') }}</span>
                                </label>
                                <div class="bg-base-300/50 rounded-xl p-4 space-y-3">
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $app_debug === '1' ? 'bg-success/10 ring-1 ring-success/30' : '' }}">
                                        <input type="radio" wire:model.live="app_debug" value="1"
                                            class="radio radio-success radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ __('Enabled') }}
                                        </span>
                                    </label>
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $app_debug === '0' ? 'bg-base-100 ring-1 ring-base-content/10' : '' }}">
                                        <input type="radio" wire:model.live="app_debug" value="0"
                                            class="radio radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-base-content/50" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ __('Disabled') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            {{-- Debugbar --}}
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Debugbar') }}</span>
                                </label>
                                <div class="bg-base-300/50 rounded-xl p-4 space-y-3">
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $debugbar === '1' ? 'bg-secondary/10 ring-1 ring-secondary/30' : '' }}">
                                        <input type="radio" wire:model.live="debugbar" value="1"
                                            class="radio radio-secondary radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ __('Enabled') }}
                                        </span>
                                    </label>
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $debugbar === '0' ? 'bg-base-100 ring-1 ring-base-content/10' : '' }}">
                                        <input type="radio" wire:model.live="debugbar" value="0"
                                            class="radio radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-base-content/50" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ __('Disabled') }}
                                        </span>
                                    </label>
                                </div>
                            </div>

                            {{-- Auto Translate --}}
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Auto Translate') }}</span>
                                </label>
                                <div class="bg-base-300/50 rounded-xl p-4 space-y-3">
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $auto_translate === '1' ? 'bg-accent/10 ring-1 ring-accent/30' : '' }}">
                                        <input type="radio" wire:model.live="auto_translate" value="1"
                                            class="radio radio-accent radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-accent"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ __('Enabled') }}
                                        </span>
                                    </label>
                                    <label
                                        class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-base-100 transition-all {{ $auto_translate === '0' ? 'bg-base-100 ring-1 ring-base-content/10' : '' }}">
                                        <input type="radio" wire:model.live="auto_translate" value="0"
                                            class="radio radio-sm">
                                        <span class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-base-content/50" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ __('Disabled') }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Warning Alert --}}
                        @if ($app_debug === '1' || $debugbar === '1')
                            <div class="alert alert-warning mt-5 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h3 class="font-bold">{{ __('Security Warning') }}</h3>
                                    <div class="text-sm">
                                        {{ __('Debug options should be disabled in production environments for security.') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Display Preferences Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-info/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title text-lg">{{ __('Display Preferences') }}</h2>
                                <p class="text-sm text-base-content/60">{{ __('Customize date, time and theme') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Date Format') }}</span>
                                </label>
                                <select wire:model="date_format"
                                    class="select select-bordered w-full focus:select-primary">
                                    @foreach (App\Models\ApplicationSetting::getDateFormatOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Time Format') }}</span>
                                </label>
                                <select wire:model="time_format"
                                    class="select select-bordered w-full focus:select-primary">
                                    @foreach (App\Models\ApplicationSetting::getTimeFormatOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-medium">{{ __('Theme Mode') }}</span>
                                </label>
                                <select wire:model="theme_mode"
                                    class="select select-bordered w-full focus:select-primary">
                                    @foreach (App\Models\ApplicationSetting::getThemeOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column - Branding --}}
            <div class="space-y-6">
                {{-- App Logo Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-accent/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="card-title text-lg">{{ __('Application Logo') }}</h2>
                        </div>

                        <div class="border-2 border-dashed border-base-300 rounded-2xl p-6 text-center hover:border-primary hover:bg-primary/5 transition-all duration-300 cursor-pointer group"
                            onclick="document.getElementById('app_logo_input').click()">
                            <input type="file" wire:model="app_logo" id="app_logo_input" accept="image/*"
                                class="hidden">

                            <div wire:loading.remove wire:target="app_logo">
                                @if ($app_logo)
                                    <div class="avatar">
                                        <div
                                            class="w-32 rounded-2xl ring-4 ring-primary ring-offset-base-100 ring-offset-2 shadow-lg">
                                            <img src="{{ $app_logo->temporaryUrl() }}" alt="New Logo">
                                        </div>
                                    </div>
                                    <p
                                        class="text-sm text-success mt-4 font-semibold flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('New logo ready!') }}
                                    </p>
                                @elseif ($current_logo)
                                    <div class="avatar">
                                        <div class="w-32 rounded-2xl shadow-md">
                                            <img src="{{ asset($current_logo) }}" alt="Current Logo">
                                        </div>
                                    </div>
                                    <p class="text-sm text-base-content/60 mt-4">{{ __('Click to change logo') }}</p>
                                @else
                                    <div class="flex flex-col items-center py-4">
                                        <div
                                            class="p-5 bg-base-300 rounded-2xl group-hover:bg-primary/20 transition-colors mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-12 w-12 text-base-content/30 group-hover:text-primary transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-base-content/80">{{ __('Upload Logo') }}</p>
                                        <p class="text-xs text-base-content/50 mt-1">
                                            {{ __('PNG, JPG, SVG • Max 2MB') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div wire:loading wire:target="app_logo" class="py-8">
                                <span class="loading loading-spinner loading-lg text-primary"></span>
                                <p class="text-sm mt-3 text-base-content/60">{{ __('Uploading...') }}</p>
                            </div>
                        </div>

                        @error('app_logo')
                            <div class="alert alert-error mt-3 py-2">
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Favicon Card --}}
                <div class="card bg-base-200 shadow-sm border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-success/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h2 class="card-title text-lg">{{ __('Favicon') }}</h2>
                        </div>

                        <div class="border-2 border-dashed border-base-300 rounded-2xl p-6 text-center hover:border-success hover:bg-success/5 transition-all duration-300 cursor-pointer group"
                            onclick="document.getElementById('favicon_input').click()">
                            <input type="file" wire:model="favicon" id="favicon_input" accept="image/*"
                                class="hidden">

                            <div wire:loading.remove wire:target="favicon">
                                @if ($favicon)
                                    <div class="avatar">
                                        <div
                                            class="w-20 rounded-xl ring-4 ring-success ring-offset-base-100 ring-offset-2 shadow-lg">
                                            <img src="{{ $favicon->temporaryUrl() }}" alt="New Favicon">
                                        </div>
                                    </div>
                                    <p
                                        class="text-sm text-success mt-4 font-semibold flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('New favicon ready!') }}
                                    </p>
                                @elseif ($current_favicon)
                                    <div class="avatar">
                                        <div class="w-20 rounded-xl shadow-md">
                                            <img src="{{ asset($current_favicon) }}" alt="Current Favicon">
                                        </div>
                                    </div>
                                    <p class="text-sm text-base-content/60 mt-4">{{ __('Click to change') }}</p>
                                @else
                                    <div class="flex flex-col items-center py-2">
                                        <div
                                            class="p-4 bg-base-300 rounded-xl group-hover:bg-success/20 transition-colors mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-10 w-10 text-base-content/30 group-hover:text-success transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-base-content/80">{{ __('Upload Favicon') }}</p>
                                        <p class="text-xs text-base-content/50 mt-1">
                                            {{ __('16x16 or 32x32 • ICO, PNG') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div wire:loading wire:target="favicon" class="py-6">
                                <span class="loading loading-spinner loading-md text-success"></span>
                                <p class="text-sm mt-2 text-base-content/60">{{ __('Uploading...') }}</p>
                            </div>
                        </div>

                        @error('favicon')
                            <div class="alert alert-error mt-3 py-2">
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Quick Tips Card --}}
                <div
                    class="card bg-gradient-to-br from-primary/5 via-secondary/5 to-accent/5 shadow-sm border border-base-300">
                    <div class="card-body">
                        <h3 class="font-bold flex items-center gap-2 text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            {{ __('Quick Tips') }}
                        </h3>
                        <ul class="space-y-3 mt-4">
                            <li class="flex items-start gap-3 text-sm">
                                <div class="p-1 bg-success/20 rounded-full mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-success"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span
                                    class="text-base-content/70">{{ __('Use production mode for live websites') }}</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm">
                                <div class="p-1 bg-success/20 rounded-full mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-success"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span
                                    class="text-base-content/70">{{ __('Always disable debug in production') }}</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm">
                                <div class="p-1 bg-success/20 rounded-full mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-success"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-base-content/70">{{ __('Use square logo (400x400px)') }}</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm">
                                <div class="p-1 bg-success/20 rounded-full mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-success"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-base-content/70">{{ __('Set correct timezone for reports') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Action Bar --}}
        <div class="absolute bottom-0 left-0 right-0 z-50 lg:sticky lg:bottom-4 lg:mt-8">
            <div
                class="bg-base-100/95 backdrop-blur-xl border-t lg:border border-base-300 lg:rounded-2xl shadow-2xl lg:shadow-lg p-4 lg:mx-0">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 max-w-7xl mx-auto">
                    <div class="hidden sm:flex items-center gap-3 text-sm text-base-content/60">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-base-200 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-info" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ __('Changes update .env automatically') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button" wire:click="resetForm"
                            class="btn btn-ghost btn-md flex-1 sm:flex-none gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="hidden sm:inline">{{ __('Reset') }}</span>
                        </button>

                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="!bg-primary/70"
                            wire:target="save" class="btn btn-primary btn-md flex-1 sm:flex-none gap-2 min-w-[140px]">
                            <span wire:loading.remove wire:target="save">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="loading loading-spinner loading-sm"></span>
                            </span>
                            <span wire:loading.remove wire:target="save">{{ __('Save Changes') }}</span>
                            <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
