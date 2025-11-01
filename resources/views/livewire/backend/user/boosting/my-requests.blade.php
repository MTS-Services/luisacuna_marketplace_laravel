<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">All Game</option>
                        <option value="game1">Game 1</option>
                        <option value="game2">Game 2</option>
                        <option value="game3">Game 3</option>
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">All Requests</option>
                        <option value="active">In progress</option>
                        <option value="paused">Completed</option>
                        <option value="closed">Disputed</option>
                        <option value="closed">Canceled</option>
                    </x-ui.select>
                </div>
            </div>
            <!-- New Offer Button -->
            <x-ui.button class="w-full sm:w-auto! py-2!">
                <span
                    class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create request') }}</span>
            </x-ui.button>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
</div>
