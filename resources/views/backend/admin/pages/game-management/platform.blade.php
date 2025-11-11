<x-admin::app>
    <x-slot name="pageSlug">{{__('game-platform')}}</x-slot>

    @switch(Route::currentRouteName())
          @case('abc')
            <x-slot name="title">{{__('Game Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Create')}}</x-slot>
            <livewire:backend.admin.game-management.game.create />
           @break

            @default
            <x-slot name="title">{{__('Game Platform List')}}</x-slot>
             <x-slot name="breadcrumb">{{__('Game Management / Game Platform List')}}</x-slot>
            <livewire:backend.admin.game-management.platform.index />
    @endswitch

</x-admin::app>
