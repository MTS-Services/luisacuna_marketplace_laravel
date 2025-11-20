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

        @case('terms-and-conditions')
            <x-slot name="title">{{ __('Terms & Conditions') }}</x-slot>
            <x-slot name="pageSlug">{{ __('terms-and-conditions') }}</x-slot>
            <livewire:frontend.frontend.terms-conditions />
        @break

        @case('privacy-policy')
            <x-slot name="title">{{ __('Privacy Policy') }}</x-slot>
            <x-slot name="pageSlug">{{ __('privacy-policy') }}</x-slot>
            <livewire:frontend.frontend.privacy-policy />
        @break

        @case('refund-policy')
            <x-slot name="title">{{ __('refund policy') }}</x-slot>
            <x-slot name="pageSlug">{{ __('refund-policy') }}</x-slot>
            <livewire:frontend.frontend.refund-policy />
        @break

        @case('contact-us')
            <x-slot name="title">{{ __('Contact') }}</x-slot>
            <x-slot name="pageSlug">{{ __('Contact Us') }}</x-slot>
            <livewire:frontend.frontend.contact-us />
        @break

        @default
    @endswitch

</x-frontend::app>
