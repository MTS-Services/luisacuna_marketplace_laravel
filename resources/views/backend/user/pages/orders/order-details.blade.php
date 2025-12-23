<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('user.order.detail')
            <x-slot name="title">{{ __('Order description') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_description') }}</x-slot>
            <livewire:backend.user.orders.ongoing-order.description :order="$orderId" />
        @break

        @case('user.order.cancel')
            <x-slot name="title">{{ __('Order description') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_description') }}</x-slot>
            <livewire:backend.user.orders.order-canceled-details :order="$orderId" />
        @break

        @case('user.order.complete')
            <x-slot name="title">{{ __('Order description') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_description') }}</x-slot>
            <livewire:backend.user.orders.ongoing-order.details :order="$orderId" />
        @break

        @default
    @endswitch
</x-frontend::app>
