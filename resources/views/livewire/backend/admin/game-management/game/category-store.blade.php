<section>
    <!-- Game Information Header -->
    <div
        class="glass-card rounded-2xl p-6 mb-6 backdrop-blur-lg bg-white/80 dark:bg-gray-800/80 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Configuration') }}</h2>
            <x-ui.button href="{{ route('admin.gm.game.edit', encrypt($game->id)) }}" class="w-auto! py-2!">
                <flux:icon name="arrow-left" class="w-4 h-4 stroke-white group-hover:stroke-text-btn-secondary" />
                {{ __('Back') }}
            </x-ui.button>
        </div>
    </div>

    <!-- Game Details Card -->
    <div
        class="glass-card rounded-2xl p-6 mb-6 backdrop-blur-lg bg-white/80 dark:bg-gray-800/80 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
        <h4 class="text-lg font-bold text-text-black dark:text-text-white mb-4">{{ __('Game Information') }}</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div
                class="flex items-center gap-2 p-3 rounded-lg bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('Name') }}:</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $game->name }}</span>
            </div>
            <div
                class="flex items-center gap-2 p-3 rounded-lg bg-linear-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ __('Slug') }}:</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $game->slug }}</span>
            </div>
        </div>
    </div>

    <!-- Category Configuration Card -->
    <div
        class="glass-card rounded-2xl p-6 backdrop-blur-lg bg-white/80 dark:bg-gray-800/80 shadow-xl border border-gray-200/50 dark:border-gray-700/50">
        <h3 class="text-lg font-bold text-text-black dark:text-text-white mb-6">{{ __('Category Configuration') }}</h3>

        @if ($this->categories->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold">{{ __('No categories available') }}
                </p>
            </div>
        @else
            <!-- Category Rows -->
            <div class="space-y-4" wire:loading.class="opacity-50">
                @forelse ($this->gameCategories as $category)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-900/50 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200"
                        wire:key="assigned-category-{{ $category->id }}">
                        <div class="flex-1">
                            <div
                                class="w-full px-4 py-3 rounded-lg border border-green-300 dark:border-green-600 bg-green-50 dark:bg-green-900/20 text-gray-900 dark:text-white font-semibold flex items-center justify-between">
                                <span>{{ $category->name }}</span>
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <button wire:click="openConfigModal('{{ $category->slug }}')" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-linear-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                            type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ __('Configure') }}</span>
                        </button>
                        <button wire:click="removeCategory('{{ $category->slug }}')" wire:loading.attr="disabled"
                            wire:target="removeCategory('{{ $category->slug }}')"
                            wire:confirm="Are you sure you want to remove this category?"
                            class="px-6 py-3 bg-linear-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                            type="button">
                            <svg wire:loading.remove wire:target="removeCategory('{{ $category->slug }}')"
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <svg wire:loading wire:target="removeCategory('{{ $category->slug }}')"
                                class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Remove') }}</span>
                        </button>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        {{ __('No categories assigned yet') }}
                    </div>
                @endforelse

                @if ($this->remainingCategories->isNotEmpty())
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-linear-to-br from-primary/5 to-secondary/5 border-2 border-dashed border-blue-300 dark:border-accent shadow-sm hover:shadow-shadow-primary transition-all duration-200"
                        wire:key="add-category-form">
                        <div class="flex-1">
                            <x-ui.select wire:model.live="selectedCategory" :disabled="!$this->remainingCategories->isNotEmpty()">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($this->remainingCategories as $availCat)
                                    <option value="{{ $availCat->slug }}">{{ $availCat->name }}</option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('selectedCategory')" />
                        </div>
                        <button
                            x-on:click="Livewire.dispatch('saveGameCategory'); Livewire.dispatch('openConfigModal', '{{ $selectedCategory }}')"
                            wire:loading.attr="disabled" wire:target="openConfigModal"
                            class="px-6 py-3 bg-linear-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                            type="button" @if (!$selectedCategory) disabled @endif>
                            <svg wire:loading.remove wire:target="openConfigModal" class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg wire:loading wire:target="openConfigModal" class="animate-spin h-5 w-5"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Configure') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif


        @if ($this->categories->isNotEmpty())
            <div
                class="mt-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
                <div class="flex items-center justify-between text-sm flex-wrap gap-2">
                    <span class="font-semibold text-blue-900 dark:text-blue-300">
                        {{ __('Configured Categories') }}:
                        <span class="text-lg">{{ $this->gameCategories->count() }}</span> /
                        <span class="text-lg">{{ $this->categories->count() }}</span>
                    </span>
                    @if ($this->gameCategories->count() === $this->categories->count())
                        <span class="flex items-center gap-2 text-green-700 dark:text-green-300 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('All Configured!') }}
                        </span>
                    @endif
                </div>

                <!-- Progress Bar -->
                <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-linear-to-r from-blue-500 to-indigo-500 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $this->categories->count() > 0 ? ($this->gameCategories->count() / $this->categories->count()) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Configuration Modal -->
    @if ($showConfigModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showConfigModal') }" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeConfigModal"></div>

            <!-- Modal Content -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl"
                    x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95" @click.stop>

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ __('Configure Category') }}
                            </h3>
                            @if ($configuringCategorySlug)
                                @php
                                    $currentCategory = $this->categories->firstWhere('slug', $configuringCategorySlug);
                                @endphp
                                @if ($currentCategory)
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Category') }}: <span
                                            class="font-semibold text-blue-600 dark:text-blue-400">{{ $currentCategory->name }}</span>
                                    </p>
                                @endif
                            @endif
                        </div>
                        <button wire:click="closeConfigModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="text-center py-12">
                            <svg class="w-20 h-20 mx-auto text-blue-500 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ __('Category Configuration') }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ __('Configure your category settings here. The category has been automatically assigned to this game.') }}
                            </p>

                            <!-- Add your configuration form here -->
                            <div class="mt-8 text-left">
                                <div
                                    class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-semibold text-green-700 dark:text-green-300">
                                            {{ __('Category successfully assigned to game') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Placeholder for future configuration options -->
                                <div
                                    class="mt-6 p-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center">
                                    <p class="text-gray-500 dark:text-gray-400">
                                        {{ __('Additional configuration options will appear here') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                        <button wire:click="closeConfigModal"
                            class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

@push('scripts')
    <script>
        // Alpine.js is assumed to be loaded globally
    </script>
@endpush
