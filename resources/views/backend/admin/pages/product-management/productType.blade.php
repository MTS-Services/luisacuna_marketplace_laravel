<x-admin::app>
    <x-slot name="pageSlug">product-management</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.pm.productType.create')
            <x-slot name="breadcrumb">Product Management > Product Type Create</x-slot>
            <x-slot name="title">Product Type Create</x-slot>
            <livewire:backend.admin.product-management.product-type.create />
        @break

        @default
            <x-slot name="breadcrumb">Product Management > Product Type List</x-slot>
            <x-slot name="title">Product Type List</x-slot>
            <livewire:backend.admin.product-management.product-type.index  />
    @endswitch

</x-admin::app>