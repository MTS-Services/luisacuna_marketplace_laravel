<x-admin::app>
    <x-slot name="pageSlug">{{ __('Faq') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.flm.faq.create')
            <x-slot name="title">{{ __('Faq Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Faq create') }} </x-slot>
            <livewire:backend.admin.faq-management.faq.create :data="$data ?? null" />
        @break

        @case('admin.flm.faq.trash')
            <x-slot name="title">{{ __('Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Trash List') }}</x-slot>
            <livewire:backend.admin.faq-management.faq.trash :data="$data ?? null" />
        @break

        @case('admin.flm.faq.edit')
            <x-slot name="title">{{ __('Faq Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Faq Edit') }}</x-slot>
            <livewire:backend.admin.faq-management.faq.edit :data="$data ?? null" />
        @break

        @case('admin.flm.faq.show')
            <x-slot name="title">{{ __('View Faq') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('View Faq') }}</x-slot>
            <livewire:backend.admin.faq-management.faq.show :data="$data ?? null" />
        @break

        @default
            <x-slot name="title">{{ __('Faq List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Faq List') }}</x-slot>
            <livewire:backend.admin.faq-management.faq.index :data="$data ?? null" />
    @endswitch

</x-admin::app>
