<div class="bg-cover bg-center bg-page-login">
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit.prevent="login" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 sm: shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-2 text-center">
                    <div class="flex justify-center items-center h-[102px]">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Sign in') }}</h2>
                    <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you\'ve been missed') }}
                    </p>
                </div>


                <!-- Email -->
                <div class="space-y-2">
                    <div class=" px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Email') }}</label>
                        <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        {{-- Error message --}}
                        <x-ui.input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Error message -->
                    @error('message')
                        <span class="text-pink-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                    <!-- Password -->
                    <div class="mb-2 px-2 sm:px-6">
                        <x-ui.label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Password') }}</x-ui.label>
                        <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('password')" />
                    </div>
                </div>



                @if (Route::has('password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-3">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Sign in button -->
                <div class=" flex justify-center px-2 sm:px-6 mb-3">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Sign in') }}
                    </x-ui.button>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-3 px-4">
                    <hr class="flex-1 border-white" />
                    <span class="px-3 text-base font-normal text-white">{{ __('Or sign in with') }}</span>
                    <hr class="flex-1 border-white" />
                </div>

                <div>
                    <!-- Social login -->
                    <div class="flex justify-center gap-4 mb-2">
                        <a href="{{ route('google.redirect') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-full h-full rounded-md"
                                alt="Google" />
                        </a>
                        <a href="{{ route('apple.login') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                class="w-full h-full rounded-md" alt="Apple" />
                        </a>

                        <a href="{{ route('auth.facebook') }}"
                            class="w-14 h-14 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/facebook.svg') }}" class="w-full h-full rounded-md"
                                alt="Facebook" />
                        </a>
                    </div>

                    <!-- Sign up link -->
                    <div class="text-center text-base font-normal text-white mb-4">
                        {{ __(' Don\'t have an account?') }}
                        <a href="{{ route('register.signUp') }}"
                            class="text-pink-500 text-base font-normal hover:underline">{{ __('Sign up') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
