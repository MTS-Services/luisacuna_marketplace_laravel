<div class="flex flex-col gap-6 ">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />
    <div class="flex items-center justify-center min-h-screen ">
        <form method="POST" wire:submit="register"
            class="grid grid-cols-2 gap-4 max-w-7xl w-full p-8  shadow-lg rounded-lg">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
                :placeholder="__('Full name')" />
            <flux:input wire:model="sort_order" :label="__('Sort Order')" type="text" required autofocus
                autocomplete="sort_order" :placeholder="__('Sort Order')" />
            <flux:input wire:model="country_id" :label="__('Country Id')" type="text" required autofocus
                autocomplete="country_id" :placeholder="__('Country Id')" />

            <flux:input wire:model="first_name" :label="__('First Name')" type="text" required autofocus
                autocomplete="first_name" :placeholder="__('First Name')" />
            <flux:input wire:model="last_name" :label="__('Last Name')" type="text" required autofocus
                autocomplete="last_name" :placeholder="__('Last Name')" />

            <flux:input wire:model="display_name" :label="__('Display Name')" type="text" required autofocus
                autocomplete="display_name" :placeholder="__('Display Name')" />

            <flux:input wire:model="avatar" :label="__('Avatar')" type="text" required autofocus
                autocomplete="avatar" :placeholder="__('Avatar')" />

            <flux:input wire:model="date_of_birth" :label="__('Date of Birth ')" type="text" required autofocus
                autocomplete="date_of_birth" :placeholder="__('Date of Birth')" />

            <flux:input wire:model="timezone" :label="__('Timezone')" type="text" required autofocus
                autocomplete="timezone" :placeholder="__('Timezone')" />

            <flux:input wire:model="language" :label="__('Language')" type="text" required autofocus
                autocomplete="language" :placeholder="__('Language')" />

            <flux:input wire:model="currency" :label="__('Currency')" type="text" required autofocus
                autocomplete="currency" :placeholder="__('Currency')" />

            <flux:input wire:model="email_verified_at" :label="__('Email Verified At')" type="text" required
                autofocus autocomplete="email_verified_at" :placeholder="__('Email Verified At')" />

            <flux:input wire:model="last_login_at" :label="__('Last Login At')" type="text" required autofocus
                autocomplete="last_login_at" :placeholder="__('Last Login At')" />

            <flux:input wire:model="last_login_ip" :label="__('Last Login Ip')" type="text" required autofocus
                autocomplete="last_login_ip" :placeholder="__('Last Login Ip')" />

            <flux:input wire:model="login_attempts" :label="__('Login Attempts')" type="text" required autofocus
                autocomplete="login_attempts" :placeholder="__('Login Attempts')" />

            <flux:input wire:model="locked_until" :label="__('Locked Until')" type="text" required autofocus
                autocomplete="locked_until" :placeholder="__('Locked Until')" />

            <flux:input wire:model="terms_accepted_at" :label="__('Terms Accepted At')" type="text" required
                autofocus autocomplete="terms_accepted_at" :placeholder="__('Terms Accepted At')" />

            <flux:input wire:model="privacy_accepted_at" :label="__('Privacy Accepted At')" type="text" required
                autofocus autocomplete="privacy_accepted_at" :placeholder="__('Privacy Accepted At')" />

            <flux:input wire:model="last_synced_at" :label="__('Last Synced At')" type="text" required autofocus
                autocomplete="last_synced_at" :placeholder="__('Last Synced At')" />

            <flux:input wire:model="username" :label="__('Username')" type="text" required autofocus
                autocomplete="username" :placeholder="__('Username')" />

            <flux:input wire:model="phone" :label="__('Phone')" type="text" required autofocus
                autocomplete="phone" :placeholder="__('Phone')" />

            <flux:input wire:model="phone_verified_at" :label="__('Phone Verified At')" type="text" required
                autofocus autocomplete="phone_verified_at" :placeholder="__('Phone Verified At')" />

            <flux:input wire:model="user_type" :label="__('User Type')" type="text" required autofocus
                autocomplete="user_type" :placeholder="__('User Type')" />

            <flux:input wire:model="account_status" :label="__('Account Status')" type="text" required autofocus
                autocomplete="account_status" :placeholder="__('Account Status')" />

            <flux:input wire:model="password_reset_tokens" :label="__('Password Reset Tokens')" type="text" required
                autofocus autocomplete="password_reset_tokens" :placeholder="__('Password Reset Tokens')" />


            <flux:input wire:model="ip_address" :label="__('Ip Address')" type="text" required autofocus
                autocomplete="ip_address" :placeholder="__('Ip Address')" />

            <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
                placeholder="email@example.com" />

            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="new-password" :placeholder="__('Password')" viewable />

            <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
                autocomplete="new-password" :placeholder="__('Confirm password')" viewable />
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <!-- Create Account Button -->
                <flux:button type="submit" variant="primary" class="w-full sm:w-auto px-6 py-2">
                    {{ __('Create account') }}
                </flux:button>
                <!-- Login Link -->
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-600">{{ __('Already have an account?') }}</span>
                    <flux:link :href="route('login')" wire:navigate class="text-blue-600 hover:underline">
                        {{ __('Log in') }}
                    </flux:link>
                </div>
            </div>
        </form>
    </div>
</div>
