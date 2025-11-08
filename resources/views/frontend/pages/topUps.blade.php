<x-frontend::app>
    <x-slot name="title">{{__('TopUp')}}</x-slot>
    <x-slot name="pageSlug">{{__('topUp')}}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.components.top-up />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
