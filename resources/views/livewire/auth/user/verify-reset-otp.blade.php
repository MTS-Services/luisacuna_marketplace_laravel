<div class="container mx-auto">
    <div class="min-h-screen flex items-center justify-center bg-[#0D061A] text-white">

        <!-- Correct form submission -->
        <form wire:submit="verifyOtp"
            class="-mt-28 w-full h-[600px] max-w-lg bg-[#1a0b2e] rounded-2xl p-8 shadow-lg space-y-8">

            <!-- Header -->
            <div class="text-center">
                <h2 class="text-4xl font-medium p-4 text-white">Confirm your account</h2>
                <p class="text-gray-300 lg:text-xl text-sm">
                     We have sent a code in an Email message to ex***@gmail.com To confirm your account, please enter the
                    code.
                </p>
            </div>

            <!-- Code -->
            <div>
                <label class="block text-xl font-medium mb-2 text-white">Code</label>
                <input type="text" placeholder="Enter your code" wire:model="form.code"
                    class="w-full px-4 py-3 bg-[#2d1f43] text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            @error('form.code')
                <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror

            <div class="text-right" id="resend-container">
                @if($resendCooldown && $resendCooldown > 0)
                    <span class="text-md text-gray-400">
                        Resend available in <span id="countdown" class="font-semibold text-white">{{ $resendCooldown }}</span>s
                    </span>
                @else
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-gray-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">Resend</span>
                        <span wire:loading wire:target="resendOtp">Sending...</span>
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
                <x-ui.button href="{{ route('login') }}" variant='secondary' class="w-auto py-2!">
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const STORAGE_KEY = 'password_reset_countdown_{{ $email }}';
        const STORAGE_TIMESTAMP_KEY = 'password_reset_timestamp_{{ $email }}';
        
        let countdown = @js($resendCooldown);
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
            if (countdown > 0) {
                resendContainer.innerHTML = `
                    <span class="text-md text-gray-400">
                        Resend available in <span id="countdown" class="font-semibold text-white">${countdown}</span>s
                    </span>
                `;
                countdownElement = document.getElementById('countdown');
            } else {
                resendContainer.innerHTML = `
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-gray-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">Resend</span>
                        <span wire:loading wire:target="resendOtp">Sending...</span>
                    </button>
                `;
            }
        }

        // Check if there's a stored countdown on page load
        const storedTimestamp = localStorage.getItem(STORAGE_TIMESTAMP_KEY);
        if (storedTimestamp) {
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
        } else if (countdown && countdown > 0) {
            // Start countdown from server value
            startCountdown(countdown);
        }

        // Listen for resend event to restart countdown
        Livewire.on('otp-resent', () => {
            startCountdown(30);
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
        });
    });
</script>