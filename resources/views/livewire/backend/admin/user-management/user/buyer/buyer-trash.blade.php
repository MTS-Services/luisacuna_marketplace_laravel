<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Buyer Trash List') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.all-buyer') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No Buyers found. Create your first buyer to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this Buyer?'" :message="'Are you absolutely sure you want to remove this buyer? All associated data will be permanently deleted.'" :method="'forceDelete'"
        :button-text="'Delete Buyer'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected buyer(s)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />
</section>