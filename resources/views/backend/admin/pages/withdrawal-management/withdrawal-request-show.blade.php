<x-admin::app>
    <div>
        <x-slot name="title">{{ __('Withdrawal Request Details') }}</x-slot>
        <x-slot name="pageSlug">{{ __('withdrawal-request') }}</x-slot>
        <x-slot name="breadcrumb">{{ __('Withdrawal Management / Withdrawal Request Details') }}</x-slot>

        <livewire:backend.admin.withdrawal-management.withdrawal-request.show :data="$data" />
    </div>
</x-admin::app>
