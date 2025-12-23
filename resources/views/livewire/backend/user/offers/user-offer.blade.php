<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch md:items-center gap-3 md:gap-4">

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 w-full md:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-60">
                        <x-ui.custom-select class="rounded!" label="All Game">
                            <x-ui.custom-option label="January 2025" />
                            <x-ui.custom-option label="February 2025" />
                            <x-ui.custom-option label="March 2025" />
                        </x-ui.custom-select>
               </div>
                  <!-- Game Filter -->
               <div class="relative w-full sm:w-60">
                        <x-ui.custom-select class="rounded!" label="All ">
                            <x-ui.custom-option label="January 2025" />
                            <x-ui.custom-option label="February 2025" />
                            <x-ui.custom-option label="March 2025" />
                        </x-ui.custom-select>
               </div>

                <div class="relative w-full sm:w-60">
                    <x-ui.input type="text" placeholder="{{ __('Search') }}" class="pl-5 py-2! text-text-white rounded! placeholder:text-text-primary border-zinc-500"
                        wire:model.live.debounce.300ms="search" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-auto flex items-center gap-2 justify-between">
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
        <x-ui.user-table :data="$datas" :columns="$columns" :actions="$actions" searchProperty="search"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>


    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be permanently deleted.'" :method="'deleteProduct'"
        :button-text="'Delete Data'" />

    @push('script')
        {{-- <script>
            window.addEventListener('copy-link', event => {
                navigator.clipboard.writeText(event.detail.url)
                    .then(() => {
                        alert("Link copied!");
                    })
                    .catch(err => {
                        console.log("Copy failed", err);
                    });
            });
        </script> --}}

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
