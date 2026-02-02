

<div class="bg-cover bg-center bg-page-login">
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit.prevent="resetPassword" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-5 sm:p-20 my-20 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-5 sm:mb-11 text-center">
                    <div class="flex justify-center items-center h-[102px] mb-5 sm:mb-11">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-medium text-white mb-3">{{ __('Create new password') }}</h2>
                    <div class="p-5">
                        <p class="text-white font-normal lg:text-xl sm:text-lg mt-2">
                            {{ __('We have sent a code in an Email message to ex***@gmaol.co TO confirm your account. enter your code.d') }}
                        </p>
                    </div>
                </div>



                <div class="space-y-6">
                    <!-- Error message -->
                    @error('message')
                        <span class="text-pink-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <div class="" x-data="{
                        password: @entangle('password'),
                        touched: true,
                    
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
                                <p class="text-xs font-normal text-white" :class="hasLowercase ? 'text-white'">
                                    {{ __('Password must contain a lowercase letter') }}
                                </p>
                            </div>

                            <!-- Uppercase Letter -->
                            <div class="flex items-center mb-2 px-2 sm:px-7">
                                <x-phosphor name="x" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="!hasUppercase" />
                                <x-phosphor name="check" variant="regular" class="w-4 h-4 fill-white!"
                                    x-show="hasUppercase" x-cloak />
                                <p class="text-xs font-normal text-white" :class="hasUppercase ? 'text-white'">
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
                                <p class="text-xs font-normal text-white" :class="hasMinLength ? 'text-white'">
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
                {{-- @if (Route::has('password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-5 sm:mb-12">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-pink-500 hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif --}}

                <!-- Next button -->
                <div class=" flex justify-center px-2 sm:px-6 mt-5 sm:mt-11">
                    <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                        {{ __('chnage password') }}
                    </x-ui.button>
                </div>
                <div class=" flex justify-center px-2 sm:px-6 mt-7">
                    <x-ui.button type="submit" href="{{ route('login') }}" variant="secondary" class="w-auto py-2!">
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
