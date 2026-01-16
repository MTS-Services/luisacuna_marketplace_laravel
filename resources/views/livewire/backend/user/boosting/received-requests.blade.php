<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

               <div class="relative w-full sm:w-60 lg:w-60">

                        <x-ui.custom-select class="rounded!" label="{{ __('All Game') }}">

                             @foreach ($games as $game)

                              <x-ui.custom-option value="{{ $game->id }}" label="{{ $game->translatedName(app()->getLocale()) }}" />

                            @endforeach
                        </x-ui.custom-select>
                    </div>
                    <!-- Status Filter -->
                    <div class="relative w-full sm:w-60 lg:w-60">
                       <x-ui.custom-select class="rounded!" label="Waiting for your offer">

                              <x-ui.custom-option value="in_progress" label="{{ __('In Progress') }}" />
                              <x-ui.custom-option value="completed" label="{{ __('Completed') }}" />
                              <x-ui.custom-option value="disputed" label="{{ __('Disputed') }}" />
                              <x-ui.custom-option value="canceled" label="{{ __('Canceled') }}" />


                        </x-ui.custom-select>
                    </div>
            </div>
            <!-- New Offer Button -->
            <a href="{{ route('user.subscriptions') }}">
                <x-ui.button class="w-full sm:w-fit! py-2!">
                    <span
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Manage Subscriptions') }}</span>
                </x-ui.button>
            </a>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
</div>
