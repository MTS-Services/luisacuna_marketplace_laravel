{{-- <div class="container mx-auto">
    <div class="min-h-[80vh] flex items-center justify-center">

        <!-- Correct form submission -->
        <form wire:submit="verifyOtp"
            class="w-full min-w-[55vh] max-w-lg bg-bg-primary rounded-2xl p-8 shadow-lg space-y-8">

            <!-- Header -->
            <div class="text-center">
                <h2 class="text-4xl font-medium p-4 text-text-white">{{__('Confirm your account')}}</h2>
                <p class="text-text-white lg:text-xl text-sm">
                    {{ __('We have sent a code in an Email message to ex***@gmail.com To confirm your account, please enter the
                    code.') }}
                </p>
            </div>

            <!-- Code -->
            <div>
                <label class="block text-xl font-medium mb-2 text-text-white">{{__('Code')}}</label>
                <x-ui.input type="text" placeholder="Enter your code" wire:model="form.code"
                    />
            </div>

            @error('form.code')
                <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror

            <div class="text-right" id="resend-container">
                @if (isset($resendLimitReached) && $resendLimitReached)
                    <span class="text-md text-red-400 font-semibold">
                        {{ __('Don\'t resend again. Maximum limit reached.') }}
                    </span>
                @elseif($resendCooldown && $resendCooldown > 0)
                    <span class="text-md text-zinc-400">
                        {{ __('Resend available in') }} <span id="countdown"
                            class="font-semibold text-text-white">{{ $resendCooldown }}</span>s
                        <span class="text-xs text-zinc-500">({{ 6 - ($resendAttempts ?? 0) }} left)</span>
                    </span>
                @else
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-zinc-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">{{ __('Resend') }}
                            <span class="text-xs text-zinc-500">({{ 6 - ($resendAttempts ?? 0) }} left)</span></span>
                        <span wire:loading wire:target="resendOtp">{{ __('Sending...') }}</span>
                    </button>
                @endif
            </div>

            <!-- Submit button -->
            <div>
                <x-ui.button class="w-auto py-2!" type="submit">
                    {{ __('Verify') }}
                </x-ui.button>
            </div>

            <!-- Back to login page -->
            <div>
                <x-ui.button href="{{ route('admin.login') }}" variant='secondary' class="w-auto py-2!  mb-2 sm:mb-6">
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</div> --}}

<div class="bg-cover bg-center bg-page-login">

    <div class="min-h-[100vh] flex items-center justify-center text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit="verifyOtp" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div
                class="bg-zinc-900/40 dark:bg-bg-secondary/75 backdrop-blur-sm dark:backdrop-blur-sm rounded-2xl p-8 shadow-lg flex flex-col justify-between">

                <!-- Header -->
                <div class=" text-center">
                    <div class="flex justify-center items-center h-[102px] mb-5">
                        <img src="{{ asset('assets/images/background/login-logo.png') }}" alt=""
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <h2 class="text-4xl font-medium p-4 text-text-white">{{ __('Confirm your account') }}</h2>
                    <p class="text-text-whitelg:text-xl text-sm">
                        {{ __('We have sent a code in an Email message to ex***@gmail.com To confirm your account, please enter the code.') }}
                    </p>
                </div>
                <div class="space-y-6">

                    <div class="mb-4 sm:mb-7 px-2 sm:px-7">
                        <label
                            class="block text-lg sm:text-2xl font-medium mb-1 sm:mb-4 text-white">{{ __('Code') }}</label>
                        <x-ui.input type="text" placeholder="Enter your code" wire:model="form.code"
                            class="bg-bg-info! rounded-xl! border-0! focus:ring-0! text-white! placeholder:text-white!" />
                        <!-- Error message -->
                        <x-ui.input-error :messages="$errors->get('form.code')" />
                    </div>
                    <!-- Submit button -->
                    <div class=" flex justify-center px-2 sm:px-6 mt-11">
                        <x-ui.button type="submit" class="w-auto py-2! text-white text-base! font-semibold!">
                            {{ __('Verify') }}
                        </x-ui.button>
                    </div>
                    <div class=" flex justify-center px-2 sm:px-6 mt-7 mb-4">
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

<script>
    document.addEventListener('livewire:initialized', () => {
        const STORAGE_KEY = 'admin_password_reset_countdown_{{ $email }}';
        const STORAGE_TIMESTAMP_KEY = 'admin_password_reset_timestamp_{{ $email }}';

        let countdown = @js($resendCooldown);
        let resendLimitReached = @js($resendLimitReached ?? false);
        let resendAttempts = @js($resendAttempts ?? 0);
        let countdownElement = document.getElementById('countdown');
        let resendContainer = document.getElementById('resend-container');
        let intervalId = null;

        function startCountdown(initialSeconds) {
            // Clear any existing interval
            if (intervalId) {
                clearInterval(intervalId);
            }

            countdown = initialSeconds;

            // Store initial countdown and timestamp
            localStorage.setItem(STORAGE_KEY, countdown);
            localStorage.setItem(STORAGE_TIMESTAMP_KEY, Date.now());

            // Update UI immediately
            updateUI();

            intervalId = setInterval(() => {
                countdown--;

                // Update localStorage
                localStorage.setItem(STORAGE_KEY, countdown);

                // Update UI
                updateUI();

                if (countdown <= 0) {
                    clearInterval(intervalId);
                    localStorage.removeItem(STORAGE_KEY);
                    localStorage.removeItem(STORAGE_TIMESTAMP_KEY);

                    // Update component state and reload
                    @this.updateResendCooldown().then(() => {
                        location.reload();
                    });
                }
            }, 1000);
        }

        function updateUI() {
            const remainingResends = 6 - resendAttempts;

            if (resendLimitReached) {
                resendContainer.innerHTML = `
                    <span class="text-md text-red-400 font-semibold">
                        Don't resend again. Maximum limit reached.
                    </span>
                `;
            } else if (countdown > 0) {
                resendContainer.innerHTML = `
                    <span class="text-md text-zinc-400">
                        Resend available in <span id="countdown" class="font-semibold text-text-white">${countdown}</span>s
                        <span class="text-xs text-zinc-500">(${remainingResends} left)</span>
                    </span>
                `;
                countdownElement = document.getElementById('countdown');
            } else {
                resendContainer.innerHTML = `
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-zinc-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">Resend <span class="text-xs text-zinc-500">(${remainingResends} left)</span></span>
                        <span wire:loading wire:target="resendOtp">Sending...</span>
                    </button>
                `;
            }
        }

        // Check if there's a stored countdown on page load
        const storedTimestamp = localStorage.getItem(STORAGE_TIMESTAMP_KEY);
        if (storedTimestamp && !resendLimitReached) {
            const elapsed = Math.floor((Date.now() - parseInt(storedTimestamp)) / 1000);
            const storedCountdown = parseInt(localStorage.getItem(STORAGE_KEY) || '0');
            const remainingTime = Math.max(0, storedCountdown - elapsed);

            if (remainingTime > 0) {
                startCountdown(remainingTime);
            } else {
                // Clean up expired countdown
                localStorage.removeItem(STORAGE_KEY);
                localStorage.removeItem(STORAGE_TIMESTAMP_KEY);
            }
        } else if (countdown && countdown > 0 && !resendLimitReached) {
            // Start countdown from server value
            startCountdown(countdown);
        }

        // Listen for resend event to restart countdown
        Livewire.on('otp-resent', (event) => {
            // Get attempts from event data
            if (event && event[0] && event[0].attempts) {
                resendAttempts = event[0].attempts;
            } else {
                resendAttempts++;
            }

            resendLimitReached = resendAttempts >= 6;

            console.log('Resend event received', {
                attempts: resendAttempts,
                limitReached: resendLimitReached
            });

            if (!resendLimitReached) {
                startCountdown(30);
            } else {
                updateUI();
            }
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
        });
    });
</script>
