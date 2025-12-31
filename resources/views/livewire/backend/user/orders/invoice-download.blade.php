<div x-data="{ show: false }" 
    x-on:open-modal.window="if ($event.detail === 'download-invoice-modal') show = true"
    x-on:close-modal.window="if ($event.detail === 'download-invoice-modal') show = false"
    x-on:keydown.escape.window="show = false" 
    x-show="show" 
    class="fixed inset-0 z-[9999] overflow-y-auto"
    style="display: none;">

    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-black/20 backdrop-blur-sm transition-opacity z-[9998]"
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false">
    </div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4 relative z-[9999]">
        <div class="relative bg-bg-primary rounded-lg shadow-xl w-full max-w-md" 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
            @click.stop>

            <!-- Header -->
            <div class="flex items-center justify-between p-6 pb-4">
                <h3 class="text-xl font-semibold text-text-white">
                    {{ __('Download your monthly sales invoice') }}
                </h3>
                <button @click="show = false" class="text-text-muted hover:text-white transition-colors">
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
                    <label class="block text-sm font-medium text-muted mb-2">
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
                    <label class="block text-sm font-medium text-muted mb-2">
                        {{ __('File type') }}
                    </label>
                    <x-ui.custom-select wire:model="fileType" class="rounded!">
                        <x-ui.custom-option value="pdf" label="PDF" />
                        <x-ui.custom-option value="csv" label="CSV" />
                    </x-ui.custom-select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-between pt-4">
                    <div @click="show = false" class="flex w-full md:w-auto">
                        <x-ui.button class="w-fit! py-2!">
                            {{ __('Cancel') }}
                        </x-ui.button>
                    </div>
                    <x-ui.button wire:click="downloadInvoice" class="w-fit! py-2!">
                        {{ __('Download invoice') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div>