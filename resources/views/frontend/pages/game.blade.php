<x-frontend::app>
    <x-slot name="title">Gift Card</x-slot>
    <x-slot name="pageSlug">gift-card</x-slot>

    @switch(Route::currentRouteName())
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'currency')
            <livewire:frontend.game.currency.currency-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'items')
            <livewire:frontend.game.item.item-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'accounts')
            <livewire:frontend.game.account.account-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'boosting')
            <livewire:frontend.game.boosting.boosting-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'topups')
            <livewire:frontend.game.topup.topup-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'coaching')
            <livewire:frontend.game.coaching.coaching-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'gift-cards')
            <livewire:frontend.game.gift-card.gift-card-buy-component :gameSlug="$slug" />
        @break

        @default

    @endswitch
</x-frontend::app>