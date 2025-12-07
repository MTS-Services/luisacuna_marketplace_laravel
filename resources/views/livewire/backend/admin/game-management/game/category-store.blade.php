<section>
    <!-- Game Information Header -->
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Configuration') }}</h2>
            <x-ui.button href="{{ route('admin.gm.game.edit', encrypt($game->id)) }}" class="w-auto! py-2!">
                <flux:icon name="arrow-left" class="w-4 h-4 stroke-white group-hover:stroke-text-btn-secondary" />
                {{ __('Back') }}
            </x-ui.button>
        </div>
    </div>

    <!-- Game Details Card -->
    <div class="glass-card rounded-2xl p-6 mb-6">
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
    <div class="glass-card rounded-2xl p-6">
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
            <div class="space-y-4">
                @forelse ($this->gameCategories as $category)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-linear-to-br from-hover to-card border border-border shadow-shadow-primary hover:shadow-md transition-all duration-200"
                        wire:key="assigned-category-{{ $category->id }}">
                        <div class="flex-1">
                            <div
                                class="w-full px-4 py-3 rounded-lg border border-green-300 dark:border-green-600 bg-green-50 dark:bg-green-900/20 text-gray-900 dark:text-white font-semibold flex items-center justify-between">
                                <span>{{ $category->name }}</span>
                                <flux:icon name="check-check" class="w-5 h-5 stroke-green-500" />
                            </div>
                        </div>
                        <x-ui.button x-on:click="$dispatch('open-config-modal', { slug: '{{ $category->slug }}' })"
                            class="w-auto! px-6 py-3! bg-linear-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                            type="button">
                            <flux:icon name="cog-8-tooth" class="w-5 h-5 stroke-text-btn-primary" />
                            <span class="text-text-btn-primary">{{ __('Configure') }}</span>
                        </x-ui.button>
                        <x-ui.button variant="tertiary" wire:click="confirmRemoveGameCategory('{{ $category->slug }}')"
                            wire:loading.attr="disabled" wire:target="confirmRemoveGameCategory"
                            class="w-auto! px-6 py-3! rounded-lg" type="button">
                            <flux:icon name="trash"
                                class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            <span
                                class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Remove') }}</span>
                        </x-ui.button>
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
                        <x-ui.button :disabled="!$selectedCategory" wire:click="saveGameCategory" wire:loading.attr="disabled"
                            wire:target="saveGameCategory"
                            class="w-auto! px-6 py-2! bg-linear-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                            type="button">
                            <flux:icon wire:loading.remove wire:target="saveGameCategory" name="diamond-plus"
                                class="w-5 h-5 stroke-text-btn-primary" />
                            <flux:icon wire:loading wire:target="saveGameCategory" name="arrows-pointing-in"
                                class="w-5 h-5 stroke-text-btn-primary animate-spin" />
                            <span class="text-text-btn-primary">{{ __('Add') }}</span>
                        </x-ui.button>
                    </div>
                @endif
            </div>
        @endif

        @if ($this->categories->isNotEmpty())
            <div class="mt-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
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

    <!-- Remove Confirmation Modal -->
    <x-ui.confirmation-modal :show="'showRemoveModal'" :title="'Remove Category?'" :message="'Are you sure you want to remove this category from the game? This action can be reversed later.'" :method="'removeCategory'" :button-text="'Remove Category'"
        button-variant="danger" icon-name="exclamation-triangle" />

    <!-- Config Modal Component -->
    <livewire:backend.admin.game-management.game.config-store :game="$game" />
</section>
