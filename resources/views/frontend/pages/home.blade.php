<x-frontend::app>
  
    {{-- <x-tiny-m-c-e-config /> --}}
    {{-- <livewire:frontend.components.home /> --}}
    {{-- <livewire:livewire-example /> --}}

    @switch(Route::currentRouteName())
        @case('selling')
            <x-slot name="title">Selling</x-slot>
            <x-slot name="pageSlug">selling</x-slot>
              <livewire:frontend.components.sellings.sell />
        @break
        @case('select-game')
            <x-slot name="title">Select Game</x-slot>
            <x-slot name="pageSlug">select-game</x-slot>
              <livewire:frontend.components.sellings.select-game />
        @break
        @case('sell-currency')
            <x-slot name="title">Select Game</x-slot>
            <x-slot name="pageSlug">select-game</x-slot>
              <livewire:frontend.components.sellings.sell-currency />
        @break
        @default
             <x-slot name="title">Home</x-slot>
             <x-slot name="pageSlug">home</x-slot>
             <livewire:frontend.components.home />

    @endswitch






</x-frontend::app>
