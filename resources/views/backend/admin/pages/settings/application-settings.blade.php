<x-admin::app>
    {{-- <x-slot name="pageSlug">{{ __('general-settings') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Application Settings > General Settings') }}</x-slot>
    <x-slot name="title">{{ __('General Settings') }}</x-slot>
    <livewire:backend.admin.settings.general-settings.general-settings /> --}}

    @switch(Route::currentRouteName())
        @case('admin.as.general-settings')
            <x-slot name="pageSlug">general-settings</x-slot>
            <x-slot name="breadcrumb">{{ __('Application Settings - General') }}</x-slot>
            <x-slot name="title">{{ __('General Settings') }}</x-slot>
            <livewire:backend.admin.settings.general-settings />
        @break

        @default
    @endswitch
</x-admin::app>
