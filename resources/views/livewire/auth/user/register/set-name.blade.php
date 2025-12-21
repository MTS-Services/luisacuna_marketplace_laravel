<div class="bg-cover bg-center bg-page-login">

    <div class="min-h-screen flex items-center justify-center py-6 text-white   ">
        <form method="POST" wire:submit="save" class="w-full sm:w-[90%] md:w-[70%] lg:w-[50%] max-w-4xl px-2">
            <div
                class="bg-zinc-900/40 backdrop-blur-sm  dark:bg-bg-secondary/75  dark:backdrop-blur-sm
            rounded-2xl shadow-lg
            flex flex-col justify-between
            ">

                <!-- Header -->
                <div class=" sm:mb-4 text-center pt-10">
                    <div class="flex justify-center items-center mb-4">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Sign in') }}</h2>
                    <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you\'ve been missed') }}
                    </p>
                </div>

                <div class=" px-2 sm:px-7">
                    <!-- First name Input -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class=" space-y-6 px-2 sm:px-7">
                            <label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('First name') }}</label>
                            <x-ui.input type="text" placeholder="Enter First Name" wire:model="first_name"
                                class="w-full bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <x-ui.input-error :messages="$errors->get('first_name')" />
                        </div>
                        <!-- Last name Input -->
                        <div class="mb-2  space-y-6 px-2 sm:px-7">
                            <label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Last name') }}</label>
                            <x-ui.input type="text" placeholder="Enter Last Name" wire:model="last_name"
                                class="w-full bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <x-ui.input-error :messages="$errors->get('last_name')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4 space-y-6 px-2 sm:px-7">
                            <label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Email') }}</label>
                            <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <!-- Error message -->
                            <x-ui.input-error :messages="$errors->get('email')" />
                        </div>

                        <!-- New Password -->
                        <div class="mb-2 space-y-6 px-2 sm:px-7">
                            <x-ui.label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Password') }}</x-ui.label>
                            <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!"
                                @blur="touched = true" />
                            <x-ui.input-error :messages="$errors->get('password')" />
                        </div>
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

                        <!-- Validation Rules (Show after touch) -->
                        <div x-show="touched" x-transition>
                            <!-- Lowercase Letter -->
                            <div class="flex items-center mb-2 space-y-6 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasLowercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasLowercase" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasLowercase ? 'text-white'">
                                    {{ __('Password must contain a lowercase letter') }}
                                </p>
                            </div>

                            <!-- Uppercase Letter -->
                            <div class="flex items-center mb-2 space-y-6 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasUppercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasUppercase" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasUppercase ? 'text-white'">
                                    {{ __('Password must contain an uppercase letter') }}
                                </p>
                            </div>

                            <!-- Number -->
                            <div class="flex items-center mb-2 space-y-6 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasNumber" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasNumber" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasNumber ? 'text-white'">
                                    {{ __('Password must contain a number') }}
                                </p>
                            </div>

                            <!-- Min Length -->
                            <div class="flex items-center mb-2 space-y-6 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasMinLength" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasMinLength" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasMinLength ? 'text-white'">
                                    {{ __('Password must be at least 8 characters long') }}
                                </p>
                            </div>

                            <!-- No Spaces -->
                            <div class="flex items-center mb-2 space-y-6 px-2 sm:px-7">
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
                        <div class="mb-2 sm:mb-4 space-y-6 px-2 sm:px-7">
                            <x-ui.label
                                class="block text-lg sm:text-2xl font-medium  text-white">{{ __('Confirm Password') }}</x-ui.label>
                            <x-ui.input type="password" id="confirm password" placeholder="Aex@8465"
                                wire:model="confirm_password"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <x-ui.input-error :messages="$errors->get('confirm_password')" />
                        </div>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class=" text-right px-4 sm:px-12 mb-5 sm:mb-4">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Next button -->
                <div class=" flex justify-center px-4 sm:px-12 mb-6">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('Next') }}
                    </x-ui.button>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-5 sm:mb-8 px-4">
                    <hr class="flex-1 border-white" />
                    <span class="px-3 text-base font-normal text-white">{{ __('Or sign in with') }}</span>
                    <hr class="flex-1 border-white" />
                </div>

                <div>
                    <!-- Social login -->
                    <div class="flex justify-center gap-4 mb-4 sm:mb-6">
                        <a href="{{ route('google.redirect') }}"
                            class="w-12 h-12 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-full h-full rounded-md"
                                alt="Google" />
                        </a>
                        <a href="{{ route('apple.login') }}"
                            class="w-12 h-12 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                class="w-full h-full rounded-md" alt="Apple" />
                        </a>

                        <a href="{{ route('auth.facebook') }}"
                            class="w-12 h-12 p-3.5 flex items-center justify-center bg-bg-white rounded-md">
                            <img src="{{ asset('assets/icons/facebook.svg') }}" class="w-full h-full rounded-md"
                                alt="Facebook" />
                        </a>
                    </div>

                    <!-- Sign up link -->
                    <div class="pb-10 text-center text-base font-normal text-white">
                        {{ __(' Don\'t have an account?') }}
                        <a href="{{ route('register.signUp') }}"
                            class="text-pink-500 text-base font-normal hover:underline">{{ __('Sign up') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
