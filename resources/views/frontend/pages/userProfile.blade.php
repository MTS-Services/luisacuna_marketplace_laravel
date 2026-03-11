<x-frontend::app>
    <x-slot name="pageSlug">user_profile</x-slot>
    @switch(request('tab'))
        @case('reviews')
            <x-slot name="title">{{ __('Profile Review') }}</x-slot>
            @break
        @case('about')
            <x-slot name="title">{{ __('Profile About') }}</x-slot>
            @break
        @default
            <x-slot name="title">{{ __('User Profile') }}</x-slot>
    @endswitch
    <livewire:backend.user.profile.user-profile-page :user="$user" />
</x-frontend::app>
