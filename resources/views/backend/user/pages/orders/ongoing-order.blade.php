<x-frontend::app>
    {{-- @switch(Route::currentRouteName())
        @case('user.OngoingOrder.description')
            <x-slot name="title">{{ __('Order description') }}</x-slot>
            <x-slot name="pageSlug">{{ __('order_description') }}</x-slot>
           <livewire:backend.user.orders.ongoing-order.description />
        @break

        @default
            <x-slot name="title">{{ __('Ongoing Order') }}</x-slot>
            <x-slot name="pageSlug">{{ __('ongoing_order') }}</x-slot>
           <livewire:backend.user.orders.ongoing-order.details />
    @endswitch --}}
</x-frontend::app>