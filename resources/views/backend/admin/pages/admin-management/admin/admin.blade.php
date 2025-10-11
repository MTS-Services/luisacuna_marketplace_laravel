<x-admin::app>
    <x-slot name="pageSlug">Admin Management</x-slot>
    <x-slot name="breadcrumb">Admin Management</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.admin.create')
            <x-slot name="title">Admins Create</x-slot>
            <p>Create Admin View</p>
        @break

        @case('admin.am.admin.edit')
            <x-slot name="title">Admins Create</x-slot>
            <p>Edit Admin View</p>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">Admins Create</x-slot>
            <p>Trash Admin View</p>
        @break

        @default
            <x-slot name="title">Admins List</x-slot>
            <livewire:backend.admin.components.admin-management.admin.index />
    @endswitch

</x-admin::app>
