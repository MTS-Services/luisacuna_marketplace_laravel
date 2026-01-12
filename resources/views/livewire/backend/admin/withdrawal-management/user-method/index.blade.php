<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('User Methods List') }}
            </h2>
        </div>
    </div>


    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

    
    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be delete to permanently.'" :method="'delete'"
        :button-text="'Delete Data'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected data(s)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />
</div>
