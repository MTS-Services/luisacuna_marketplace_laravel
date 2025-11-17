<x-admin::app>
    <x-slot name="pageSlug">{{__('game-server')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.server.create')
            <x-slot name="title">{{__('Game Server Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Server Create')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.create />
        @break
        @case('admin.gm.server.trash')
            <x-slot name="title">{{__('Game Server Trash List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Server Trash ')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.trash  />
        @break
        @case('admin.gm.server.view')
            <x-slot name="title">{{__('Game Server Detail')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Server Detail ')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.show :data="$data" />
        @break
        @case('admin.gm.server.edit')
            <x-slot name="title">{{__('Game Server Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Server Edit ')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.edit :data="$data" />
        @break

        @default
            <x-slot name="title">{{__('Game Server List')}}</x-slot>
             <x-slot name="breadcrumb">{{__('Game Management / Game Server List')}}</x-slot>
            <livewire:backend.admin.game-management.game-server.index />
    @endswitch

</x-admin::app>
