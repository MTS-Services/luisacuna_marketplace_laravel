<x-frontend::app>
    <x-slot name="title">Order</x-slot>
  
    @switch(Route::currentRouteName())
        @case('om.cancel')
            <x-slot name="pageSlug">cancel-order</x-slot>
              <livewire:frontend.components.orders.cancel />
        @break

        @default
             <x-slot name="pageSlug">Oders</x-slot>
            <livewire:frontend.components.orders.index />

    @endswitch
</x-frontend::app>