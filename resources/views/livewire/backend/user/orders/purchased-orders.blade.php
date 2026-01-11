<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
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

    </div>

    <div>
        <x-ui.user-table :data="$datas" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>

</div>
