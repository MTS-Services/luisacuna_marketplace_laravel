<x-frontend::app>
    <x-slot name="title">{{__('Accounts')}}</x-slot>
    <x-slot name="pageSlug">{{__('accounts')}}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.components.accounts />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
