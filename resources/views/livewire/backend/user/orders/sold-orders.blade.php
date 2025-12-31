<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select :wireModel="'status'" class="rounded!" label="All Statuses">
                        @foreach ($statuses as $status)
                            <x-ui.custom-option label="{{ $status['label'] }}" value="{{ $status['value'] }}" />
                        @endforeach
                    </x-ui.custom-select>
                </div>


                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select :wireModel="'created_at'" class="rounded!" label="Recent">

                        <x-ui.custom-option value="today" label="Today" />
                        <x-ui.custom-option value="week" label="This Week" />
                        <x-ui.custom-option value="month" label="This Month" />
                    </x-ui.custom-select>
                </div>

                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" wire:model.live="search" placeholder="{{ __('Search') }}"
                        class="pl-5 border-zinc-500! placeholder:text-text-primary" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div>

            </div>

            <div class="flex w-full md:w-auto">
                <x-ui.button class="w-fit! py-2!" x-data @click="$dispatch('open-modal', 'download-invoice-modal')">
                    <x-phosphor-download
                        class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Download invoice') }}
                </x-ui.button>
            </div>

        </div>
    </div>
    <div>

        <x-ui.user-table :data="$datas" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>


    <!-- Download Invoice Modal -->
    <div x-data="{ show: false }" x-on:open-modal.window="if ($event.detail === 'download-invoice-modal') show = true"
        x-on:close-modal.window="if ($event.detail === 'download-invoice-modal') show = false"
        x-on:keydown.escape.window="show = false" x-show="show" class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-bg-primary transition-opacity" x-show="show"
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
                        <x-ui.custom-select wire:model="selectedMonth" class="rounded!">
                            @foreach ($months as $month)
                                <x-ui.custom-option value="{{ $month['value'] }}" label="{{ $month['label'] }}" />
                            @endforeach
                        </x-ui.custom-select>
                    </div>

                    <!-- File Type Selection -->

                    <div class="relative w-full">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('File type') }}
                        </label>
                        {{-- <x-ui.custom-select class="rounded!">
                            <x-ui.custom-option label="PDF" />
                            <x-ui.custom-option label="CSV" />
                        </x-ui.custom-select> --}}
                        <x-ui.custom-select wire:model="fileType" class="rounded!">
                            <x-ui.custom-option value="pdf" label="PDF" />
                            <x-ui.custom-option value="csv" label="CSV" />
                        </x-ui.custom-select>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-between pt-4">
                        <div @click="show = false" class="flex w-full md:w-auto">
                            <x-ui.button class="w-fit! py-2!" x-data
                                @click="$dispatch('open-modal', 'download-invoice-modal')">
                                {{ __('Cancel') }}
                            </x-ui.button>
                        </div>
                        <x-ui.button wire:click="downloadInvoice" class="w-fit! py-2!">
                            {{ __('Download invoice') }}
                        </x-ui.button>
                        {{-- <div class="flex w-full md:w-auto">
                            <x-ui.button class="w-fit! py-2!" x-data
                                @click="$dispatch('open-modal', 'download-invoice-modal')">
                                {{ __('Download invoice') }}
                            </x-ui.button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div
