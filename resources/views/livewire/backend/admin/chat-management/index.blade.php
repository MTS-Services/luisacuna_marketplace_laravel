<section>
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Chat List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                {{-- <x-ui.button href="{{ route('admin.alm.audit.trash') }}" type='secondary' class="flex-1 sm:flex-none">
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Trash') }}</span>
                </x-ui.button> --}}
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions"
         :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="false" emptyMessage="No admins found. Create your first admin to get started." />
</section>
