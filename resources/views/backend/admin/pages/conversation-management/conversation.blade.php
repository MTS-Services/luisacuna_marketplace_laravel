<x-admin::app>
    <x-slot name="pageSlug">admin-conversations</x-slot>
    <x-slot name="title">{{ __('Conversations') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Conversations') }}</x-slot>

    <livewire:backend.admin.conversation-management.conversation.index />
</x-admin::app>
