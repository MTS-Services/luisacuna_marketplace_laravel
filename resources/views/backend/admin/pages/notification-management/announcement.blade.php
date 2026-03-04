<x-admin::app>
    <x-slot name="pageSlug">announcement</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.announcement.view')
            <x-slot name="title">{{ __('Announcement Details') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Announcement Details') }}</x-slot>
            <livewire:backend.admin.notification-management.announcement.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Announcement List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Announcement List') }}</x-slot>
            <livewire:backend.admin.notification-management.announcement.index />
            <livewire:backend.admin.notification-management.announcement.show />
    @endswitch

    <livewire:backend.admin.notification-management.announcement.send />
    <livewire:backend.admin.notification-management.announcement.send-individual />
</x-admin::app>
