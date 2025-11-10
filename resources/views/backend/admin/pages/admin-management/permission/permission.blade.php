<x-admin::app>
    <x-slot name="pageSlug">{{ __('permission') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.permission.create')
            <x-slot name="title">{{ __('Permission Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Permission Create') }}</x-slot>
            <livewire:backend.admin.admin-management.permission.create />
        @break

        @case('admin.am.permission.edit')
            <x-slot name="title">{{ __('Permissions Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Permission Edit') }}</x-slot>
            <livewire:backend.admin.admin-management.permission.edit :data="$data" />
        @break

        @case('admin.am.permission.view')
            <x-slot name="title">{{ __('Permissions View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Permission View') }}</x-slot>
            <livewire:backend.admin.admin-management.permission.view :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Permissions List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Permissions List') }}</x-slot>
            <livewire:backend.admin.admin-management.permission.index />
    @endswitch

</x-admin::app>
