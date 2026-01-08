<x-admin::app>
    <x-slot name="pageSlug">{{ __('profile') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.profile.edit')
            <x-slot name="title">{{ __('Profile Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Profile Edit') }}</x-slot>
            <livewire:backend.admin.profile-management.edit :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{ __('Profile Management > Profile') }}</x-slot>
            <x-slot name="title">{{ __('Profile') }}</x-slot>
            <livewire:backend.admin.profile-management.index />
    @endswitch

</x-admin::app>