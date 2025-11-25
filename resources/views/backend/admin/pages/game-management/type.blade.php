<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-type') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.type.create')
            <x-slot name="title">{{ __('Game type Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game type create') }} </x-slot>
            <livewire:backend.admin.game-management.type.create />
        @break

        @case('admin.gm.type.trash')
            <x-slot name="title">{{ __('Game type Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game type Trash List') }}</x-slot>
            <livewire:backend.admin.game-management.type.trash />
        @break

        @case('admin.gm.type.edit')
            <x-slot name="title">{{ __('Game type Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game type Edit') }}</x-slot>
            <livewire:backend.admin.game-management.type.edit :data="$data" />
        @break

        @case('admin.gm.type.show')
            <x-slot name="title">{{ __('View Game type ') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / View Game type') }}</x-slot>
            <livewire:backend.admin.game-management.type.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Game type List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game type List') }}</x-slot>
            <livewire:backend.admin.game-management.type.index :data="$data ?? null" />
    @endswitch

</x-admin::app>
