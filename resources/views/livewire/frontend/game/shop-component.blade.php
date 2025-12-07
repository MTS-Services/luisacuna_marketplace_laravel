<main class="mx-auto">
    {{-- @if ($categorySlug == 'gift-card' || $categorySlug == 'top-up') --}}


    @if ($layoutView == 'list_grid')

    <x-grid-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug" :datas="$datas" :game="$game" />

    @else

    {{-- <x-list-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug"/>  --}}

    @endif
</main>
