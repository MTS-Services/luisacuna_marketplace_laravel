<x-frontend::app>
    <x-slot name="pageSlug">{{ __('user_profile') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.am.admin.view')
            <x-slot name="title">{{ __('Admins View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Admin Management > Admin View') }}</x-slot>
            <livewire:backend.admin.admin-management.admin.view :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('User Profile') }}</x-slot>
             <livewire:backend.user.profile.profile-component />
    @endswitch
</x-frontend::app>
