<x-frontend::app>
    <x-slot name="title">Sell Game</x-slot>
    <x-slot name="pageSlug">sellgame</x-slot>
    @switch(Route::currentRouteName())
        @case('sell.delivery')
            <livewire:frontend.components.sellgame.delivery />
        @break

        @case('sell.sellgame')
            <livewire:frontend.components.sellgame.sellgame />
        @break

        @default
            <livewire:frontend.components.sellgame.sellgame />
    @endswitch
</x-frontend::app>



