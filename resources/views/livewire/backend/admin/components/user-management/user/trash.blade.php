<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Trash List') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :columns="$columns" :selectedIds="$selectedIds" perPageProperty="perPage" :mobileVisibleColumns="2"
        emptyMessage="No users found. Create your first user to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this User?'" :message="'Are you absolutely sure you want to remove this user? All associated data will be permanently deleted.'" :method="'delete'"
        :button-text="'Delete User'" />
</section>
