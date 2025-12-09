<x-user::app>

    <x-slot name="title">{{  ucfirst(str_replace('-', ' ', $categorySlug)) }}</x-slot>
    <x-slot name="pageSlug">{{ $categorySlug }}</x-slot>

    {{-- Pass full category object if needed --}}
    <livewire:backend.user.offers.user-offer :categorySlug="$categorySlug" />
</x-user::app>
