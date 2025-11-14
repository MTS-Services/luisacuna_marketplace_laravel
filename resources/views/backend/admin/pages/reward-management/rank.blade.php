<x-admin::app>

    <x-slot name="pageSlug">{{__('rank')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.rm.rank.create')
            <x-slot name="breadcrumb">{{ __('Reward Management > Rank Create') }}</x-slot>
            <x-slot name="title">{{ __('Rank Create') }}</x-slot>
            <livewire:backend.admin.reward-management.rank.create />
        @break

        @case('admin.rm.rank.edit')
            <x-slot name="breadcrumb">{{__('Reward Management > Rank Edit')}}</x-slot>
            <x-slot name="title">{{__('Rank Edit')}}</x-slot>
            <livewire:backend.admin.reward-management.rank.edit :data="$data" />
        @break

        @case('admin.rm.rank.trash')
            <x-slot name="breadcrumb">{{__('Reward Management > Rank Trash List')}}</x-slot>
            <x-slot name="title">{{__('Rank Trash List')}}</x-slot>
            <livewire:backend.admin.reward-management.rank.trash />
        @break

        @case('admin.rm.rank.view')
            <x-slot name="breadcrumb">{{__('Reward Management > Rank Details')}}</x-slot>
            <x-slot name="title">{{__('Rank Details')}}</x-slot>
            <livewire:backend.admin.reward-management.rank.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{!! __('Reward Management > Rank List') !!}</x-slot>
            <x-slot name="title">{{ __('Rank List') }}</x-slot>
            <livewire:backend.admin.reward-management.rank.index />
    @endswitch

</x-admin::app>
