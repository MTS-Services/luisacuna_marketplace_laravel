<x-frontend::app>
    <x-slot name="pageSlug">{{ __('order_details') }}</x-slot>
    <livewire:backend.user.orders.order-details :orderId="$orderId" />
</x-frontend::app>