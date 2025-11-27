<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-feature') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.game-feature.create')
            <x-slot name="title">{{ __('Game Feature Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Feature Create') }}</x-slot>
            <livewire:backend.admin.game-management.game-feature.create />
        @break

        @case('admin.gm.game-feature.trash')
            <x-slot name="title">{{ __('Game Feature Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Feature Trash ') }}</x-slot>
            <livewire:backend.admin.game-management.game-feature.trash />
        @break

        @case('admin.gm.game-feature.view')
            <x-slot name="title">{{ __('Game Feature Detail') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Feature Detail ') }}</x-slot>
            <livewire:backend.admin.game-management.game-feature.show :data="$data" />
        @break

        @case('admin.gm.game-feature.edit')
            <x-slot name="title">{{ __('Game Feature Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Feature Edit ') }}</x-slot>
            <livewire:backend.admin.game-management.game-feature.edit :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Game Feature List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game Feature List') }}</x-slot>
            <livewire:backend.admin.game-management.game-feature.index />
    @endswitch

</x-admin::app>
