<div x-data="{ showTranslationDetailsModal: @entangle('showTranslationDetailsModal').live }">

    <!-- Overlay -->
    <div x-show="showTranslationDetailsModal" x-transition.opacity @click="$wire.closeModal()"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div x-show="showTranslationDetailsModal" x-transition class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        :class="{ 'flex!': showTranslationDetailsModal }">

        <div x-transition.scale.origin.center @click.stop
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-6xl w-full relative overflow-hidden">

            <!-- Header with gradient -->
            <div class="bg-linear-to-r from-primary to-accent px-8 py-6 relative">
                <button @click="$wire.closeModal()"
                    class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl transition p-2 rounded-lg glass-card">
                    <flux:icon name="x-mark" class="w-6 h-6 stroke-current" />
                </button>

                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span
                        class="bg-linear-to-r from-zinc-900 to-zinc-800 flex items-center justify-center p-2 rounded-xl">
                        <flux:icon name='language' class="w-7 h-7 stroke-white" />
                    </span>
                    {{ __('Translation Manager') }}
                </h2>
                <p class="text-indigo-100 text-sm mt-1">{{ __('Edit and manage translations across all languages') }}
                </p>
            </div>

            <!-- Language Filter -->
            <div class="px-8 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <label
                        class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Filter by Language:') }}</label>
                    <select wire:model.live="selectedLanguage" class="select">
                        <option value="all">🌍 {{ __('All Languages') }} ({{ count($availableLanguages) }})</option>
                        @foreach ($availableLanguages as $langData)
                            <option value="{{ $langData['locale'] }}">{{ strtoupper($langData['locale']) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8 max-h-[60vh] overflow-y-auto">
                @forelse ($filteredLanguages as $field => $translations)
                    <div class="mb-6 last:mb-0">
                        <!-- Field Header -->
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-1 h-6 bg-indigo-600 rounded-full"></div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white capitalize">
                                {{ str_replace('_', ' ', $field) }}
                            </h3>
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                                {{ count($translations) }} {{ Str::plural('translation', count($translations)) }}
                            </span>
                        </div>

                        <!-- Translations Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($translations as $locale => $value)
                                @php
                                    $key = "{$field}_{$locale}";
                                    $isEditing = $editingStates[$key] ?? false;
                                    $countryCode = $this->getCountryCode($locale);
                                @endphp

                                <div
                                    class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 
                                           rounded-xl p-4 hover:border-indigo-300 dark:hover:border-indigo-600 
                                           hover:shadow-md transition-all duration-200">

                                    <!-- Language Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="w-6 h-6 rounded-full overflow-hidden shadow-sm border border-gray-200">
                                                <img src="https://flagcdn.com/{{ $countryCode }}.svg"
                                                    alt="{{ $locale }}" class="w-full h-full object-cover"
                                                    onerror="this.src='https://via.placeholder.com/24'">
                                            </span>
                                            <span class="font-semibold text-sm text-gray-900 dark:text-white uppercase">
                                                {{ $locale }}
                                            </span>
                                        </div>

                                        <!-- Edit/Save Actions -->
                                        @if (!$isEditing)
                                            <button
                                                wire:click="startEditing('{{ $field }}', '{{ $locale }}')"
                                                class="opacity-0 group-hover:opacity-100 transition-opacity
                                                           p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30
                                                           text-indigo-600 dark:text-indigo-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @else
                                            <div class="flex items-center gap-1">
                                                <button
                                                    wire:click="saveTranslation('{{ $field }}', '{{ $locale }}')"
                                                    class="p-1.5 rounded-lg bg-green-500 hover:bg-green-600 text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <button
                                                    wire:click="cancelEditing('{{ $field }}', '{{ $locale }}')"
                                                    class="p-1.5 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 
                                                               dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Translation Content -->
                                    @if ($isEditing)
                                        <textarea wire:model="editingValues.{{ $key }}" rows="3"
                                            class="w-full px-3 py-2 text-sm border border-indigo-300 dark:border-indigo-600 
                                                         rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                                         dark:bg-gray-900 dark:text-white resize-none"
                                            placeholder="Enter translation..."></textarea>
                                    @else
                                        <div class="min-h-[3rem] flex items-center">
                                            @if (empty($value))
                                                <p class="text-sm text-gray-400 dark:text-gray-500 italic">
                                                    No translation available - Click edit to add
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                                    {{ $value }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No translations found for this language</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div
                class="px-8 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button @click="$wire.closeModal()"
                    class="px-6 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white 
                               font-semibold shadow-sm transition-colors duration-200">
                    Close
                </button>
            </div>

        </div>
    </div>



    <!-- Modern Toast Notification -->
    <div x-data="{
        showToast: false,
        message: '',
        type: 'success',
        timeout: null,
        progress: 100,
        progressInterval: null,
        isPaused: false,
        init() {
            window.addEventListener('translation-updated', (event) => {
                this.message = event.detail.message || event.detail[0]?.message || '';
                this.type = event.detail.type || event.detail[0]?.type || 'success';
                this.showToast = true;
                this.progress = 100;
                this.isPaused = false;
                this.startProgress();
            });
        },
        startProgress() {
            clearTimeout(this.timeout);
            clearInterval(this.progressInterval);
    
            const duration = 5000; // 5 seconds
            const interval = 50;
            const decrement = (interval / duration) * 100;
    
            this.progressInterval = setInterval(() => {
                if (!this.isPaused) {
                    this.progress -= decrement;
                    if (this.progress <= 0) {
                        this.close();
                    }
                }
            }, interval);
        },
        pauseProgress() {
            this.isPaused = true;
        },
        resumeProgress() {
            this.isPaused = false;
        },
        close() {
            console.log('Toast closed');
            this.showToast = false;
            clearInterval(this.progressInterval);
            clearTimeout(this.timeout);
        }
    }" x-show="showToast" x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-x-full opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-x-0 opacity-100 scale-100"
        x-transition:leave-end="translate-x-full opacity-0 scale-95" @mouseenter="pauseProgress()"
        @mouseleave="resumeProgress()" class="fixed top-6 right-6 z-[100] max-w-md w-full" style="display: none;">

        <div class="relative overflow-hidden rounded-2xl shadow-2xl backdrop-blur-sm border transition-all duration-300 hover:scale-[1.02]"
            :class="{
                'bg-gradient-to-br from-emerald-500/95 to-green-600/95 border-emerald-400/50': type === 'success',
                'bg-gradient-to-br from-rose-500/95 to-red-600/95 border-rose-400/50': type === 'error'
            }">

            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0"
                    :class="{
                        'bg-[radial-gradient(circle_at_50%_120%,_rgba(255,255,255,0.3),_transparent)]': type === 'success',
                        'bg-[radial-gradient(circle_at_50%_120%,_rgba(255,255,255,0.2),_transparent)]': type === 'error'
                    }">
                </div>
            </div>

            <!-- Content -->
            <div class="relative p-5 flex items-start gap-4">
                <!-- Icon Container with Animation -->
                <div class="flex-shrink-0 relative">
                    <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center
                           shadow-lg ring-2 ring-white/30 transition-transform duration-300"
                        :class="{ 'animate-bounce': showToast && type === 'success' }">

                        <!-- Success Icon -->
                        <svg x-show="type === 'success'" class="w-6 h-6 text-white drop-shadow-lg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24"
                            x-transition:enter="transition-all duration-500 delay-100"
                            x-transition:enter-start="scale-0 rotate-180" x-transition:enter-end="scale-100 rotate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7" />
                        </svg>

                        <!-- Error Icon -->
                        <svg x-show="type === 'error'" class="w-6 h-6 text-white drop-shadow-lg" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24"
                            x-transition:enter="transition-all duration-500 delay-100"
                            x-transition:enter-start="scale-0 rotate-180" x-transition:enter-end="scale-100 rotate-0">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <!-- Pulse Effect -->
                    <div class="absolute inset-0 rounded-xl bg-white/30 animate-ping" x-show="showToast"
                        x-transition:enter="transition-opacity duration-1000" x-transition:enter-start="opacity-100"
                        x-transition:enter-end="opacity-0" style="animation-iteration-count: 1;">
                    </div>
                </div>

                <!-- Message Content -->
                <div class="flex-1 pt-0.5">
                    <h4 class="text-white font-bold text-base mb-1 drop-shadow-sm"
                        x-text="type === 'success' ? 'Success!' : 'Error'"></h4>
                    <p class="text-white/95 text-sm leading-relaxed font-medium drop-shadow-sm" x-text="message"></p>
                </div>

                <!-- Close Button -->
                <button @click="close()"
                    class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 
                           backdrop-blur-md flex items-center justify-center
                           transition-all duration-200 hover:scale-110 active:scale-95
                           ring-2 ring-white/20 hover:ring-white/40 group">
                    <svg class="w-4 h-4 text-white group-hover:rotate-90 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-black/20 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-white/80 to-white/60 shadow-lg transition-all duration-100 ease-linear"
                    :style="`width: ${progress}%`" :class="{ 'pause-animation': isPaused }">
                    <!-- Shimmer Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent 
                           animate-shimmer"
                        style="animation: shimmer 2s infinite;">
                    </div>
                </div>
            </div>

            <!-- Corner Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                <div
                    class="absolute top-0 right-0 w-full h-full 
                       bg-gradient-to-br from-white to-transparent 
                       rounded-bl-full transform translate-x-16 -translate-y-16">
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</div>
