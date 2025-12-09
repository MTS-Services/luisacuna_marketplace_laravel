<x-user::app>
    @switch(Route::currentRouteName())
        @case('user.order.purchased-orders')
            <x-slot name="title">{{ __('Purchased Orders') }}</x-slot>
            <x-slot name="pageSlug">{{ __('purchased_orders') }}</x-slot>
            <livewire:backend.user.orders.purchased-orders />
        @break

        @case('user.order.sold-orders')
            <x-slot name="title">{{ __('Sold Orders') }}</x-slot>
            <x-slot name="pageSlug">{{ __('sold_orders') }}</x-slot>
            <livewire:backend.user.orders.sold-orders />
        @break
        

        @default
    @endswitch
</x-user::app>