<x-frontend::app>
    <x-slot name="title">{{__('Items')}}</x-slot>
    <x-slot name="pageSlug">{{__('items')}}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.components.items />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
