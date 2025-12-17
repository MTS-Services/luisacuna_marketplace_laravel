<x-admin::app>
    <x-slot name="pageSlug">{{ __('notification') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.notification.show')
            <x-slot name="title">{{ __('Notification Details') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Notification Details') }}</x-slot>
            <livewire:backend.admin.notification-management.notification.single :encryptedId="$encryptedId" />
        @break

        @default
            <x-slot name="title">{{ __('Notification List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Notification List') }}</x-slot>
            <livewire:backend.admin.notification-management.notification.index />
    @endswitch
</x-admin::app>
