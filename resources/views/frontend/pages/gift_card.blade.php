<x-frontend::app>
    <x-slot name="title">Gift Card</x-slot>
    <x-slot name="pageSlug">gift-card</x-slot>

    @switch(Route::currentRouteName())
        @case('gift-card.seller-list')
            <livewire:frontend.components.gift-cards.gift-card-seller-list />
        @break

        @case('game.checkout')
            <livewire:frontend.components.gift-cards.check-out />
        @break

        @default
            <livewire:frontend.components.gift-cards.gift-card />
    @endswitch
</x-frontend::app>
