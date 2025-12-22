{{-- <div class="container min-h-[80vh] py-10">
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <div class="min-h-[70vh] flex items-center justify-center text-text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit.prevent="login" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div class="bg-bg-secondary rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col justify-between min-h-[55vh]">

                <!-- Header -->
                <div class="mb-6 text-center">
                    <h2 class="text-3xl sm:text-4xl font-medium text-text-white">{{__('Sign in')}}</h2>
                    <p class="text-text-white lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you’ve been missed') }}
                    </p>
                </div>

                <!-- Email -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Email')}}</label>
                    <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                        />

                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Error message -->
                @error('message')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror

                <!-- Password -->
                <div class=" sm:mb-6 px-2 sm:px-6">
                    <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Password')}}</label>
                    <div class="relative">
                        <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                            />
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-zinc-400 hover:text-zinc-300">
                            <svg class="w-5 h-5" fill="none" stroke="gray" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Error message -->
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror

                @if (Route::has('admin.password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-2">
                        <a href="{{ route('admin.password.request') }}" wire:navigate
                            class="text-md text-accent hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Sign in button -->
                <div class=" flex justify-center px-2 sm:px-6 mb-2 sm:mb-6">
                    <x-ui.button type="submit"
                        class="w-auto py-2!">
                        {{ __('Sign in') }}
                    </x-ui.button>
                </div>

            </div>
        </form>
    </div>
</div> --}}

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
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 sm:p-20 my-20 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-5 sm:mb-11 text-center">
                    <div class="flex justify-center items-center h-[102px] mb-5 sm:mb-11">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Sign in') }}</h2>
                    <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you\'ve been missed') }}
                    </p>
                </div>


                <!-- Email -->
                <div class="space-y-6">
                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
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
                    <div class="mb-4 sm:mb-7 px-2 sm:px-6">
                        <x-ui.label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Password') }}</x-ui.label>
                        <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('password')" />
                    </div>
                </div>



                @if (Route::has('password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-5 sm:mb-12">
                        <a href="{{ route('admin.password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Sign in button -->
                <div class=" flex justify-center px-2 sm:px-6 mb-5 sm:mb-11">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Sign in') }}
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
