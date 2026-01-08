<x-user::app>
    <x-slot name="pageSlug">{{ __('wallet') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('user.wallet.withdrawal-methods')
            <livewire:backend.user.wallet.withdrawal-method />
            @break
        @case('user.wallet.withdrawal-form')
            <livewire:backend.user.wallet.withdrawal-form :method="$data" />
            @break
    
        @default
        <livewire:backend.user.wallet.wallet />
            
    @endswitch
</x-user::app>
