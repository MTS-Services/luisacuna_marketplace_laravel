<x-admin::app>
    <x-slot name="pageSlug">{{ __('CMS Management') }}</x-slot>
    <x-slot name="title">{{ $type->label() }}</x-slot>
    <x-slot name="breadcrumb">{{ $type->label() }}</x-slot>

    <livewire:backend.admin.cms-management.cms :type="$type->value" :key="$type->value" />
</x-admin::app>
