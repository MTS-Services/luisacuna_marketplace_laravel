<x-frontend::app>
    <x-slot name="title">{{ __('Coaching') }}</x-slot>
    <x-slot name="pageSlug">{{ __('coaching') }}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:frontend.coaching />
    {{-- <livewire:livewire-example /> --}}
</x-frontend::app>
