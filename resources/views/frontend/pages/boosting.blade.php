<x-frontend::app>
    <x-slot name="title">Boosting</x-slot>
    <x-slot name="pageSlug">boosting</x-slot>
    @switch(Route::currentRouteName())
        @case('boost.seller-list')
            <livewire:frontend.components.boostings.boosting-seller-list />
        @break

        @case('boost.buy-now')
            <livewire:frontend.components.boostings.boosting-buy-now />
        @break

        @case('boost.checkout')
            <livewire:frontend.components.boostings.boosting-checkout />
        @break

        @default
            <livewire:frontend.components.boostings.boosting />
    @endswitch
</x-frontend::app>
