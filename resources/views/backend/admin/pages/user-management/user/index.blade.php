<x-admin::app>
    <x-slot name="pageSlug">User Management</x-slot>
    <x-slot name="breadcrumb">User Management</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.admin.create')
            <x-slot name="title">User Create</x-slot>
            <p>Create User View</p>
        @break

        @case('admin.am.admin.edit')
            <x-slot name="title">User Create</x-slot>
            <p>Edit User View</p>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">User Create</x-slot>
            <p>Trash User View</p>
        @break

        @default
            <x-slot name="title">Users List</x-slot>
            <livewire:backend.admin.components.user-management.user.index />
    @endswitch

</x-admin::app>
