<x-frontend::app>
    <x-slot name="pageSlug">offer</x-slot>
    @switch(Route::currentRouteName())
        @case('user.offer.edit')
            <livewire:backend.user.offers.edit :encrypted_id="$encrypted_id" />
            @break

        @case('user.offers.create.games')
            <livewire:backend.user.offers.offer-game-select :categorySlug="$categorySlug" :categoryName="$categoryName" />
            @break

        @case('user.offers.create.form')
            <livewire:backend.user.offers.offer-product-form :categorySlug="$categorySlug" :gameSlug="$gameSlug" />
            @break

        @default
            <livewire:backend.user.offers.offer-category-select />
    @endswitch
</x-frontend::app>
