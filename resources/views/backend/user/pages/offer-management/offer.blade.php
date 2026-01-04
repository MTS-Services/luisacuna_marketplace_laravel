<x-frontend::app>
     <x-slot name="pageSlug">{{__('offer')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('user.offer.edit')
            <livewire:backend.user.offers.edit :encrypted_id="$encrypted_id"/>
            @break
    
        @default
            <livewire:backend.user.offers.offer />
    @endswitch
</x-frontend::app>