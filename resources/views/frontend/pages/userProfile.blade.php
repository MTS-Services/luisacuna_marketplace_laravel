<x-frontend::app>
    <x-slot name="pageSlug">{{ __('user_profile') }}</x-slot>
    @switch(request('tab'))
        @case('shop')
            <x-slot name="title">{{ __('Profile Shop') }}</x-slot>
            <livewire:backend.user.profile.shop-categories.shop />
        @break

        @default
            <x-slot name="title">{{ __('User Profile') }}</x-slot>
            <livewire:backend.user.profile.profile-component />
    @endswitch
</x-frontend::app>
