<div>
    <div class="bg-bg-primary min-h-screen flex items-center justify-center p-4">
        <div class="w-full  max-w-xl bg-gradient-to-br bg-bg-secondary rounded-2xl px-8 py-22 shadow-2xl ">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-medium text-text-white">{{ __('Sign Up') }}</h1>
                <p class="text-text-white lg:text-xl sm:text-lg mt-2">{{ __('Hi! Welcome back, you\'ve been missed') }}
                </p>
            </div>

            <!-- Form -->
            <form wire:submit="save" class="space-y-6">
                <!-- First name Input -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('First name') }}</label>
                    <x-ui.input type="text" placeholder="Enter First Name" wire:model="first_name" />
                    {{-- Error message --}}
                    <x-ui.input-error :messages="$errors->get('first_name')" />
                </div>

                <!-- First name Input -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Last name') }}</label>
                    <x-ui.input type="text" placeholder="Enter First Name" wire:model="last_name" />
                    {{-- Error message --}}
                    <x-ui.input-error :messages="$errors->get('last_name')" />
                </div>

                <!-- Next Button -->
                <div class=" flex justify-center px-2 sm:px-6">
                    <x-ui.button type="submit" class="w-auto py-2!">
                        {{ __('Next') }}
                    </x-ui.button>
                </div>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 border-t "></div>
                <p class="px-3 text-text-white text-sm">{{ __('Or sign in with') }}</p>
                <div class="flex-1 border-t "></div>
            </div>

            <!-- Social Login Buttons -->
            <div>
                <!-- Social login -->
                <div class="flex justify-center gap-4 mb-2">
                    <a href="{{ route('google.redirect') }}"
                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                        <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                            alt="Google" />
                    </a>
                    <a href="{{ route('apple.login') }}"
                        class="w-10 h-10 sm:w-12 sm:h-12 flex z-30 items-center justify-center bg-white rounded-md">
                        <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                            alt="Apple" />
                    </a>

                    <a href="{{ route('auth.facebook') }}"
                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                        <img src="{{ asset('assets/icons/icons8-facebook.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                            alt="Facebook" />
                    </a>
                </div>
            </div>


            <!-- Sign Up Link -->
            <p class="text-center text-text-white">
                {{ __('Have an account already?') }}
                <a href="{{ route('login') }}" class="text-purple-700 transition font-medium">{{ __('Sign in') }}</a>
            </p>
        </div>
    </div>
</div>
