<x-admin::app>
    <x-slot name="pageSlug">{{ __('email-template') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.email-template.edit')
            <x-slot name="title">{{ __('Edit Email Template') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Edit Email Template') }}</x-slot>
            <livewire:backend.admin.email-template.edit :id="$id" />
        @break
        @case('admin.email-template.show')
            <x-slot name="title">{{ __('Show Email Template') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Show Email Template') }}</x-slot>
            <livewire:backend.admin.email-template.show :id="$id" />
        @break

        @default
            <x-slot name="title">{{ __('Email Template') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Email Template') }}</x-slot>
            <livewire:backend.admin.email-template.index />
    @endswitch
</x-admin::app>
