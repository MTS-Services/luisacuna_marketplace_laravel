<x-admin::app>
    <x-slot name="pageSlug">{{ __('achievement-type') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.rm.achievement.create')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Type Create') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Type Create') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement-type.create />
        @break

        @case('admin.rm.achievement.edit')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Type Edit') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Type Edit') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement-type.edit :data="$data" />
        @break

        @case('admin.rm.achievement.trash')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Type Trash') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Type Trash') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement-type.trash />
        @break

        @case('admin.rm.achievement.view')
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Type Details') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Type Details') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement-type.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{ __('Reward Management > Achievement Type List') }}</x-slot>
            <x-slot name="title">{{ __('Achievement Type List') }}</x-slot>
            <livewire:backend.admin.reward-management.achievement-type.index />
    @endswitch
</x-admin::app>
