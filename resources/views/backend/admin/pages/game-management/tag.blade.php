<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-tag') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.tag.create')
            <x-slot name="title">{{ __('Game tag Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game tag create') }} </x-slot>
            <livewire:backend.admin.game-management.tag.create />
        @break

        @case('admin.gm.tag.trash')
            <x-slot name="title">{{ __('Game tag Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game tag Trash List') }}</x-slot>
            <livewire:backend.admin.game-management.tag.trash />
        @break

        @case('admin.gm.tag.edit')
            <x-slot name="title">{{ __('Game tag Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game tag Edit') }}</x-slot>
            <livewire:backend.admin.game-management.tag.edit :data="$data" />
        @break

        @case('admin.gm.tag.show')
            <x-slot name="title">{{ __('View Game tag ') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / View Game tag') }}</x-slot>
            <livewire:backend.admin.game-management.tag.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Game tag List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Game tag List') }}</x-slot>
            <livewire:backend.admin.game-management.tag.index :data="$data ?? null" />
    @endswitch

</x-admin::app>
