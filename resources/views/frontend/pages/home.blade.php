<x-frontend::app>
    <x-slot name="title">{{ __('Home') }}</x-slot>
    <x-slot name="pageSlug">{{__('home')}}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.components.home />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
