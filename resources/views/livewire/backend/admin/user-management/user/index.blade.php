<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('User List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.um.user.trash') }}" variant='tertiary' class="w-auto py-2!">
                    <flux:icon name="trash"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Trash') }}
                </x-ui.button>

                <x-ui.button href="{{ route('admin.um.user.create') }}" class="w-auto py-2!">
                    <flux:icon name="user-plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Add') }}
                </x-ui.button>


            </div>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No users found. Create your first user to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="__('Delete this User?')" :message="__('Are you absolutely sure you want to remove this user? All associated data will be permanently deleted.')" :method="'delete'"
        :button-text="__('Delete User')" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="__('Confirm Bulk Action')" :message="__('Are you sure you want to perform this action on :count selected user(s)?', ['count' => count($selectedIds)])" :method="'executeBulkAction'"
        :button-text="__('Confirm Action')" />

    {{-- Band User Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBandUserModal'" :title="__('Band this User?')" :message="__('Set ban reason and duration for this user.')" :method="'bandUser'"
        :button-text="__('Confirm Ban')" :inputs="[
            [
                'model' => 'banReason',
                'label' => __('Ban reason'),
                'placeholder' => __('Enter ban reason'),
                'required' => true,
                'type' => 'text',
            ],
            [
                'model' => 'banPermanent',
                'label' => __('Permanent ban'),
                'type' => 'checkbox',
            ],
            [
                'model' => 'banDate',
                'label' => __('Ban until date'),
                'type' => 'date',
                'depends_on' => 'banPermanent',
                'disable_when_true' => true,
            ],
            [
                'model' => 'banTime',
                'label' => __('Ban until time'),
                'type' => 'time',
                'depends_on' => 'banPermanent',
                'disable_when_true' => true,
            ],
        ]" />
</section>
