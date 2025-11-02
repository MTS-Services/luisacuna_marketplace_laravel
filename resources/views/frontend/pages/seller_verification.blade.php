<x-frontend::app>
    <x-slot name="title">Seller Verification</x-slot>
    <x-slot name="pageSlug">sellerverification</x-slot>

    @switch(Route::currentRouteName())
        @case('sellverification2')
            <livewire:frontend.seller-verifications.seller-verification-step2 />
        @break

        @case('sellverification3')
            <livewire:frontend.seller-verifications.seller-verification-step3 />
        @break

        @case('sellverification4')
            <livewire:frontend.seller-verifications.seller-verification-step4 />
        @break

        @case('sellverification5')
            <livewire:frontend.seller-verifications.seller-verification-step5 />
        @break

        @case('sellverification6')
            <livewire:frontend.seller-verifications.seller-verification-step6 />
        @break

        @default
            <livewire:frontend.seller-verifications.seller-verification-step1 />
    @endswitch
</x-frontend::app>
