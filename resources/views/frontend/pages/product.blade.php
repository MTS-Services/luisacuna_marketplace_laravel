<x-frontend::app>
    <x-slot name="title">{{__('Currency')}}</x-slot>
    <x-slot name="pageSlug">{{__('currency')}}</x-slot>
    <livewire:frontend.product :categorySlug="$categorySlug" />
</x-frontend::app>