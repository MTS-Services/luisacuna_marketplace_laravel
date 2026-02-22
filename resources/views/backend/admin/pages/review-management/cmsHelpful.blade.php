<x-admin::app>
    <x-slot name="pageSlug">review-management</x-slot>
    <x-slot name="breadcrumb">{{ __('Review Management > CMS Helpful Votes') }}</x-slot>
    <x-slot name="title">{{ __('CMS Helpful Votes') }}</x-slot>

    <livewire:backend.admin.review-management.cms-helpful.index />
</x-admin::app>
