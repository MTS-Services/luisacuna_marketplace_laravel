<x-frontend::app>
    <x-slot name="title">Gift Card</x-slot>
    <x-slot name="pageSlug">gift-card</x-slot>

    @switch(Route::currentRouteName())
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'currency')
            <livewire:frontend.game.currency.currency-buy-component :gameSlug="$slug" />
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'items')

        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'accounts')
   
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'boosting')
   
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'topups')
   
        @break
        @case('game.index' && request()->has('game-category') && request()->get('game-category') == 'coaching')
   
        @break

        @default

    @endswitch
</x-frontend::app>