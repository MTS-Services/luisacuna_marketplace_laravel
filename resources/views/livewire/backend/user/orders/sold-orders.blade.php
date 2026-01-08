<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">

            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select wire-model="status" :wire-live="true" class="rounded!" label="All Statuses">
                        @foreach ($statuses as $status)
                            <x-ui.custom-option label="{{ $status['label'] }}" value="{{ $status['value'] }}" />
                        @endforeach
                    </x-ui.custom-select>
                </div>


                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select wire-model="order_date" :wire-live="true" class="rounded!" label="Recent">

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

            <x-ui.button class="w-fit! py-2!" wire:click="downloadInvoice" wire:loading.attr="disabled">
                <x-phosphor-download class="w-5 h-5" />
                {{ __('Download invoice') }}
            </x-ui.button>

            {{-- <div class="flex w-full md:w-auto">
                <x-ui.button class="w-fit! py-2!" x-data @click="$dispatch('open-modal', 'download-invoice-modal')">
                    <x-phosphor-download
                        class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Download invoice') }}
                </x-ui.button>
            </div> --}}

        </div>
    </div>
    <div>

        <x-ui.user-table :data="$datas" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>


    <!-- Download Invoice Modal -->

    {{-- <livewire:backend.user.orders.invoice-download /> --}}
</div
