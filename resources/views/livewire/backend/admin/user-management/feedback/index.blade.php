<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Feedback List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                 <x-ui.button href="{{ route('admin.um.user.create')}}" class="w-auto py-2!">
                    <flux:icon name="user-plus"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>

                
            </div>
        </div>
    </div>

    {{-- Table Component --}}

    <x-ui.table :data="$datas" :columns="$columns"
        :types="$types" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="false" emptyMessage="No users found. Create your first user to get started." />
</section>
