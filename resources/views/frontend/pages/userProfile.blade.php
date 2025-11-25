<x-frontend::app>
    <x-slot name="pageSlug">{{ __('user_profile') }}</x-slot>
    @switch(request('tab'))
        {{-- @case('shop')
            <x-slot name="title">{{ __('Profile Shop') }}</x-slot>
            <livewire:backend.user.profile.shop-categories.shop />
        @break --}}
        @case('reviews')
             <x-slot name="title">{{ __('Profile Review') }}</x-slot>
            <livewire:backend.user.profile.review :user="$user" />
        @break
        @case('about')
             <x-slot name="title">{{ __('Profile About') }}</x-slot>
            <livewire:backend.user.profile.about :user="$user" />
        @break
        @default
            <x-slot name="title">{{ __('User Profile') }}</x-slot>
            <livewire:backend.user.profile.shop-categories.shop :user="$user" />
    @endswitch
</x-frontend::app>
