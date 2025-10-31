<x-frontend::app>
    

    @switch(Route::currentRouteName())
        @case('game.index')
            <x-slot name="title">Game {{ucfirst(str_replace('-',' ',$gameSlug))}} Shop</x-slot>
            <x-slot name="pageSlug">game-{{$categorySlug}}-Shop</x-slot>
            <x-slot name="gameSlug">{{$gameSlug}}</x-slot>
            <x-slot name="categorySlug">{{$categorySlug}}</x-slot>
            <livewire:frontend.game.shop-component :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
        @break
        {{-- @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'currency')
            <livewire:frontend.game.currency.currency-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'items')
            <livewire:frontend.game.item.item-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'accounts')
            <livewire:frontend.game.account.account-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'boosting')
            <livewire:frontend.game.boosting.boosting-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'topups')
            <livewire:frontend.game.topup.topup-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'coaching')
            <livewire:frontend.game.coaching.coaching-shop-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'gift-cards')
            <livewire:frontend.game.gift-card.gift-card-shop-component :gameSlug="$slug" />
        @break --}}

        @default

    @endswitch
</x-frontend::app>