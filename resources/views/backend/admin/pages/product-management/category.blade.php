<x-admin::app>
    @switch(Route::currentRouteName())
        @case('admin.pm.currency.create')
        @break

        @case('admin.pm.category.details')
            <x-slot name="pageSlug">currency</x-slot>
            <x-slot name="breadcrumb">{{ __('Product Management > Product Details') }}</x-slot>
            <x-slot name="title">{{ __('Product Details') }}</x-slot>
            <livewire:backend.admin.product-management.category.details :productId="$id" />
        @break

        @default
            <x-slot name="pageSlug">{{ $categorySlug }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Product Management > Currency List') }}</x-slot>
            <x-slot name="title">{{ __('Currency List') }}</x-slot>
            <livewire:backend.admin.product-management.category.index :categorySlug="$categorySlug" />
    @endswitch

</x-admin::app>
