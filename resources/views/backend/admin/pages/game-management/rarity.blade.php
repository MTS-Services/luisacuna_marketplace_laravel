<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-rarity') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.rarity.create')
            <x-slot name="title">{{ __('Game rarity Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game rarity create') }} </x-slot>
            <livewire:backend.admin.game-management.rarity.create />
        @break

        @case('admin.gm.rarity.trash')
            <x-slot name="title">{{ __('Game rarity Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game rarity Trash List') }}</x-slot>
            <livewire:backend.admin.game-management.rarity.trash />
        @break

        @case('admin.gm.rarity.edit')
            <x-slot name="title">{{ __('Game rarity Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game rarity Edit') }}</x-slot>
            <livewire:backend.admin.game-management.rarity.edit :data="$data" />
        @break

        @case('admin.gm.rarity.show')
            <x-slot name="title">{{ __('View Game rarity ') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / View Game rarity') }}</x-slot>
            <livewire:backend.admin.game-management.rarity.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Game rarity List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game rarity List') }}</x-slot>
            <livewire:backend.admin.game-management.rarity.index :data="$data ?? null" />
    @endswitch

</x-admin::app>
