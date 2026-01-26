{{-- <div>
    <div class="min-h-screen flex items-center justify-center p-4 bg-cover bg-center"
        style="background-image: url('{{ asset('assets/images/background/login-dark-background.png') }}');">

        <div class="w-full  max-w-xl bg-bg-secondary/75 rounded-2xl px-8 py-22 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-[420px] h-[102px]">
                    <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                        class="max-w-full max-h-full object-contain">
                </div>
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
                    <x-ui.input-error :messages="$errors->get('first_name')" />
                </div>

                <!-- First name Input -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Last name') }}</label>
                    <x-ui.input type="text" placeholder="Enter First Name" wire:model="last_name" />

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
</div> --}}
<div class="bg-cover bg-center bg-page-login">

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit="save" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
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

                <div class="space-y-6">
                    <!-- First name Input -->
                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('First name') }}</label>
                        <x-ui.input type="text" placeholder="{{ __('Enter First Name') }}" wire:model="first_name"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('first_name')" />
                    </div>
                    <!-- Last name Input -->
                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Last name') }}</label>
                        <x-ui.input type="text" placeholder="{{ __('Enter Last Name') }}" wire:model="last_name"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <x-ui.input-error :messages="$errors->get('last_name')" />
                    </div>
                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Email') }}</label>
                        <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <!-- Error message -->
                        <x-ui.input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Error message -->
                    @error('message')
                        <span class="text-pink-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <div class="" x-data="{
                            password: @entangle('password'),
                            touched: false,
                        
                            get hasLowercase() {
                                return /[a-z]/.test(this.password);
                            },
                            get hasUppercase() {
                                return /[A-Z]/.test(this.password);
                            },
                            get hasNumber() {
                                return /[0-9]/.test(this.password);
                            },
                            get hasMinLength() {
                                return this.password && this.password.length >= 8;
                            },
                            get noSpaces() {
                                return this.password && this.password === this.password.trim() && this.password.length > 0;
                            },
                            get allValid() {
                                return this.hasLowercase && this.hasUppercase && this.hasNumber && this.hasMinLength && this.noSpaces;
                            }
                        }">

                        <!-- New Password -->
                        <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                            <x-ui.label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Password') }}</x-ui.label>
                            <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!"
                                @blur="touched = true" />
                            <x-ui.input-error :messages="$errors->get('password')" />
                        </div>

                        <!-- Validation Rules (Show after touch) -->
                        <div x-show="touched" x-transition>
                            <!-- Lowercase Letter -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasLowercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasLowercase" x-cloak />
                                <p class="text-xs font-normal text-white"
                                    :class="hasLowercase ? 'text-white'">
                                    {{ __('Password must contain a lowercase letter') }}
                                </p>
                            </div>

                            <!-- Uppercase Letter -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasUppercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasUppercase" x-cloak />
                                <p class="text-xs font-normal text-white"
                                    :class="hasUppercase ? 'text-white'">
                                    {{ __('Password must contain an uppercase letter') }}
                                </p>
                            </div>

                            <!-- Number -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasNumber" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasNumber" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasNumber ? 'text-white'">
                                    {{ __('Password must contain a number') }}
                                </p>
                            </div>

                            <!-- Min Length -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasMinLength" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasMinLength" x-cloak />
                                <p class="text-xs font-normal text-white"
                                    :class="hasMinLength ? 'text-white'">
                                    {{ __('Password must be at least 8 characters long') }}
                                </p>
                            </div>

                            <!-- No Spaces -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!noSpaces" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="noSpaces" x-cloak />
                                <p class="text-xs font-normal text-white" :class="noSpaces ? 'text-white'">
                                    {{ __('Password must not contain leading or trailing spaces') }}
                                </p>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                            <x-ui.label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Confirm Password') }}</x-ui.label>
                            <x-ui.input type="password" id="confirm password" placeholder="Aex@8465"
                                wire:model="confirm_password"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <x-ui.input-error :messages="$errors->get('confirm_password')" />
                        </div>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-5 sm:mb-12">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Next button -->
                <div class=" flex justify-center px-2 sm:px-6 mb-5 sm:mb-11">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Next') }}
                    </x-ui.button>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-5 sm:mb-11 px-4">
                    <hr class="flex-1 border-white" />
                    <span class="px-3 text-base font-normal text-white">{{ __('Or sign in with') }}</span>
                    <hr class="flex-1 border-white" />
                </div>

                <div>
                    <!-- Social login -->
                    <div class="flex justify-center gap-4 mb-4 sm:mb-8">
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
                    <div class="text-center text-base font-normal text-white">
                        {{ __('Have an account already?') }}
                        <a href="{{ route('login') }}"
                            class="text-pink-500 text-base font-normal hover:underline">{{ __('Sign in') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
