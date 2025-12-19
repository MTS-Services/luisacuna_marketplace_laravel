<x-frontend::app>
    <x-slot name="pageSlug">{{ __('register') }}</x-slot>
    @switch(Route::currentRouteName())
        {{-- @case('register.emailVerify')
            <x-slot name="title">{{ __('Gmail Veryfication') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Register / Gmail Veryfication') }}</x-slot>
            <livewire:auth.user.register.set-email />
        @break --}}

        @case('register.emailVerify')
            <x-slot name="title">{{ __('Confirm your Gmail') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Register / Confirm your Gmail') }}</x-slot>
            <livewire:auth.user.otp-verify />
        @break

        @case('register.password')
            <x-slot name="title">{{ __('Create Password') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Register / Create Password') }}</x-slot>
            <livewire:auth.user.register.set-password  />
        @break
        
        @default
            <x-slot name="title">{{ __('Sign up') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Register / Sign up') }}</x-slot>
            <livewire:auth.user.register.set-name />
    @endswitch 

</x-frontend::app>