<x-frontend::app>
    <x-slot name="title">{{__('User Profile')}}</x-slot>
    <x-slot name="pageSlug">{{__('user_profile')}}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.components.user-profile-component />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
