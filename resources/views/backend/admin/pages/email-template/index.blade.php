<x-admin::app>
    <x-slot name="pageSlug">{{ __('email-template') }}</x-slot>

    @if (Route::currentRouteName() === 'admin.email-template.edit')
        <x-slot name="title">{{ __('Edit Email Template') }}</x-slot>
        <x-slot name="breadcrumb">{{ __('Edit Email Template') }}</x-slot>
        <livewire:backend.admin.email-template.edit :id="$id" />
    @else
        <x-slot name="title">{{ __('Email Template') }}</x-slot>
        <x-slot name="breadcrumb">{{ __('Email Template') }}</x-slot>
        <livewire:backend.admin.email-template.index />
    @endif
</x-admin::app>
