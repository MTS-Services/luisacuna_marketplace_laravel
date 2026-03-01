<x-admin::app>
    <x-slot name="pageSlug">payment-gateway</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gi.pay-g.edit')
            <x-slot name="title">{{ __('Configure') }} {{ $gateway->name ?? __('Payment Gateway') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Payment Gateway') }} / {{ __('Configure') }} {{ $gateway->name }}</x-slot>
            <livewire:backend.admin.payment-gateway.edit :gateway-id="$gateway->id" />
        @break
        @default
            <x-slot name="title">{{ __('Payment Gateway') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Payment Gateway') }}</x-slot>
            <livewire:backend.admin.payment-gateway.index />
    @endswitch
</x-admin::app>
