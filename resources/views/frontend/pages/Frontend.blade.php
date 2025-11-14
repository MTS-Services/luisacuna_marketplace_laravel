<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('how-to-buy')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:frontend.frontend.how-to-buy />
        @break

        @case('buyer-protection')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:frontend.frontend.buyer-protection />
        @break

        @case('how-to-sell')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:frontend.frontend.how-to-sell />
        @break

        @case('seller-protection')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:frontend.frontend.seller-protection />
        @break

        @case('faq')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:frontend.frontend.faq />
        @break

        @default
    @endswitch

</x-frontend::app>
