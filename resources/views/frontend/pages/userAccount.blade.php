<x-frontend::app>
    <x-slot name="title">{{ __('Account') }}</x-slot>
    <x-slot name="pageSlug">{{ __('account') }}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.user-account />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
