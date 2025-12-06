<div>
    <div class="bg-bg-primary min-h-screen flex items-center justify-center">
        <div class="w-full max-w-xl bg-gradient-to-br bg-bg-secondary rounded-2xl px-8 py-22 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl font-medium text-text-white">
                    {{ $isVerified ? __('Email Verified!') : __('Confirm your Gmail') }}
                </h2>

                @if ($isVerified)
                    <div class="bg-green-500/20 border border-green-500 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-center gap-2 text-green-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span
                                class="text-text-white lg:text-xl sm:text-lg mt-2">{{ __('Your email has been verified successfully!') }}</span>
                        </div>
                    </div>
                    <p class="text-text-white lg:text-xl sm:text-lg mt-2">
                        {{ __('Click the button below to continue setting up your password.') }}</p>
                @else
                    <p class="text-text-white lg:text-xl sm:text-lg mt-2">
                        {{ __('We have sent a code in an Email message to') }}
                        <span class="font-semibold text-purple-400">{{ $email }}</span>
                        {{ __('to confirm your account. Enter your code.') }}
                    </p>
                @endif
            </div>

            <!-- Form -->
            <div>
                @if ($isVerified)
                    <!-- Already Verified - Show Continue Button -->
                    <div class="space-y-6">
                        <x-ui.button wire:click="proceedToNextStep" class="w-full! py-3!">
                            <span
                                class="text-text-btn-primary group-hover:text-text-btn-secondary flex items-center justify-center gap-2">
                                {{ __('Continue to Password Setup') }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </x-ui.button>
                    </div>
                @else
                    <!-- OTP Verification Form -->
                    <form wire:submit="verifyOtp" class="space-y-6">
                        <!-- OTP Input -->
                        <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                            <label
                                class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Code') }}</label>
                            <x-ui.input type="number" placeholder="Enter your otp" wire:model="otp_code" />
                            {{-- Error message --}}
                            <x-ui.input-error :messages="$errors->get('email')" />
                        </div>

                        <!-- Resend OTP with Countdown Timer -->
                        <div class="text-right">
                            <div x-data="{
                                timeLeft: @entangle('remainingTime'),
                                canResend: @entangle('canResend'),
                                countdown: null,
                            
                                init() {
                                    if (this.timeLeft > 0) {
                                        this.startCountdown();
                                    }
                            
                                    this.$watch('timeLeft', (value) => {
                                        if (value > 0 && !this.countdown) {
                                            this.startCountdown();
                                        }
                                    });
                                },
                            
                                startCountdown() {
                                    if (this.countdown) {
                                        clearInterval(this.countdown);
                                    }
                            
                                    this.countdown = setInterval(() => {
                                        if (this.timeLeft > 0) {
                                            this.timeLeft--;
                                        } else {
                                            clearInterval(this.countdown);
                                            this.countdown = null;
                                            this.canResend = true;
                                        }
                                    }, 1000);
                                },
                            
                                formatTime(seconds) {
                                    const mins = Math.floor(seconds / 60);
                                    const secs = seconds % 60;
                                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                                }
                            }" x-init="init()">

                                <template x-if="canResend">
                                    <button type="button" wire:click.prevent="resendOtp"
                                        class="group inline-flex items-center gap-1.5 text-purple-400 hover:text-purple-300 transition-all duration-200 font-medium">
                                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span>{{ __("Don't receive OTP? Resend") }}</span>
                                    </button>
                                </template>

                                <template x-if="!canResend">
                                    <div class="inline-flex items-center gap-2 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm">
                                            {{ __('Resend OTP in') }}
                                            <span class="font-bold text-purple-400 tabular-nums"
                                                x-text="formatTime(timeLeft)"></span>
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class=" flex justify-center px-2 sm:px-6">
                            <x-ui.button type="submit" class="w-auto py-2!">
                                {{ __('Verify') }}
                            </x-ui.button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 border-t"></div>
                <p class="px-3 text-text-white text-sm">{{ __('Or sign in with') }}</p>
                <div class="flex-1 border-t"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="flex justify-center gap-4 mb-6">
                <!-- Google -->
                <button class="bg-white rounded-lg p-3 hover:bg-gray-100 transition shadow-md">
                    <svg class="w-6 h-6" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l-3.76 3.76C27.95 15.38 26.08 14.5 24 14.5c-5.22 0-9.5 4.28-9.5 9.5s4.28 9.5 9.5 9.5c4.05 0 7.5-2.55 8.78-6.1h-8.78v-5h14.26c.17.84.26 1.71.26 2.6 0 8.28-5.73 14.5-14.52 14.5-8.25 0-14.98-6.73-14.98-15s6.73-15 14.98-15z"
                            fill="blue" />
                        <path
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l-3.76 3.76C27.95 15.38 26.08 14.5 24 14.5c-5.22 0-9.5 4.28-9.5 9.5 0 1.67.44 3.24 1.21 4.6l-3.84 2.94C10.53 29.55 9.5 26.89 9.5 24c0-8.27 6.73-15 14.5-15z"
                            fill="red" />
                        <path
                            d="M11.87 31.54C10.53 29.55 9.5 26.89 9.5 24c0-1.27.17-2.49.48-3.65l3.84 2.94c-.27.86-.42 1.78-.42 2.71 0 1.9.57 3.67 1.53 5.15l-3.06 2.39z"
                            fill="yellow" />
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
                    <svg class="w-6 h-6 text-blue-600" fill="black" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </button>
            </div>

            <!-- Sign In Link -->
            <p class="text-center text-text-white">
                {{ __('Have an account already?') }}
                <a href="{{ route('login') }}" class="text-purple-700 transition font-medium">{{ __('Sign in') }}</a>
            </p>
        </div>
    </div>
</div>
