<x-admin::app>
    <x-slot name="pageSlug">{{ __('fee-settings') }}</x-slot>
    <x-slot name="title">{{ __('Fee Settings') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Fee Settings') }}</x-slot>

    <livewire:backend.admin.fee-settings-management.fee-settings />
</x-admin::app>
