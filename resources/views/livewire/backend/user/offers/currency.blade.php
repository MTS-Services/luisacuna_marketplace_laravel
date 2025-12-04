<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3 md:gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="relative w-full sm:w-35 lg:w-40 2xl:w-80">
                    <x-ui.select>
                        <option value="">{{ __('All Game') }}</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                <div class="relative w-full sm:w-35 lg:w-40 2xl:w-80">
                    <x-ui.select>
                        <option value="">{{ __('All') }}</option>
                        <option value="game1">{{ __('Active offers') }}</option>
                        <option value="game2">{{ __('Paused offers') }}</option>
                        <option value="game3">{{ __('Closed offers') }}</option>
                    </x-ui.select>
                </div>

            </div>

            <div class="w-full md:w-auto flex items-center gap-2 justify-between">
                <x-ui.button class="w-auto! py-2!" variant="secondary" x-data
                    @click="$dispatch('open-modal', 'export')">
                    <x-phosphor-download class="w-5 h-5 fill-accent group-hover:fill-white" />
                    <span class="text-text-btn-secondary group-hover:text-text-btn-primary">{{ __('Export') }}</span>
                </x-ui.button>
                <a wire.navigate href="{{ route('user.offers') }}">
                    <x-ui.button class="w-auto! py-2!">
                        <x-phosphor-plus class="w-5 h-5 fill-text-text-white group-hover:fill-accent" />
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('New Offer') }}</span>
                    </x-ui.button>
                </a>
            </div>

        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns" :actions="$actions"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                    wire:click="$set('showDeleteModal', false)"></div>

                {{-- Modal panel --}}
                <div
                    class="inline-block align-bottom bg-bg-primary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-bg-primary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-text-white" id="modal-title">
                                    {{ __('Delete Item') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-text-muted">
                                        {{ __('Are you sure you want to delete this item? This action cannot be undone.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-secondary px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="button" wire:click="deleteItem"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Delete') }}
                        </button>
                        <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-zinc-700 shadow-sm px-4 py-2 bg-bg-primary text-base font-medium text-text-white hover:bg-bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif



    <!-- Download Invoice Modal -->
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
</div>
