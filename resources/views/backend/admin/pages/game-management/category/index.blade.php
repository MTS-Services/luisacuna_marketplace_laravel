<x-admin::app>
    <x-slot name="pageSlug">admin</x-slot>
    <x-slot name="breadcrumb">Admin Management</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.category.create')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.create />
        @break

        @default
            <x-slot name="title">Category List</x-slot>
            <livewire:backend.admin.components.game-management.category.index />
    @endswitch

</x-admin::app>
