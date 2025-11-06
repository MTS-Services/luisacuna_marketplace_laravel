<x-admin::app>
    <x-slot name="pageSlug">product</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.pm.product.create')
            <x-slot name="breadcrumb">Product Management > Product Create</x-slot>
            <x-slot name="title">Product Create</x-slot>
            <livewire:backend.admin.product-management.product.create />
        @break

        @case('admin.pm.product.edit')
            <x-slot name="breadcrumb">Product Management > Product Edit</x-slot>
            <x-slot name="title">Product Edit</x-slot>
            <livewire:backend.admin.product-management.product.edit :data="$data" />
        @break

        @case('admin.pm.product.trash')
            <x-slot name="breadcrumb">Product Management > Product Trash</x-slot>
            <x-slot name="title">Product Trash</x-slot>
            <livewire:backend.admin.product-management.product.trash />
        @break

        @case('admin.pm.product.show')
            <x-slot name="breadcrumb">Product Management > Product Details</x-slot>
            <x-slot name="title">Currency Details</x-slot>
            <livewire:backend.admin.product-management.product.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">Product Management > Product List</x-slot>
            <x-slot name="title">Product List</x-slot>
            <livewire:backend.admin.product-management.product.index />
    @endswitch

</x-admin::app>
