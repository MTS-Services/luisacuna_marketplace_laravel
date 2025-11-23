<div x-data="{ showTranslationDetailsModal: @entangle('showTranslationDetailsModal').live }">

    <!-- Overlay -->
    <div x-show="showTranslationDetailsModal" x-transition.opacity @click="$wire.closeModal()"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div x-show="showTranslationDetailsModal" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4">

        <div x-transition.scale.origin.center @click.stop
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-6xl w-full relative overflow-hidden">

            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 relative">
                <button @click="$wire.closeModal()"
                    class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl transition">
                    ✕
                </button>

                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                    </svg>
                    Translation Manager
                </h2>
                <p class="text-indigo-100 text-sm mt-1">Edit and manage translations across all languages</p>
            </div>

            <!-- Language Filter -->
            <div class="px-8 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Language:</label>
                    <select wire:model.live="selectedLanguage"
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white
                                   px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="all">🌍 All Languages</option>
                        @foreach ($availableLanguages as $lang)
                            <option value="{{ $lang }}">{{ strtoupper($lang) }}</option>
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
                                                @if (strtolower($locale) === 'en')
                                                    <img src="https://flagcdn.com/us.svg" alt="{{ $locale }}"
                                                        class="w-full h-full object-cover"
                                                        onerror="this.src='https://via.placeholder.com/24'">
                                                @else
                                                    <img src="https://flagcdn.com/{{ strtolower($locale) }}.svg"
                                                        alt="{{ $locale }}" class="w-full h-full object-cover"
                                                        onerror="this.src='https://via.placeholder.com/24'">
                                                @endif

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
                                        <p
                                            class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed min-h-[3rem]">
                                            {{ $value ?: '—' }}
                                        </p>
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


    <!-- Toast Notification for Success/Error -->
    <div x-data="{
        show: false,
        message: '',
        type: 'success',
        timeout: null
    }"
        @translation-updated.window="
        message = $event.detail.message; 
        type = $event.detail.type; 
        show = true;
        clearTimeout(timeout);
        timeout = setTimeout(() => show = false, 3000);
     "
        x-show="show" x-transition class="fixed top-4 right-4 z-[60] max-w-sm">
        <div :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error'
        }"
            class="text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <svg x-show="type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <svg x-show="type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span x-text="message" class="font-medium"></span>
        </div>
    </div>
</div>
