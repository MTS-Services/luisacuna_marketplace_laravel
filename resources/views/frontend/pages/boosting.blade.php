<x-frontend::app>
    <x-slot name="title">{{__('Boosting')}}</x-slot>
    <x-slot name="pageSlug">{{__('boosting')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('boost.seller-list')
            <livewire:frontend.boostings.boosting-seller-list />
        @break

        @case('boost.buy-now')
            <livewire:frontend.boostings.boosting-buy-now />
        @break

        @case('boost.checkout')
            <livewire:frontend.boostings.boosting-checkout />
        @break

        @case('boost.subscribe')
            <livewire:frontend.components.boostings.boosting-subscribe />
        @break

        @default
            <livewire:frontend.boostings.boosting />
    @endswitch
</x-frontend::app>
