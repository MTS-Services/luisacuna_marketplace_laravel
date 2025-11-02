<x-frontend::app>
    <x-slot name="title">Seller Verification</x-slot>
    <x-slot name="pageSlug">sellerverification</x-slot>

    @switch(Route::currentRouteName())
        @case('boost.seller-list')
            <livewire:frontend.components.boostings.boosting-seller-list />
        @break

        @default
        <livewire:frontend.seller-verifications.seller-verification-step1 />

    @endswitch
</x-frontend::app>
