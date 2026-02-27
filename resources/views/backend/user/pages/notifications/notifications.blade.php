<x-user::app>
    @switch(Route::currentRouteName())
        @case('user.notifications.show')
            <x-slot name="title">{{ __('Notification Details') }}</x-slot>
            <x-slot name="pageSlug">{{ __('notification-details') }}</x-slot>
            <livewire:backend.user.notifications.single :encryptedId="$encryptedId" />
        @break

        @default
            <x-slot name="title">{{ __('Notifications') }}</x-slot>
            <x-slot name="pageSlug">{{ __('notifications') }}</x-slot>
            <livewire:backend.user.notifications.notifications />
    @endswitch
</x-user::app>
