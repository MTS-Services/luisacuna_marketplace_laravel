<x-admin::app>
    <x-slot name="pageSlug">{{ __('notification') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.nm.notification.send')
            <x-slot name="title">{{ __('Notification Send') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Notification Management / Notification Send') }}</x-slot>
            <livewire:backend.admin.notification-management.notification.send />
        @break

        @case('admin.nm.notification.view')
            <x-slot name="title">{{ __('Notification Details') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Notification Management / Notification Details') }}</x-slot>
            <livewire:backend.admin.notification-management.notification.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Notification List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Notification Management / Notification List') }}</x-slot>
            <livewire:backend.admin.notification-management.notification.index />
    @endswitch
</x-admin::app>