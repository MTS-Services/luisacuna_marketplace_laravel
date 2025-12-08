<x-frontend::app>
    <x-slot name="title">{{ ucfirst($categorySlug) }}</x-slot>
    <x-slot name="pageSlug">{{ $categorySlug }}</x-slot>
    <livewire:frontend.product :categorySlug="$categorySlug" />
</x-frontend::app>