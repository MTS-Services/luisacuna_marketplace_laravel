<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Product List') }}
            </h2>
        </div>
    </div>




    {{-- Table Component --}}
    <x-ui.table :data="$categories" :columns="$columns" :actions="$actions"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="false" emptyMessage="No Category found. Create your first admin to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this Category?'" :message="'Are you absolutely sure you want to remove this Category? All associated data will be permanently deleted.'" :method="'delete'"
        :button-text="'Delete Category'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected category(ies)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />

        
</section>