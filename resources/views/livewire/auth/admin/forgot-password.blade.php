

<div class="bg-cover bg-center bg-page-login">

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit="sendPasswordResetOtp" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 sm:p-20 my-20 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-5 sm:mb-11 text-center">
                    <div class="flex justify-center items-center h-[102px] mb-5 sm:mb-11">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Forgot your password?') }}</h2>
                    <div class="px-0 sm:px-10">
                        <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                            {{ __('Enter your email address. We will send a message with a code to reset your password.') }}
                        </p>
                    </div>
                </div>
                <div class="space-y-6">
                    <!-- First name Input -->

                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Email') }}</label>
                        <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <!-- Error message -->
                        <x-ui.input-error :messages="$errors->get('email')" />
                    </div>
                    <!-- Submit button -->
                    <div class=" flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                        <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                            {{ __('Reset Password') }}
                        </x-ui.button>
                    </div>
                    <div class=" flex justify-center px-2 sm:px-6 mt-3 sm:mt-7">
                        <x-ui.button type="submit" href="{{ route('admin.login') }}" variant="secondary"
                            class="w-auto py-2!">
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
