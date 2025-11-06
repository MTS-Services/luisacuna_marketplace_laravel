<x-admin::app>
    <x-slot name="pageSlug">{{__('language')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.language.create')
            <x-slot name="title">{{__('Language Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Language')}}</x-slot>
            <livewire:backend.admin.components.language.create />
        @break

        {{-- @case('admin.am.admin.edit')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.edit :admin="$admin"/>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.trash />
        @break

        @case('admin.am.admin.view')
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.view :admin="$admin"/>
        @break --}}

        @default
            <x-slot name="title">{{__('Language List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Language')}}</x-slot>
            <livewire:backend.admin.components.language.index />
    @endswitch

</x-admin::app>
