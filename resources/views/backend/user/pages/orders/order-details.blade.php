<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('user.order.detail')
            <x-slot name="title">{{ __('Order Details') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_details') }}</x-slot>
            <livewire:backend.user.orders.details :order="$orderId" />
        @break

        @case('user.order.cancel')
            <x-slot name="title">{{ __('Order Canceled') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_canceled') }}</x-slot>
            <livewire:backend.user.orders.canceled :order="$orderId" />
        @break

        @case('user.order.complete')
            <x-slot name="title">{{ __('Order Completed') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_completed') }}</x-slot>
            <livewire:backend.user.orders.complete :order="$orderId" />

        @break

        @default
    @endswitch
</x-frontend::app>
