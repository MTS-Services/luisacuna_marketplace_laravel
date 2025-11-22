<section x-data="{
    'showCreateModal': @entangle('showCreateModal').live,
    'showEditModal': @entangle('showEditModal').live
}">
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Achievement List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.rm.achievementType.trash') }}" variant='tertiary' class="w-auto py-2!">
                    <flux:icon name="trash"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Trash') }}
                </x-ui.button>
                <x-ui.button x-on:click="showCreateModal = true" class="w-auto py-2!">
                    <flux:icon name="plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Add') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage" :showBulkActions="true"
        emptyMessage="No data found. Create your first data to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this data?'" :message="'Are you absolutely sure you want to remove this data? All associated data will be moved to trash.'" :method="'delete'"
        :button-text="'Delete Data'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected data(s)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />




    {{-- Create Modal --}}

    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto bg-bg-primary/70"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
        <div class="text-center min-h-screen flex items-center justify-center max-w-lg w-full mx-auto">
            <div class="glass-card rounded-2xl p-6 mb-6 w-full">
                <flux:icon name="x-circle"
                    class="w-6 h-6 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary absolute top-4 right-4"
                    x-on:click="showCreateModal = false" />
                @if ($showCreateModal)
                    <livewire:backend.admin.reward-management.achievement-type.create />
                @endif
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}

    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto bg-bg-primary/70"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
        <div class="text-center min-h-screen flex items-center justify-center max-w-lg w-full mx-auto">
            <div class="glass-card rounded-2xl p-6 mb-6 w-full">
                <flux:icon name="x-circle"
                    class="w-6 h-6 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary absolute top-4 right-4"
                    x-on:click="$dispatch('toggleAchievementTypeEditModal')" />
                @if ($achievementType)
                    <livewire:backend.admin.reward-management.achievement-type.edit :data="$achievementType" />
                @endif
            </div>
        </div>
    </div>
</section>
