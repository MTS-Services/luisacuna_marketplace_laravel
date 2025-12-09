<div>
    <div class="bg-bg-primary min-h-screen flex items-center justify-center ">
        <div class="w-full  max-w-xl bg-gradient-to-br bg-bg-secondary rounded-2xl  px-8 py-20 shadow-2xl ">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-medium text-text-white">{{ __('Create Password') }}</h1>
                <p class="text-text-white lg:text-xl sm:text-lg mt-2">{{ __('Hi! Welcome back, you\'ve been missed') }}
                </p>
            </div>

            <form wire:submit="save" class="space-y-6" x-data="{
                password: @entangle('password'),
                touched: false,
            
                get hasLowercase() { return /[a-z]/.test(this.password); },
                get hasUppercase() { return /[A-Z]/.test(this.password); },
                get hasNumber() { return /[0-9]/.test(this.password); },
                get hasMinLength() { return this.password && this.password.length >= 8; },
                get noSpaces() { return this.password && this.password === this.password.trim() && this.password.length > 0; },
                get allValid() { return this.hasLowercase && this.hasUppercase && this.hasNumber && this.hasMinLength && this.noSpaces; }
            }">
                <!-- Password -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-ui.label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Password') }}</x-ui.label>
                    <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                        @blur="touched = true" />
                    <x-ui.input-error :messages="$errors->get('password')" />
                </div>

                <!-- Validation Rules -->
                <div x-show="touched" x-transition>
                    <!-- Lowercase -->
                    <div class="flex items-center gap-2 mb-2 px-2 sm:px-6">
                        <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                            x-show="!hasLowercase" />
                        <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasLowercase"
                            x-cloak />
                        <p class="text-xs font-normal" :class="hasLowercase ? 'text-zinc-500' : 'text-text-white'">
                            {{ __('Password must contain a lowercase letter') }}
                        </p>
                    </div>

                    <!-- Uppercase -->
                    <div class="flex items-center gap-2 mb-2 px-2 sm:px-6">
                        <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                            x-show="!hasUppercase" />
                        <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasUppercase"
                            x-cloak />
                        <p class="text-xs font-normal" :class="hasUppercase ? 'text-zinc-500' : 'text-text-white'">
                            {{ __('Password must contain an uppercase letter') }}
                        </p>
                    </div>

                    <!-- Number -->
                    <div class="flex items-center gap-2 mb-2 px-2 sm:px-6">
                        <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                            x-show="!hasNumber" />
                        <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasNumber"
                            x-cloak />
                        <p class="text-xs font-normal" :class="hasNumber ? 'text-zinc-500' : 'text-text-white'">
                            {{ __('Password must contain a number') }}
                        </p>
                    </div>

                    <!-- Min Length -->
                    <div class="flex items-center gap-2 mb-2 px-2 sm:px-6">
                        <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500"
                            x-show="!hasMinLength" />
                        <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasMinLength"
                            x-cloak />
                        <p class="text-xs font-normal" :class="hasMinLength ? 'text-zinc-500' : 'text-text-white'">
                            {{ __('Password must be at least 8 characters long') }}
                        </p>
                    </div>

                    <!-- No Spaces -->
                    <div class="flex items-center gap-2 mb-2 px-2 sm:px-6">
                        <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!noSpaces" />
                        <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="noSpaces"
                            x-cloak />
                        <p class="text-xs font-normal" :class="noSpaces ? 'text-zinc-500' : 'text-text-white'">
                            {{ __('Password must not contain leading or trailing spaces') }}
                        </p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-ui.label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Confirm Password') }}</x-ui.label>
                    <x-ui.input type="password" placeholder="Confirm Password" wire:model="password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Show Password Checkbox -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <input type="checkbox" id="showPassword" class="w-4 h-4 rounded accent-purple-500 cursor-pointer"
                        x-on:click="passwordField = passwordField === 'password' ? 'text' : 'password'; $refs.password.type = passwordField" />
                    <label for="showPassword" class="text-base font-normal mb-2 text-text-white cursor-pointer">
                        {{ __('Show password') }}
                    </label>
                </div>

                <!-- Sign Up Button -->
                <x-ui.button class="w-full! py-2!" type="submit">
                    <span class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Sign up') }}</span>
                </x-ui.button>
            </form>


            {{-- <form wire:submit="save" class="space-y-6">
                <!-- Password -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-ui.label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Password') }}</x-ui.label>
                    <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password" />
                    <x-ui.input-error :messages="$errors->get('password')" />
                </div>

                <div class="w-full">
                    <x-ui.label value="Confirm Password" class="mb-1" />
                    <x-ui.input type="password" placeholder="Confirm Password" wire:model="password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('password_confirmation')" />
                </div>
                <!-- Password -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-ui.label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Confirm Password') }}</x-ui.label>
                    <x-ui.input type="password" placeholder="Confirm Password" wire:model="password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('password_confirmation')" />
                </div>


                <!-- Lowercase Letter -->
                <div class="flex items-center gap-2">
                    <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!hasLowercase" />
                    <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasLowercase"
                        x-cloak />
                    <p class="text-xs font-normal" :class="hasLowercase ? 'text-zinc-500' : 'text-text-white'">
                        {{ __('Password must contain a lowercase letter') }}
                    </p>
                </div>

                <!-- Uppercase Letter -->
                <div class="flex items-center gap-2 mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!hasUppercase" />
                    <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasUppercase"
                        x-cloak />
                    <p class="text-xs font-normal" :class="hasUppercase ? 'text-zinc-500' : 'text-text-white'">
                        {{ __('Password must contain an uppercase letter') }}
                    </p>
                </div>

                <!-- Number -->
                <div class="flex items-center gap-2 mt-2">
                    <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!hasNumber" />
                    <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasNumber"
                        x-cloak />
                    <p class="text-xs font-normal" :class="hasNumber ? 'text-zinc-500' : 'text-text-white'">
                        {{ __('Password must contain a number') }}
                    </p>
                </div>

                <!-- Min Length -->
                <div class="flex items-center gap-2 mt-2">
                    <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!hasMinLength" />
                    <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="hasMinLength"
                        x-cloak />
                    <p class="text-xs font-normal" :class="hasMinLength ? 'text-zinc-500' : 'text-text-white'">
                        {{ __('Password must be at least 8 characters long') }}
                    </p>
                </div>

                <!-- No Spaces -->
                <div class="flex items-center gap-2 mt-2">
                    <x-phosphor name="x" variant="regular" class="w-4 h-4 text-pink-500" x-show="!noSpaces" />
                    <x-phosphor name="check" variant="regular" class="w-4 h-4 text-zinc-500" x-show="noSpaces"
                        x-cloak />
                    <p class="text-xs font-normal" :class="noSpaces ? 'text-zinc-500' : 'text-text-white'">
                        {{ __('Password must not contain leading or trailing spaces') }}
                    </p>
                </div>



                <!-- Show Password Checkbox -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <input type="checkbox" id="showPassword" class="w-4 h-4 rounded accent-purple-500 cursor-pointer">
                    <label for="showPassword"
                        class="text-base font-normal mb-2 text-text-white cursor-pointer">{{ __('Show password') }}</label>
                </div>

                <!-- Sign In Button -->
                <x-ui.button class="w-full! py-2!" type="submit">
                    <span class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Sign up') }}</span>
                </x-ui.button>


            </form> --}}


            <!-- Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 border-t "></div>
                <p class="px-3 text-text-white text-sm">{{ __('Or sign in with') }}</p>
                <div class="flex-1 border-t "></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="flex justify-center gap-4 mb-6">
                <!-- Google -->
                <button class="bg-white rounded-lg p-3 hover:bg-gray-100 transition shadow-md">
                    <svg class="w-6 h-6" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <!-- Google G logo -->
                        <path
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l-3.76 3.76C27.95 15.38 26.08 14.5 24 14.5c-5.22 0-9.5 4.28-9.5 9.5s4.28 9.5 9.5 9.5c4.05 0 7.5-2.55 8.78-6.1h-8.78v-5h14.26c.17.84.26 1.71.26 2.6 0 8.28-5.73 14.5-14.52 14.5-8.25 0-14.98-6.73-14.98-15s6.73-15 14.98-15z"
                            fill="blue" />

                        <!-- Red section -->
                        <path
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l-3.76 3.76C27.95 15.38 26.08 14.5 24 14.5c-5.22 0-9.5 4.28-9.5 9.5 0 1.67.44 3.24 1.21 4.6l-3.84 2.94C10.53 29.55 9.5 26.89 9.5 24c0-8.27 6.73-15 14.5-15z"
                            fill="red" />

                        <!-- Yellow section -->
                        <path
                            d="M11.87 31.54C10.53 29.55 9.5 26.89 9.5 24c0-1.27.17-2.49.48-3.65l3.84 2.94c-.27.86-.42 1.78-.42 2.71 0 1.9.57 3.67 1.53 5.15l-3.06 2.39z"
                            fill="yellow" />

                        <!-- Green section -->
                        <path
                            d="M24 38.5c-3.67 0-6.98-1.39-9.5-3.66l3.06-2.39c1.8 1.45 4.08 2.32 6.44 2.32 2.18 0 4.16-.75 5.75-2l3.14 2.36C30.66 37.06 27.51 38.5 24 38.5z"
                            fill="green" />
                    </svg>
                </button>

                <!-- Apple -->
                <button class="bg-white rounded-lg p-3 hover:bg-gray-100 transition shadow-md">
                    <svg class="w-6 h-6" fill="black" viewBox="0 0 24 24">
                        <path
                            d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.48-3.24 0-1.44.62-2.2.44-3.06-.4C2.79 15.25 3.51 7.59 9.05 7.31c1.35.06 2.29.77 3.06.8.98-.04 1.88-.63 2.99-.52 1.45.12 2.51.72 3.15 1.81-2.94 1.82-2.45 5.76.48 6.75-.48 1.45-1.47 2.38-2.68 2.93zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                    </svg>
                </button>


                <!-- Facebook -->
                <button class="bg-white rounded-lg p-3 hover:bg-gray-100 transition shadow-md">
                    <svg class="w-6 h-6" fill="black" viewBox="0 0 24 24">
                        <path
                            d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 3.667h-3.533v7.98H9.101z" />
                    </svg>
                </button>
            </div>

            <!-- Sign Up Link -->
            <p class="text-center text-text-white">
                {{ __('Have an account already?') }}
                <a href="{{ route('login') }}"
                    class="text-purple-700 transition font-medium">{{ __('Sign in') }}</a>
            </p>
        </div>
    </div>
</div>
