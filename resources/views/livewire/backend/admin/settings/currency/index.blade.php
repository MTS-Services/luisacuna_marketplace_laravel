<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Currency List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.as.currency.trash') }}" variant='tertiary' class="w-auto py-2!">
                    <flux:icon name="trash"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Trash') }}
                </x-ui.button>
                <x-ui.button href="{{ route('admin.as.currency.create') }}" class="w-auto py-2!">
                    <flux:icon name="plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Add') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No data found. Create your first data to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be moved to trash.'" :method="'delete'"
        :button-text="'Delete Data'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected data(s)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />

    {{-- Set Default Currency Modal --}}
    @if($showDefaultModal)
        <div x-data="{ show: true }" 
             x-init="$watch('show', value => { if(!value) @this.set('showDefaultModal', false) })"
             x-show="show" 
             style="display: none;"
             x-cloak
             class="fixed inset-0 z-50 bg-gray-500/50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background Overlay --}}
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0"
                     class="fixed  transition-opacity  bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75"
                     @click="show = false"></div>

                {{-- Modal Content --}}
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">

                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30">
                                <flux:icon name="currency-dollar" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('Set Default Currency') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ __('Change your default currency') }}
                                </p>
                            </div>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <flux:icon name="x-mark" class="w-5 h-5" />
                        </button>
                    </div>

                    {{-- Warning Message --}}
                    @if($currentDefaultCurrency)
                        <div class="p-4 mb-6 rounded-xl bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200 dark:border-yellow-800">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <flux:icon name="exclamation-triangle" class="w-5 h-5 text-yellow-600 dark:text-yellow-500" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-300 mb-2">
                                        {{ __('Current Default Currency') }}
                                    </h4>
                                    <div class="flex items-center gap-2 mb-3 p-3 rounded-lg bg-white/50 dark:bg-gray-800/50">
                                        <span class="text-2xl">{{ $currentDefaultCurrency->symbol }}</span>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $currentDefaultCurrency->name }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $currentDefaultCurrency->code }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ __('Default') }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                        {{ __('This will be replaced when you confirm the new default currency.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 mb-6 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-start gap-3">
                                <flux:icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ __('No default currency is currently set. This will be set as your primary currency.') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Confirmation Question --}}
                    <div class="mb-6">
                        <p class="text-base text-gray-700 dark:text-gray-300 font-medium">
                            {{ __('Are you sure you want to proceed?') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('This action will update your default currency settings.') }}
                        </p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ui.button @click="show = false" variant="tertiary" class="w-auto! py-2!">
                            <flux:icon name="x-circle" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            {{ __('Cancel') }}
                        </x-ui.button>

                        <x-ui.button wire:click="setAsDefault" class="w-auto! py-2!">
                            <span wire:loading.remove wire:target="setAsDefault">
                                <flux:icon name="check-circle" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            </span>
                            <span wire:loading wire:target="setAsDefault">
                                <flux:icon name="arrow-path" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary animate-spin" />
                            </span>
                            <span wire:loading.remove wire:target="setAsDefault">{{ __('Confirm') }}</span>
                            <span wire:loading wire:target="setAsDefault">{{ __('Processing...') }}</span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>