<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-platform') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.platform.create')
        
            <x-slot name="title">{{ __('Game Platform Create') }}</x-slot>

            <x-slot name="breadcrumb">{{ __('Game Management / Game pltaform create') }} </x-slot>
             
            <livewire:backend.admin.game-management.platform.create />
        @break

        @case('admin.gm.platform.trash')
            <x-slot name="title">{{ __('Game Platform Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Platform Trash List') }}</x-slot>
            <livewire:backend.admin.game-management.platform.trash />
        @break

        @case('admin.gm.platform.edit')
            <x-slot name="title">{{ __('Game Platfrom Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Platfrom Edit') }}</x-slot>
            <livewire:backend.admin.game-management.platform.edit :data="$data" />
        @break

        @case('admin.gm.platform.view')
            <x-slot name="title">{{ __('View Game Platfrom ') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / View Game Platfrom') }}</x-slot>
            <livewire:backend.admin.game-management.platform.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Game Platform List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Platform List') }}</x-slot>
            <livewire:backend.admin.game-management.platform.index />
    @endswitch

</x-admin::app>
