<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch md:items-center gap-3 md:gap-4">

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 w-full md:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-60">
                    <x-ui.custom-select wire-model="game_id" :wire-live="true" class="rounded!" label="{{ __('All Game') }}">
                        <x-ui.custom-option label="{{ __('All Game') }}" value="" />

                        @foreach ($games as $game)
                            <x-ui.custom-option label="{{ $game->translatedName(app()->getLocale()) }}" value="{{ $game->id }}" />
                        @endforeach
                    </x-ui.custom-select>
                </div>

                <!-- Game Filter -->
                <div class="py-0.5! w-full sm:w-70">
                    <x-ui.custom-select wire-model="status" :wire-live="true" class="rounded!" label="{{ __('All') }}">
                        @foreach ($statuses as $status)
                            <x-ui.custom-option label="{{ $status['label'] }}" value="{{ $status['value'] }}" />
                        @endforeach
                    </x-ui.custom-select>
                </div>
            </div>

            <div class="w-full lg:w-auto flex items-center gap-2 justify-between">
                <x-ui.button class="w-auto! py-2!" variant="secondary" wire:click="offerExport"
                    wire:loading.attr="disabled">
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
        <x-ui.user-table :data="$datas" :columns="$columns" :actions="$actions" searchProperty="search"
            perPageProperty="perPage" emptyMessage="No data found. Add your first data to get started."
            class="rounded-lg overflow-hidden" />

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>


    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be permanently deleted.'" :method="'deleteProduct'"
        :button-text="'Delete Data'" />

    @push('script')
        <script>
            function copied(url) {

                navigator.clipboard.writeText(url)

                    .then(() => {
                        alert("Copied to clipboard: " + textToCopy);
                    })
                    .catch(err => {
                        console.error("Failed to copy: ", err);
                    });
            }
        </script>
    @endpush
</div>
