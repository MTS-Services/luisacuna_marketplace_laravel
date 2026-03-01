<x-admin::app>
    <x-slot name="pageSlug">payment-gateway</x-slot>

    <x-slot name="title">{{ __('Payment Gateway') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Payment Gateway') }} </x-slot>
    <livewire:backend.admin.payment-gateway.index />
    <livewire:backend.admin.payment-gateway.edit />


</x-admin::app>
