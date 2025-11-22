<div>
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-400 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-400 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold text-text-white">{{ __('General Settings') }}</h2>
        <p class="text-sm text-gray-400 mt-1">{{ __('Configure your application settings') }}</p>
    </div>

    {{-- Settings Form --}}
    <div class="glass-card rounded-2xl p-6">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column - Main Settings --}}
                <div class="lg:col-span-2 space-y-5">
                    
                    {{-- App Identity --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Application Name') }}
                            </label>
                            <input 
                                type="text" 
                                wire:model="app_name"
                                placeholder="{{ __('My Application') }}"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                            @error('app_name') 
                                <span class="text-red-400 text-xs mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Short Name') }}
                            </label>
                            <input 
                                type="text" 
                                wire:model="short_name"
                                placeholder="{{ __('App') }}"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                            @error('short_name') 
                                <span class="text-red-400 text-xs mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    {{-- Timezone & Environment --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Timezone') }}
                            </label>
                            <select 
                                wire:model="timezone"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                <option value="">{{ __('Select Timezone') }}</option>
                                @foreach ($timezones as $tz)
                                    <option value="{{ $tz['timezone'] }}">{{ $tz['name'] }}</option>
                                @endforeach
                            </select>
                            @error('timezone') 
                                <span class="text-red-400 text-xs mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Environment') }}
                            </label>
                            <select 
                                wire:model="environment"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getEnvironmentOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('environment') 
                                <span class="text-red-400 text-xs mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    {{-- Debug Settings --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('App Debug') }}
                            </label>
                            <select 
                                wire:model="app_debug"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getToggleOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Debugbar') }}
                            </label>
                            <select 
                                wire:model="debugbar"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getToggleOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Auto Translate') }}
                            </label>
                            <select 
                                wire:model="auto_translate"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getToggleOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Date, Time, Theme --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Date Format') }}
                            </label>
                            <select 
                                wire:model="date_format"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getDateFormatOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Time Format') }}
                            </label>
                            <select 
                                wire:model="time_format"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getTimeFormatOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                {{ __('Theme Mode') }}
                            </label>
                            <select 
                                wire:model="theme_mode"
                                class="w-full px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-lg text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                            >
                                @foreach (App\Models\ApplicationSetting::getThemeOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Right Column - File Uploads --}}
                <div class="space-y-5">
                    {{-- App Logo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Application Logo') }}
                        </label>
                        <div class="border-2 border-dashed border-gray-700 rounded-lg p-4 text-center hover:border-gray-600 transition">
                            <input 
                                type="file" 
                                wire:model="app_logo" 
                                id="app_logo"
                                accept="image/*"
                                class="hidden"
                            >
                            <label for="app_logo" class="cursor-pointer">
                                <div wire:loading.remove wire:target="app_logo">
                                    @if ($app_logo)
                                        <img src="{{ $app_logo->temporaryUrl() }}" class="max-h-24 mx-auto rounded mb-2">
                                    @elseif ($current_logo)
                                        <img src="{{ asset($current_logo) }}" class="max-h-24 mx-auto rounded mb-2">
                                    @else
                                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div wire:loading wire:target="app_logo" class="py-4">
                                    <svg class="animate-spin h-8 w-8 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-400">{{ __('Click to upload') }}</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Max 2MB. PNG, JPG, SVG') }}</p>
                        @error('app_logo') 
                            <span class="text-red-400 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Favicon') }}
                        </label>
                        <div class="border-2 border-dashed border-gray-700 rounded-lg p-4 text-center hover:border-gray-600 transition">
                            <input 
                                type="file" 
                                wire:model="favicon" 
                                id="favicon"
                                accept="image/*"
                                class="hidden"
                            >
                            <label for="favicon" class="cursor-pointer">
                                <div wire:loading.remove wire:target="favicon">
                                    @if ($favicon)
                                        <img src="{{ $favicon->temporaryUrl() }}" class="max-h-16 mx-auto rounded mb-2">
                                    @elseif ($current_favicon)
                                        <img src="{{ asset($current_favicon) }}" class="max-h-16 mx-auto rounded mb-2">
                                    @else
                                        <svg class="w-10 h-10 mx-auto text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div wire:loading wire:target="favicon" class="py-2">
                                    <svg class="animate-spin h-6 w-6 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-400">{{ __('Click to upload') }}</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ __('16x16 or 32x32 recommended') }}</p>
                        @error('favicon') 
                            <span class="text-red-400 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-700">
                <button 
                    type="button" 
                    wire:click="resetForm"
                    class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('Reset') }}
                </button>

                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-800 disabled:cursor-not-allowed text-white rounded-lg transition flex items-center gap-2"
                >
                    <span wire:loading.remove wire:target="save">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="save">{{ __('Save Settings') }}</span>
                    <span wire:loading wire:target="save">{{ __('Saving...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>