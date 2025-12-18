<main class="overflow-x-hidden bg-light-bg dark:bg-dark-bg">
   


    @if ($layoutView == 'list_grid')

    <livewire:frontend.product.grid-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug"  />

    @else

    <livewire:frontend.product.list-layout :gameSlug="$gameSlug" :categorySlug="$categorySlug" :datas="$datas" :game="$game" />
   
    @endif
</main>
