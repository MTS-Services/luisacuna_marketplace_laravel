<x-admin::app>
    <x-slot name="pageSlug">admin</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.admin.create')
            <x-slot name="title">Admins Create</x-slot>
            <x-slot name="breadcrumb">Admin Management</x-slot>
            <livewire:backend.admin.components.admin-management.admin.create />
        @break

        @case('admin.am.admin.edit')
            <x-slot name="title">Admins Edit</x-slot>
            <x-slot name="breadcrumb">Admin Management</x-slot>
            <livewire:backend.admin.components.admin-management.admin.edit :data="$data"/>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">Admins Trash</x-slot>
            <x-slot name="breadcrumb">Admin Management</x-slot>
            <livewire:backend.admin.components.admin-management.admin.trash />
        @break

        @case('admin.am.admin.view')
            <x-slot name="title">Admins View</x-slot>
            <x-slot name="breadcrumb">Admin Management</x-slot>
            <livewire:backend.admin.components.admin-management.admin.view :data="$data"/>
        @break

        @default
            <x-slot name="title">Admins List</x-slot>
            <x-slot name="breadcrumb">Admin Management</x-slot>
            <livewire:backend.admin.components.admin-management.admin.index />
    @endswitch

</x-admin::app>
