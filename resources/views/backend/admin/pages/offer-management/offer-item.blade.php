<x-admin::app>
    <x-slot name="pageSlug">{{ __('offer-item') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.om.offer.show')
        @break

        @default
            <x-slot name="breadcrumb">{{ __('Product Management > Product List') }}</x-slot>
            <x-slot name="title">{{ __('Product List') }}</x-slot>
            <livewire:backend.admin.offer-management.offer-item.index />
    @endswitch

</x-admin::app>
