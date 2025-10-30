<x-frontend::app>
    <x-slot name="title">Order</x-slot>
  
    @switch(Route::currentRouteName())
        @case('om.cancel')
            <x-slot name="pageSlug">cancel-order</x-slot>
              <livewire:frontend.components.orders.cancel />
        @break
        @case('om.chat-help')
            <x-slot name="pageSlug">oder-help</x-slot>
              <livewire:frontend.components.orders.chat-help />
        @break
        @case('om.chat-help-two')
            <x-slot name="pageSlug">oder-help</x-slot>
              <livewire:frontend.components.orders.chat-help-two />
        @break
        @case('om.chat-help-three')
            <x-slot name="pageSlug">oder-help</x-slot>
              <livewire:frontend.components.orders.chat-help-three />
        @break
        @case('om.complete')
            <x-slot name="pageSlug">order-complete</x-slot>
              <livewire:frontend.components.orders.complete />
        @break

        @default
             <x-slot name="pageSlug">Oders</x-slot>
            <livewire:frontend.components.orders.index />

    @endswitch
</x-frontend::app>