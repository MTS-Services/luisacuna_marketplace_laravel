<x-frontend::app>
    <x-slot name="title">{{  __("Become a seller ") }}</x-slot>
    <x-slot name="pageSlug">{{ __('become-seller') }}</x-slot>
    @switch($step)
        @case(1)
            <livewire:backend.user.seller.seller-verification-first-step />
            @break 
        @case(2)
        <livewire:backend.user.seller.seller-verification-second-step />
        @break
        @case(3)
        <livewire:backend.user.seller.seller-verification-third-step />
        @break
    
        @default
        <livewire:backend.user.seller.seller-verification />
    @endswitch
    
</x-frontend::app>