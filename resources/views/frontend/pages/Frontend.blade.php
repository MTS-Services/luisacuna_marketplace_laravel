<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('how-to-buy')
            <x-slot name="title">{{ __('How To Buy') }}</x-slot>
            <x-slot name="pageSlug">{{ __('how-to-buy') }}</x-slot>
            <livewire:frontend.frontend.how-to-buy />
        @break

        @case('buyer-protection')
            <x-slot name="title">{{ __('Buyer Protection') }}</x-slot>
            <x-slot name="pageSlug">{{ __('buyer-protection') }}</x-slot>
            <livewire:frontend.frontend.buyer-protection />
        @break

        @case('how-to-sell')
            <x-slot name="title">{{ __('How To Sell') }}</x-slot>
            <x-slot name="pageSlug">{{ __('how-to-sell') }}</x-slot>
            <livewire:frontend.frontend.how-to-sell />
        @break

        @case('seller-protection')
            <x-slot name="title">{{ __('Seller Protection') }}</x-slot>
            <x-slot name="pageSlug">{{ __('seller-protection') }}</x-slot>
            <livewire:frontend.frontend.seller-protection />
        @break

        @case('faq')
            <x-slot name="title">{{ __('FAQ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('faq') }}</x-slot>
            <livewire:frontend.frontend.faq />
        @break

        @default
    @endswitch

</x-frontend::app>
