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

            <div class="text-right">
                <button type="button" wire:click="resendOtp" class="text-md text-gray-300 hover:underline">
                    Resent
                </button>
            </div>

            <!-- Submit button -->
            <div>
                <div>
                    <x-ui.button class="w-auto py-2!">
                        {{ __('Verify') }}
                    </x-ui.button>
                </div>
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
