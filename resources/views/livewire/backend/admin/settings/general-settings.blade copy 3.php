<div class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200 pb-24 lg:pb-8">
    {{-- Enhanced Toast Notifications --}}
    @if (session()->has('success'))
        <div class="toast toast-top toast-center z-[100]" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-90 -translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div class="alert alert-success shadow-2xl border-2 border-success/40 backdrop-blur-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-success/20 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success-content" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-base">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-center z-[100]" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 scale-90">
            <div class="alert alert-error shadow-2xl border-2 border-error/40 backdrop-blur-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-error/20 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error-content" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-base">{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">
        {{-- Premium Header Section --}}
        <div class="relative mb-8 lg:mb-10">
            <div
                class="absolute inset-0 bg-gradient-to-r from-primary/20 via-secondary/20 to-accent/20 rounded-[2rem] blur-3xl opacity-30">
            </div>
            <div class="relative bg-gradient-to-br from-primary via-primary to-secondary rounded-[2rem] p-1 shadow-2xl">
                <div class="bg-base-100/95 backdrop-blur-xl rounded-[1.75rem] p-6 lg:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <div class="relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-primary to-secondary rounded-2xl blur-xl opacity-50 animate-pulse">
                                </div>
                                <div
                                    class="relative p-4 bg-gradient-to-br from-primary to-secondary rounded-2xl shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1
                                    class="text-3xl lg:text-4xl font-black bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent mb-1">
                                    {{ __('General Settings') }}
                                </h1>
                                <p class="text-base-content/70 font-medium">
                                    {{ __('Configure your application preferences and environment') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <div
                                class="badge badge-lg gap-2 {{ $environment === 'production' ? 'badge-success' : 'badge-warning' }} shadow-lg font-bold">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-current opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-current"></span>
                                </span>
                                {{ $environment === 'production' ? __('Production') : __('Development') }}
                            </div>
                            @if ($app_debug === '1')
                                <div class="badge badge-lg badge-error gap-2 shadow-lg font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 animate-pulse" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    {{ __('Debug Mode') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Main Content Column --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Application Identity Card --}}
                    <div
                        class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-base-300 hover:border-primary/30">
                        <div class="card-body p-6 lg:p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content flex items-center gap-2">
                                        {{ __('Application Identity') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60 mt-0.5">
                                        {{ __('Define your brand presence') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base flex items-center gap-2">
                                            {{ __('Application Name') }}
                                            <span class="badge badge-error badge-sm">{{ __('Required') }}</span>
                                        </span>
                                    </label>
                                    <input type="text" wire:model="app_name"
                                        placeholder="{{ __('My Awesome App') }}"
                                        class="input input-bordered input-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all duration-200 @error('app_name') input-error @enderror">
                                    @error('app_name')
                                        <label class="label pt-2">
                                            <span class="label-text-alt text-error font-semibold flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base">{{ __('Short Name') }}</span>
                                        <span
                                            class="label-text-alt text-base-content/50 font-medium">{{ __('For tabs & mobile') }}</span>
                                    </label>
                                    <input type="text" wire:model="short_name" placeholder="{{ __('App') }}"
                                        class="input input-bordered input-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-primary focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all duration-200 @error('short_name') input-error @enderror">
                                    @error('short_name')
                                        <label class="label pt-2">
                                            <span
                                                class="label-text-alt text-error font-semibold">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Environment & Region Card --}}
                    <div
                        class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-base-300 hover:border-secondary/30">
                        <div class="card-body p-6 lg:p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-secondary/20 to-secondary/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-secondary"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Environment & Region') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60 mt-0.5">
                                        {{ __('Configure deployment settings') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ __('Timezone') }}
                                        </span>
                                    </label>
                                    <select wire:model="timezone"
                                        class="select select-bordered select-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-secondary focus:outline-none focus:ring-4 focus:ring-secondary/20 transition-all duration-200">
                                        <option value="">{{ __('Select Timezone') }}</option>
                                        @foreach ($timezones as $tz)
                                            <option value="{{ $tz['timezone'] }}">{{ $tz['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ __('Environment') }}
                                        </span>
                                    </label>
                                    <select wire:model="environment"
                                        class="select select-bordered select-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-secondary focus:outline-none focus:ring-4 focus:ring-secondary/20 transition-all duration-200">
                                        @foreach (App\Models\ApplicationSetting::getEnvironmentOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Developer Tools Card with Modern Toggles --}}
                    <div
                        class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-base-300 hover:border-warning/30">
                        <div class="card-body p-6 lg:p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-warning/20 to-warning/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-warning"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Developer Tools') }}</h2>
                                    <p class="text-sm text-base-content/60 mt-0.5">
                                        {{ __('Debugging & development features') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                                {{-- App Debug Toggle --}}
                                <div class="relative group">
                                    <input type="checkbox" id="app_debug_toggle" wire:model.live="app_debug"
                                        value="1" class="peer sr-only"
                                        {{ $app_debug === '1' ? 'checked' : '' }}>
                                    <label for="app_debug_toggle" class="block cursor-pointer">
                                        <div
                                            class="bg-gradient-to-br from-base-200 to-base-300/50 rounded-2xl p-6 border-2 border-base-300 peer-checked:border-success peer-checked:bg-success/5 transition-all duration-300 hover:shadow-lg">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="font-bold text-base">{{ __('App Debug') }}</span>
                                                <div
                                                    class="relative w-14 h-7 bg-base-300 rounded-full peer-checked:bg-success transition-all duration-300 shadow-inner">
                                                    <div
                                                        class="absolute top-0.5 left-0.5 bg-white w-6 h-6 rounded-full shadow-md transition-all duration-300 peer-checked:translate-x-7">
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-xs text-base-content/70 mb-3">
                                                {{ __('Show detailed error messages') }}</p>
                                            @if ($app_debug === '1')
                                                <div class="flex items-center gap-2 text-success font-bold text-xs">
                                                    <span class="relative flex h-2 w-2">
                                                        <span
                                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                                                        <span
                                                            class="relative inline-flex rounded-full h-2 w-2 bg-success"></span>
                                                    </span>
                                                    {{ __('ACTIVE') }}
                                                </div>
                                            @else
                                                <div class="text-base-content/40 font-semibold text-xs">
                                                    {{ __('Disabled') }}</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>

                                {{-- Debugbar Toggle --}}
                                <div class="relative group">
                                    <input type="checkbox" id="debugbar_toggle" wire:model.live="debugbar"
                                        value="1" class="peer sr-only" {{ $debugbar === '1' ? 'checked' : '' }}>
                                    <label for="debugbar_toggle" class="block cursor-pointer">
                                        <div
                                            class="bg-gradient-to-br from-base-200 to-base-300/50 rounded-2xl p-6 border-2 border-base-300 peer-checked:border-secondary peer-checked:bg-secondary/5 transition-all duration-300 hover:shadow-lg">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="font-bold text-base">{{ __('Debugbar') }}</span>
                                                <div
                                                    class="relative w-14 h-7 bg-base-300 rounded-full peer-checked:bg-secondary transition-all duration-300 shadow-inner">
                                                    <div
                                                        class="absolute top-0.5 left-0.5 bg-white w-6 h-6 rounded-full shadow-md transition-all duration-300 peer-checked:translate-x-7">
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-xs text-base-content/70 mb-3">
                                                {{ __('Laravel debug toolbar') }}</p>
                                            @if ($debugbar === '1')
                                                <div class="flex items-center gap-2 text-secondary font-bold text-xs">
                                                    <span class="relative flex h-2 w-2">
                                                        <span
                                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                                                        <span
                                                            class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                                                    </span>
                                                    {{ __('ACTIVE') }}
                                                </div>
                                            @else
                                                <div class="text-base-content/40 font-semibold text-xs">
                                                    {{ __('Disabled') }}</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>

                                {{-- Auto Translate Toggle --}}
                                <div class="relative group">
                                    <input type="checkbox" id="auto_translate_toggle"
                                        wire:model.live="auto_translate" value="1" class="peer sr-only"
                                        {{ $auto_translate === '1' ? 'checked' : '' }}>
                                    <label for="auto_translate_toggle" class="block cursor-pointer">
                                        <div
                                            class="bg-gradient-to-br from-base-200 to-base-300/50 rounded-2xl p-6 border-2 border-base-300 peer-checked:border-accent peer-checked:bg-accent/5 transition-all duration-300 hover:shadow-lg">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="font-bold text-base">{{ __('Auto Translate') }}</span>
                                                <div
                                                    class="relative w-14 h-7 bg-base-300 rounded-full peer-checked:bg-accent transition-all duration-300 shadow-inner">
                                                    <div
                                                        class="absolute top-0.5 left-0.5 bg-white w-6 h-6 rounded-full shadow-md transition-all duration-300 peer-checked:translate-x-7">
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-xs text-base-content/70 mb-3">
                                                {{ __('Auto language detection') }}</p>
                                            @if ($auto_translate === '1')
                                                <div class="flex items-center gap-2 text-accent font-bold text-xs">
                                                    <span class="relative flex h-2 w-2">
                                                        <span
                                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                                                        <span
                                                            class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                                                    </span>
                                                    {{ __('ACTIVE') }}
                                                </div>
                                            @else
                                                <div class="text-base-content/40 font-semibold text-xs">
                                                    {{ __('Disabled') }}</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            </div>

                            @if ($app_debug === '1' || $debugbar === '1')
                                <div class="mt-6 alert alert-warning shadow-lg border-2 border-warning/30">
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 flex-shrink-0"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-bold text-base mb-1">{{ __('Production Warning') }}</h4>
                                            <p class="text-sm opacity-90">
                                                {{ __('Debug tools expose sensitive information. Always disable before production deployment.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Display Preferences Card --}}
                    <div
                        class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-base-300 hover:border-info/30">
                        <div class="card-body p-6 lg:p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="p-3 bg-gradient-to-br from-info/20 to-info/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-base-content">{{ __('Display Preferences') }}
                                    </h2>
                                    <p class="text-sm text-base-content/60 mt-0.5">{{ __('Formatting & appearance') }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base">{{ __('Date Format') }}</span>
                                    </label>
                                    <select wire:model="date_format"
                                        class="select select-bordered select-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-info focus:outline-none focus:ring-4 focus:ring-info/20 transition-all duration-200">
                                        @foreach (App\Models\ApplicationSetting::getDateFormatOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base">{{ __('Time Format') }}</span>
                                    </label>
                                    <select wire:model="time_format"
                                        class="select select-bordered select-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-info focus:outline-none focus:ring-4 focus:ring-info/20 transition-all duration-200">
                                        @foreach (App\Models\ApplicationSetting::getTimeFormatOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label pb-2">
                                        <span class="label-text font-bold text-base">{{ __('Theme Mode') }}</span>
                                    </label>
                                    <select wire:model="theme_mode"
                                        class="select select-bordered select-lg w-full bg-base-200/50 focus:bg-base-100 focus:border-info focus:outline-none focus:ring-4 focus:ring-info/20 transition-all duration-200">
                                        @foreach (App\Models\ApplicationSetting::getThemeOptions() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="space-y-6">
                    {{-- App Logo Upload Card --}}
                    <div
                        class="card bg-gradient-to-br from-accent/5 via-base-100 to-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-accent/20 hover:border-accent/40">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="p-2.5 bg-gradient-to-br from-accent/20 to-accent/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg">{{ __('Application Logo') }}</h3>
                            </div>

                            <div class="relative cursor-pointer group/upload"
                                onclick="document.getElementById('app_logo_input').click()">
                                <input type="file" wire:model="app_logo" id="app_logo_input" accept="image/*"
                                    class="hidden">

                                <div wire:loading.remove wire:target="app_logo"
                                    class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-base-200/80 to-base-300/50 p-8 border-3 border-dashed border-accent/30 group-hover/upload:border-accent group-hover/upload:bg-accent/5 transition-all duration-300">
                                    @if ($app_logo)
                                        <div class="flex flex-col items-center space-y-4">
                                            <div class="relative">
                                                <div class="absolute inset-0 bg-accent/20 rounded-2xl blur-xl">
                                                </div>
                                                <div
                                                    class="relative w-44 h-44 rounded-2xl overflow-hidden ring-4 ring-accent ring-offset-4 ring-offset-base-100 shadow-2xl">
                                                    <img src="{{ $app_logo->temporaryUrl() }}" alt="New Logo"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-success to-success/80 text-white rounded-full text-sm font-bold shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ __('Ready to Save!') }}
                                            </div>
                                        </div>
                                    @elseif ($current_logo)
                                        <div class="flex flex-col items-center space-y-4">
                                            <div
                                                class="w-44 h-44 rounded-2xl overflow-hidden shadow-xl border-2 border-base-300">
                                                <img src="{{ asset($current_logo) }}" alt="Current Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <p
                                                class="text-sm text-base-content/70 font-medium flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ __('Click to update') }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center py-6">
                                            <div
                                                class="p-7 bg-gradient-to-br from-accent/20 to-accent/5 rounded-3xl mb-5 group-hover/upload:scale-110 transition-transform duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-accent"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="font-bold text-lg mb-2 text-base-content">
                                                {{ __('Upload Your Logo') }}</p>
                                            <p class="text-sm text-base-content/60">{{ __('PNG, JPG, SVG') }}</p>
                                            <p class="text-xs text-base-content/40 mt-1">
                                                {{ __('Max 2MB • 400×400px recommended') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div wire:loading wire:target="app_logo"
                                    class="absolute inset-0 bg-base-100/98 backdrop-blur-md rounded-2xl flex flex-col items-center justify-center">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-accent/20 rounded-full blur-xl animate-pulse">
                                        </div>
                                        <span class="relative loading loading-ring loading-lg text-accent"></span>
                                    </div>
                                    <p class="text-sm font-bold text-accent mt-4">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            @error('app_logo')
                                <div class="mt-4 alert alert-error shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Favicon Upload Card --}}
                    <div
                        class="card bg-gradient-to-br from-success/5 via-base-100 to-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-success/20 hover:border-success/40">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="p-2.5 bg-gradient-to-br from-success/20 to-success/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                    class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-base-200/80 to-base-300/50 p-8 border-3 border-dashed border-success/30 group-hover/upload:border-success group-hover/upload:bg-success/5 transition-all duration-300">
                                    @if ($favicon)
                                        <div class="flex flex-col items-center space-y-4">
                                            <div class="relative">
                                                <div class="absolute inset-0 bg-success/20 rounded-xl blur-xl">
                                                </div>
                                                <div
                                                    class="relative w-28 h-28 rounded-xl overflow-hidden ring-4 ring-success ring-offset-4 ring-offset-base-100 shadow-2xl">
                                                    <img src="{{ $favicon->temporaryUrl() }}" alt="New Favicon"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-success to-success/80 text-white rounded-full text-sm font-bold shadow-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ __('Ready to Save!') }}
                                            </div>
                                        </div>
                                    @elseif ($current_favicon)
                                        <div class="flex flex-col items-center space-y-4">
                                            <div
                                                class="w-28 h-28 rounded-xl overflow-hidden shadow-xl border-2 border-base-300">
                                                <img src="{{ asset($current_favicon) }}" alt="Current Favicon"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <p
                                                class="text-sm text-base-content/70 font-medium flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                {{ __('Click to update') }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center py-4">
                                            <div
                                                class="p-6 bg-gradient-to-br from-success/20 to-success/5 rounded-2xl mb-4 group-hover/upload:scale-110 transition-transform duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-success"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                            </div>
                                            <p class="font-bold text-base mb-2">{{ __('Upload Favicon') }}</p>
                                            <p class="text-sm text-base-content/60">{{ __('ICO, PNG') }}</p>
                                            <p class="text-xs text-base-content/40 mt-1">
                                                {{ __('16×16 or 32×32 pixels') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div wire:loading wire:target="favicon"
                                    class="absolute inset-0 bg-base-100/98 backdrop-blur-md rounded-2xl flex flex-col items-center justify-center">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-success/20 rounded-full blur-xl animate-pulse">
                                        </div>
                                        <span class="relative loading loading-ring loading-lg text-success"></span>
                                    </div>
                                    <p class="text-sm font-bold text-success mt-4">{{ __('Uploading...') }}</p>
                                </div>
                            </div>

                            @error('favicon')
                                <div class="mt-4 alert alert-error shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-semibold">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pro Tips Card --}}
                    <div
                        class="card bg-gradient-to-br from-info/5 via-primary/5 to-secondary/5 shadow-xl border-2 border-info/20">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="p-2.5 bg-gradient-to-br from-info/20 to-info/5 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-info" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg">{{ __('Pro Tips') }}</h3>
                            </div>
                            <div class="space-y-3">
                                <div
                                    class="flex items-start gap-3 p-3.5 bg-base-100/60 rounded-xl hover:bg-base-100 hover:shadow-md transition-all duration-200 group/tip">
                                    <div
                                        class="p-1.5 bg-gradient-to-br from-success to-success/70 rounded-lg group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80 leading-relaxed">{{ __('Use production mode for live websites') }}</span>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-3.5 bg-base-100/60 rounded-xl hover:bg-base-100 hover:shadow-md transition-all duration-200 group/tip">
                                    <div
                                        class="p-1.5 bg-gradient-to-br from-warning to-warning/70 rounded-lg group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v2m0 4h.01" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80 leading-relaxed">{{ __('Disable debug tools in production') }}</span>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-3.5 bg-base-100/60 rounded-xl hover:bg-base-100 hover:shadow-md transition-all duration-200 group/tip">
                                    <div
                                        class="p-1.5 bg-gradient-to-br from-accent to-accent/70 rounded-lg group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80 leading-relaxed">{{ __('Use 400×400px square logo') }}</span>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-3.5 bg-base-100/60 rounded-xl hover:bg-base-100 hover:shadow-md transition-all duration-200 group/tip">
                                    <div
                                        class="p-1.5 bg-gradient-to-br from-secondary to-secondary/70 rounded-lg group-hover/tip:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-base-content/80 leading-relaxed">{{ __('Set correct timezone for reports') }}</span>
                                </div>
                            </div>
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
                                    class="flex items-center gap-3 px-4 py-2.5 bg-gradient-to-r from-info/10 via-info/5 to-transparent rounded-xl border border-info/20">
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
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>

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
