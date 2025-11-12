<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('frontend.buy')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:Frontend.Frontend.Buy />
        @break

        @case('frontend.buyer')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:Frontend.Frontend.Buyer />
        @break

        @case('frontend.sell')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:Frontend.Frontend.Sell />
        @break

        @case('frontend.seller')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:Frontend.Frontend.Sellers />
        @break

        @case('frontend.faq')
            <x-slot name="title">{{ __('frontend') }}</x-slot>
            <x-slot name="pageSlug">{{ __('frontend') }}</x-slot>
            <livewire:Frontend.Frontend.Faq />
        @break

        @default
    @endswitch

</x-frontend::app>
