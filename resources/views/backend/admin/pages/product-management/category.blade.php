<x-admin::app>
    <x-slot name="pageSlug">{{ $categorySlug }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.pm.currency.create')
        @break

        @default
            <x-slot name="breadcrumb">{{ __('Product Management > Currency List') }}</x-slot>
            <x-slot name="title">{{ __('Currency List') }}</x-slot>
            <livewire:backend.admin.product-management.category.index :categorySlug="$categorySlug"/>
    @endswitch

</x-admin::app>