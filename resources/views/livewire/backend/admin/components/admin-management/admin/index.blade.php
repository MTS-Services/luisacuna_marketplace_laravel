<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin List') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.admin.trash') }}" type='secondary'>
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    {{ __('Trash') }}
                </x-ui.button>
                <x-ui.button href="{{ route('admin.am.admin.create') }}">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    {{ __('Add') }}
                </x-ui.button>
            </div>
        </div>
    </div>





    <x-ui.table :data="$admins" :columns="$columns" :actions="$actions" :statuses="$statuses" />
    {{-- <x-ui.table :columns="$columns" :data="$admins" :actions="$actions" search-property="search"
        per-page-property="perPage" empty-message="No admins found." /> --}}

</section>
