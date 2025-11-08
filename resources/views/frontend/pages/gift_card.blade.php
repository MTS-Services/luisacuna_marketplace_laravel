<x-frontend::app>
    <x-slot name="title">{{__('Gift Card')}}</x-slot>
    <x-slot name="pageSlug">{{__('gift-card')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('gift-card.seller-list')
            <livewire:frontend.gift-cards.gift-card-seller-list />
        @break

        @case('game.checkout')
            <livewire:frontend.gift-cards.check-out />
        @break

        @default
            <livewire:frontend.gift-cards.gift-card />
    @endswitch
</x-frontend::app>
