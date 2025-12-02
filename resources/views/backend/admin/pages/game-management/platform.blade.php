<x-admin::app>
    <x-slot name="pageSlug">{{ __('platform') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.platform.create')
            <x-slot name="title">{{ __('Platform Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Platform Create') }}</x-slot>
            <livewire:backend.admin.game-management.platform.create />
        @break

        @case('admin.gm.platform.trash')
            <x-slot name="title">{{ __('Platform Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Platform Trash ') }}</x-slot>
            <livewire:backend.admin.game-management.platform.trash />
        @break

        @case('admin.gm.platform.view')
            <x-slot name="title">{{ __('Platform Detail') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Platform Detail ') }}</x-slot>
            <livewire:backend.admin.game-management.platform.show :data="$data" />
        @break

        @case('admin.gm.platform.edit')
            <x-slot name="title">{{ __('Platform Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Platform Edit ') }}</x-slot>
            <livewire:backend.admin.game-management.platform.edit :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Platform List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Platform List') }}</x-slot>
            <livewire:backend.admin.game-management.platform.index />
    @endswitch

</x-admin::app>
