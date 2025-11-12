<x-admin::app>
    <x-slot name="pageSlug">{{ __('general-settings') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Application Settings > General Settings') }}</x-slot>
    <x-slot name="title">{{ __('General Settings') }}</x-slot>
    <livewire:backend.admin.settings.general-settings.general-settings-component />
</x-admin::app>
