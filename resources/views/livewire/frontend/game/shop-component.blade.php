<main class="overflow-x-hidden bg-page">
   


    @if ($layoutView == 'list_grid')

    <livewire:frontend.product.grid-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug"  />

    @else

    <livewire:frontend.product.list-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug"/>
   
    @endif
</main>
