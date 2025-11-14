<x-admin::app>
    <x-slot name="pageSlug">{{ __('achievement') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.rm.achievement.create')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Create') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Create') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement.create />
        @break

        @case('admin.rm.achievement.edit')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Edit') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Edit') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement.edit :data="$data" />
        @break

        @case('admin.rm.achievement.trash')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Trash') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Trash') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement.trash />
        @break

        @case('admin.rm.achievement.view')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Details') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Details') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement List') }}</x-slot>
            <x-slot name="title">{{ __('Achievement List') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement.index />
    @endswitch
</x-admin::app>
