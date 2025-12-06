<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All Game') }}</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </x-ui.select>
                </div>
            </div>

            <!-- Right Side: Search & Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                <!-- Export Button -->
                <x-ui.button variant="secondary" class="sm:w-auto! py-2!" x-data
                    @click="$dispatch('open-modal', 'export')">
                    <x-phosphor-download class="w-5 h-5 fill-accent group-hover:fill-white" />
                    <span class="text-text-btn-secondary group-hover:text-text-btn-primary">{{ __('Export') }}</span>
                </x-ui.button>

                <!-- New Offer Button -->
                <x-ui.button class="w-full sm:w-auto! py-2!">
                    <x-phosphor-plus class="w-5 h-5 fill-text-text-white group-hover:fill-accent" />
                    <a wire.navigate href="{{ route('user.offers') }}"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('New Offer') }}</a>
                </x-ui.button>

            </div>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns" :actions="$actions"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be permanently deleted.'" :method="'delete'"
        :button-text="'Delete Data'" />


    <!-- Export Modal -->
    <div x-data="{ show: false }" x-on:open-modal.window="if ($event.detail === 'export') show = true"
        x-on:close-modal.window="if ($event.detail === 'export') show = false" x-on:keydown.escape.window="show = false"
        x-show="show" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-zinc-900/90 transition-opacity" x-show="show"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="show = false">
        </div>

        <!-- Modal Content -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-zinc-900 rounded-lg shadow-xl w-full max-w-md" x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop>

                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4">
                    <h3 class="text-xl font-semibold text-white">
                        {{ __('Download your monthly sales invoice') }}
                    </h3>
                    <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 pb-6 space-y-4">
                    <!-- Month Selection -->
                    <div class="relative w-full">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Choose a month') }}
                        </label>
                        <x-ui.select>
                            <option value="">{{ __('January 2025') }}</option>
                            <option value="">{{ __('February 2025') }}</option>
                            <option value="">{{ __('March 2025') }}</option>
                            <option value="">{{ __('April 2025') }}</option>
                            <option value="">{{ __('May 2025') }}</option>
                            <option value="">{{ __('June 2025') }}</option>
                            <option value="">{{ __('July 2025') }}</option>
                            <option value="">{{ __('August 2025') }}</option>
                            <option value="">{{ __('September 2025') }}</option>
                            <option value="">{{ __('October 2025') }}</option>
                            <option value="">{{ __('November 2025') }}</option>
                            <option value="">{{ __('December 2025') }}</option>
                        </x-ui.select>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-between pt-4">
                        <div class="flex w-full md:w-auto">
                            <x-ui.button class="w-fit! py!" @click="show = false">
                                {{ __('Cancel') }}
                            </x-ui.button>
                        </div>
                        <div class="flex w-full md:w-auto">
                            <x-ui.button class="w-fit! py!" @click="show = false">
                                {{ __('Export Now') }}
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copyToClipboard', (event) => {
                navigator.clipboard.writeText(event[0].url)
                    .then(() => {
                        Livewire.dispatch('notify', {
                            type: 'success',
                            message: 'Link copied to clipboard!'
                        });
                    })
                    .catch(err => {
                        console.error('Copy failed:', err);
                    });
            });
        });
    </script>
</div>
