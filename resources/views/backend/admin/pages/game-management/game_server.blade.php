<x-admin::app>
    <x-slot name="pageSlug">{{__('game-server')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.server.create')
            <x-slot name="title">{{__('Game Server Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Server Create')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.create />
        @break

        @default
            <x-slot name="title">{{__('Game Server List')}}</x-slot>
             <x-slot name="breadcrumb">{{__('Game Management / Game Server List')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.index />
    @endswitch

</x-admin::app>
