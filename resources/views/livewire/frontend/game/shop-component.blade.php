<main class="mx-auto">
    {{-- @if ($categorySlug == 'gift-card' || $categorySlug == 'top-up') --}}
    @if (true)

    <x-grid-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug" :datas="$datas"/>

    @else

    <x-list-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug"/> 

    @endif
</main>
