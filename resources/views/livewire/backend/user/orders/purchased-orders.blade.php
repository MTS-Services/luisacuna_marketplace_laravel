<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
        {{-- <div class="relative" id="dropdown-wrapper">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70">
                <option value="">{{ __('All statuses') }}</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                @endforeach
            </x-ui.select>
            <div id="icon-container" class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div> --}}

        <div class="py-0.5! w-full sm:w-70">
            <x-ui.custom-select :wireModel="'status'" class="rounded!" label="All Statuses">
                @foreach ($statuses as $status)
                    <x-ui.custom-option label="{{ $status['label'] }}" value="{{ $status['value'] }}" />
                @endforeach
            </x-ui.custom-select>
        </div>


        <div class="py-0.5! w-full sm:w-70">
            <x-ui.custom-select :wireModel="'status'" class="rounded!" label="Recent">

               <x-ui.custom-option value="today" label="Today" />
               <x-ui.custom-option value="week" label="This Week" />
               <x-ui.custom-option value="month" label="This Month" />
            </x-ui.custom-select>
        </div>

    </div>

    <div>
        <x-ui.user-table :data="$datas" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>

</div>
