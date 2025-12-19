{{-- <div>
    <div
        class="min-h-screen flex items-center justify-center bg-cover bg-center bg-light-bg-login dark:bg-dark-bg-login">
        <div
            class="w-full max-w-xl bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-20 my-20 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center items-center h-[102px] mb-5 sm:mb-11">
                    <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                        class="max-w-full max-h-full object-contain">
                </div>
                <h2 class="text-3xl sm:text-4xl font-semibold text-white mb-3">
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
                    <p class="text-white lg:text-xl sm:text-lg mt-2">
                        {{ __('We have sent a code in an Email message to') }}
                        <span class="font-semibold text-white">{{ $email }}</span>
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
                        <div class="mb-4 sm:mb-6 px-2 sm:px-6 mt-11">
                            <label
                                class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Code') }}</label>
                            <x-ui.input type="number" placeholder="Enter your otp" wire:model="otp_code"
                                class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                            <x-ui.input-error :messages="$errors->get('otp_code')" />
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
                                        class="group inline-flex items-center gap-1.5 text-zinc-400 hover:text-zinc-300 transition-all duration-200 font-medium">
                                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span
                                            class="text-white text-xs font-normal">{{ __('Don’t have resend again?') }}</span>
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
                                            <span class="font-bold text-zinc-400 tabular-nums"
                                                x-text="formatTime(timeLeft)"></span>
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class=" flex justify-center px-2 sm:px-6 mt-12">
                            <x-ui.button type="submit" class="w-auto py-2!">
                                {{ __('Verify') }}
                            </x-ui.button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Divider -->
            <div class="flex items-center mb-11 mt-11 px-4">
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
                        <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}" class="w-full h-full rounded-md"
                            alt="Apple" />
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
    </div>
</div> --}}
<div class="bg-cover bg-center  bg-light-bg-login dark:bg-dark-bg-login">

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit="verifyOtp" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 sm:p-20 my-20 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <div class="text-center mb-8">
                    <div class="flex justify-center items-center h-[102px] mb-5 md:mb-11">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-semibold text-white mb-3">
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
                        <p class="text-white lg:text-xl sm:text-lg mt-2">
                            {{ __('We have sent a code in an Email message to') }}
                            <span class="font-semibold text-white">{{ $email }}</span>
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
                            <div class="mb-4 sm:mb-6 px-2 sm:px-6 mt-5 md:mt-11">
                                <label
                                    class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Code') }}</label>
                                <x-ui.input type="number" placeholder="Enter your otp" wire:model="otp_code"
                                    class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                                <x-ui.input-error :messages="$errors->get('otp_code')" />
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
                                            class="group inline-flex items-center gap-1.5 text-zinc-400 hover:text-zinc-300 transition-all duration-200 font-medium">
                                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span
                                                class="text-white text-xs font-normal">{{ __('Don’t have resend again?') }}</span>
                                        </button>
                                    </template>

                                    <template x-if="!canResend">
                                        <div class="inline-flex items-center gap-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm">
                                                {{ __('Resend OTP in') }}
                                                <span class="font-bold text-zinc-400 tabular-nums"
                                                    x-text="formatTime(timeLeft)"></span>
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class=" flex justify-center px-2 sm:px-6 mt-12">
                                <x-ui.button type="submit" class="w-auto py-2!">
                                    {{ __('Verify') }}
                                </x-ui.button>
                            </div>
                        </form>
                    @endif
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-11 mt-11 px-4">
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
                    <div class="text-center text-sm xs:text-base font-normal text-white">
                        {{ __('Have an account already?') }}
                        <a href="{{ route('login') }}"
                            class="text-pink-500 text-sm xs:text-base font-normal hover:underline">{{ __('Sign in') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
