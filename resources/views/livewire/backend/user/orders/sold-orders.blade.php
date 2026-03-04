<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select wire-model="status" :wire-live="true" class="rounded!"
                        label="{{ __('All Statuses') }}">
                        @foreach ($statuses as $status)
                            <x-ui.custom-option label="{{ $status['label'] }}" value="{{ $status['value'] }}" />
                        @endforeach
                    </x-ui.custom-select>
                </div>

                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select wire-model="order_date" :wire-live="true" class="rounded!"
                        label="{{ __('Recent') }}">
                        <x-ui.custom-option value="today" label="{{ __('Today') }}" />
                        <x-ui.custom-option value="week" label="{{ __('This Week') }}" />
                        <x-ui.custom-option value="month" label="{{ __('This Month') }}" />
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

            <x-ui.button class="w-fit! py-2!" wire:click="downloadInvoice" wire:loading.attr="disabled">
                <flux:icon name="arrow-down-tray"
                    class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                {{ __('Download invoice') }}
            </x-ui.button>
        </div>
    </div>

    <div>
        <div>
            <x-ui.user-table :data="$datas" :columns="$columns"
                emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
            
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>

        {{-- <div wire:loading wire:target="status,order_date,search,page,perPage,sortField,sortDirection"
            class="rounded-lg border border-zinc-800 bg-zinc-900/40">
            <svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="10"
                    stroke-dasharray="220" stroke-dashoffset="0" transform="rotate(-90 50 50)">
                    <animate attributeName="stroke-dashoffset" dur="1.5s" repeatCount="indefinite"
                        values="0;220;160" keyTimes="0;0.33;1" />
                </circle>
            </svg>
        </div> --}}
    </div>
</div>
