<x-admin::app>
    <x-slot name="pageSlug">payment-gateway</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gi.pay-g.index')
            <x-slot name="title">{{ __('Payment Gateway') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Payment Gateway') }} </x-slot>
            <livewire:backend.admin.gateway-and-integration.payment.index />
        @break

        @default
    @endswitch

</x-admin::app>
