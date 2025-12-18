<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('game.index')
            <x-slot name="title">{{ ucfirst(str_replace('-', ' ', $gameSlug)) . ' ' . ucfirst(str_replace('-', ' ', $categorySlug)) }}
                {{__('Shop')}}</x-slot>
            <x-slot name="pageSlug">{{ $gameSlug }}-{{ $categorySlug }}{{__('-shop')}}</x-slot>
            <x-slot name="gameSlug">{{ $gameSlug }}</x-slot>
            <x-slot name="categorySlug">{{ $categorySlug }}</x-slot>
            <livewire:frontend.game.shop-component :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
        @break

        @case('game.buy')
            <x-slot name="title">{{ ucfirst(str_replace('-', ' ', $gameSlug)) . ' ' . ucfirst(str_replace('-', ' ', $categorySlug)) }}
                {{__('Buy')}}</x-slot>
            <x-slot name="pageSlug">{{ $gameSlug }}-{{ $categorySlug }}{{__('-shop')}}</x-slot>
            <x-slot name="gameSlug">{{ $gameSlug }}</x-slot>
            <x-slot name="categorySlug">{{ $categorySlug }}</x-slot>
            <x-slot name="sellerSlug">{{ $productId }}</x-slot>
            <livewire:frontend.game.buy-component :gameSlug="$gameSlug" :categorySlug="$categorySlug" :productId="$productId" />
        @break

        @case('game.checkout')
            <livewire:frontend.game.checkout-component :slug="$slug" :token="$token" />
        @break
        @default
    @endswitch
</x-frontend::app>
