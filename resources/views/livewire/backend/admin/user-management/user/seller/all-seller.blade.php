<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Seller List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                 <x-ui.button href="{{ route('admin.um.user.seller-trash')}}" variant='tertiary' class="w-auto py-2!">
                    <flux:icon name="trash"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Trash') }}
                     </x-ui.button>

                 <x-ui.button href="{{ route('admin.um.user.create')}}" class="w-auto py-2!">
                    <flux:icon name="user-plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Add') }}
                </x-ui.button>

                
            </div>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No sellers found. Create your first seller to get started." />
</section>
