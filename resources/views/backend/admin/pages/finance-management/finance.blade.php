
<x-admin::app>
    <x-slot name="pageSlug">{{ __('finance-management') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.finance.withdrawals')
            <x-slot name="pageSlug">{{ __('withdrawals') }}</x-slot>
            <x-slot name="title">{{ __('Paid Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Finance Management / Withdrawals List') }}</x-slot>
            <livewire:backend.admin.finance-management.withdrawals />
        @break

        @case('admin.finance.purchased')
            <x-slot name="pageSlug">{{ __('purchased') }}</x-slot>
            <x-slot name="title">{{ __('purchased') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('purchased Management / Purchased List') }}</x-slot>
            <livewire:backend.admin.finance-management.purchased />
        @break

        @case('admin.finance.top-ups')
            <x-slot name="pageSlug">{{ __('top-ups') }}</x-slot>
            <x-slot name="title">{{ __('Top Ups') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Finance Management / Top Ups List') }}</x-slot>
            <livewire:backend.admin.finance-management.top-ups />
        @break

        @default
            <x-slot name="title">{{ __('All Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / All Orders List') }}</x-slot>
            <livewire:backend.admin.finance-management.all-transactions />
    @endswitch
</x-admin::app>