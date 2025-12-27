{{-- <x-admin::app>
    <x-slot name="pageSlug">{{ __('order-management') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.orders.paid-orders')
            <x-slot name="pageSlug">{{ __('paid-orders') }}</x-slot>
            <x-slot name="title">{{ __('Paid Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Paid Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.paid-orders />
        @break
        @case('admin.orders.completed-orders')
            <x-slot name="pageSlug">{{ __('completed-orders') }}</x-slot>
            <x-slot name="title">{{ __('Complete Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Complete Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.complete-orders />
        @break
        @case('admin.orders.cancelled-orders')
            <x-slot name="pageSlug">{{ __('cancelled-orders') }}</x-slot>
            <x-slot name="title">{{ __('Cancelled Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Cancelled Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.cancelled-orders />
        @break

        @default
            <x-slot name="title">{{ __('All Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / All Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.all-orders />
    @endswitch
</x-admin::app> --}}


<x-admin::app>
    <x-slot name="pageSlug">{{ __('order-management') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.orders.paid-orders')
            <x-slot name="pageSlug">{{ __('paid-orders') }}</x-slot>
            <x-slot name="title">{{ __('Paid Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Paid Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.paid-orders />
        @break

        @case('admin.orders.completed-orders')
            <x-slot name="pageSlug">{{ __('completed-orders') }}</x-slot>
            <x-slot name="title">{{ __('Complete Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Complete Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.complete-orders />
        @break

        @case('admin.orders.cancelled-orders')
            <x-slot name="pageSlug">{{ __('cancelled-orders') }}</x-slot>
            <x-slot name="title">{{ __('Cancelled Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / Cancelled Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.cancelled-orders />
        @break

        @default
            <x-slot name="title">{{ __('All Orders') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Order Management / All Orders List') }}</x-slot>
            <livewire:backend.admin.order-management.all-orders />
    @endswitch


    <livewire:backend.admin.order-management.detail />


    <script>
        window.addEventListener('order-detail-modal-open', () => {
            console.log('WINDOW EVENT RECEIVED');
        });
    </script>
</x-admin::app>
