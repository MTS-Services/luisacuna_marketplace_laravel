<x-frontend::app>
    <x-slot name="title">Order</x-slot>
  
    @switch(Route::currentRouteName())
        @case('om.cancel')
            <x-slot name="pageSlug">cancel-order</x-slot>
              <livewire:frontend.components.orders.cancel />
        @break
        @case('om.chat-help')
            <x-slot name="pageSlug">cancel-help</x-slot>
              <livewire:frontend.components.orders.chat-help />
        @break

        @default
             <x-slot name="pageSlug">Oders</x-slot>
            <livewire:frontend.components.orders.index />

    @endswitch
</x-frontend::app>