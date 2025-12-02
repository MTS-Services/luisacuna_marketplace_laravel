<x-admin::app>
    <x-slot name="pageSlug">{{ __('tag') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.tag.create')
            <x-slot name="title">{{ __('Tag Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Tag Create') }}</x-slot>
            <livewire:backend.admin.game-management.tag.create />
        @break

        @case('admin.gm.tag.trash')
            <x-slot name="title">{{ __('Tag Trash List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Tag Trash ') }}</x-slot>
            <livewire:backend.admin.game-management.tag.trash />
        @break

        @case('admin.gm.tag.view')
            <x-slot name="title">{{ __('Tag Detail') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Tag Detail ') }}</x-slot>
            <livewire:backend.admin.game-management.tag.show :data="$data" />
        @break

        @case('admin.gm.tag.edit')
            <x-slot name="title">{{ __('Tag Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Tag Edit ') }}</x-slot>
            <livewire:backend.admin.game-management.tag.edit :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Tag List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Tag List') }}</x-slot>
            <livewire:backend.admin.game-management.tag.index />
    @endswitch

</x-admin::app>
