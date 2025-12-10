<div class="space-y-6">
    <div class="p-4 w-full">
        <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3 md:gap-4">

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 md:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All Game') }}</option>
                        {{-- @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach --}}
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full sm:w-40 md:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All') }}</option>
                        <option value="active">{{ __('Active offers') }}</option>
                        <option value="paused">{{ __('Paused offers') }}</option>
                        <option value="closed">{{ __('Closed offers') }}</option>
                    </x-ui.select>
                </div>

                <!-- Recommended Filter -->
                <div class="relative w-full sm:w-44 md:w-48">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('Recommended') }}</option>
                        <option value="price_low">{{ __('Price: Low to High') }}</option>
                        <option value="price_high">{{ __('Price: High to Low') }}</option>
                        <option value="newest">{{ __('Newest First') }}</option>
                    </x-ui.select>
                </div>

                <!-- Search Input -->
                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="{{ __('Search') }}" class="pl-5 py-1.5! text-text-white" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
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
        <x-ui.user-table :data="$datas" :columns="$columns" :actions="$actions"
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
