<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Banned User List') }}
            </h2>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No users found. Create your first user to get started." />

    {{-- Band User Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showUnbanUserModal'" :title="'Unban this User?'" :message="'Are you sure you want to unban this user?'" :method="'unbanUser'"
        :button-text="'Confirm Unban User'" />
</section>
