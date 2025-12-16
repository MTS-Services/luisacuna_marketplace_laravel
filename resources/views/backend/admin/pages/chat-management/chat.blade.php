<x-admin::app>
    <x-slot name="pageSlug">{{ __('chat') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.chat.chat')
        <x-slot name="title">{{ __('Chat ') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Chat Management / Chat') }}</x-slot>
           <livewire:backend.admin.chat-management.chat :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Chat List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Chat Management / Chat List') }}</x-slot>
            <livewire:backend.admin.chat-management.index />
    @endswitch
</x-admin::app>