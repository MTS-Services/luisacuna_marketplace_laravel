<x-admin::app>
    <x-slot name="pageSlug">{{ __('role') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.role.create')
            <x-slot name="title">{{ __('Roles Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Role Create') }}</x-slot>
            <livewire:backend.admin.admin-management.role.create />
        @break

        @case('admin.am.role.edit')
            <x-slot name="title">{{ __('Roles Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Role Edit') }}</x-slot>
            <livewire:backend.admin.admin-management.role.edit :data="$data" />
        @break

        @case('admin.am.role.trash')
            <x-slot name="title">{{ __('Roles Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Role Trash') }}</x-slot>
            <livewire:backend.admin.admin-management.role.trash />
        @break

        @case('admin.am.role.view')
            <x-slot name="title">{{ __('Roles View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Role View') }}</x-slot>
            <livewire:backend.admin.admin-management.role.view :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Roles List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Role List') }}</x-slot>
            <livewire:backend.admin.admin-management.role.index />
    @endswitch

</x-admin::app>
