<div class="container mx-auto">
    <div class="min-h-[80vh] flex items-center justify-center text-white">

        <!-- Correct form submission -->
        <form wire:submit="verifyOtp"
            class="w-full min-h-[55vh] max-w-lg bg-bg-primary rounded-2xl p-8 shadow-lg space-y-8">

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
                <x-ui.input type="text" placeholder="Enter your code" wire:model="form.code"
                    />
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
                    <x-ui.button class="w-auto py-2!" type="submit">
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
