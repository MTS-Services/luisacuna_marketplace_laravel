<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 dark:bg-gray-900 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Verify Your Email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                We've sent a 6-digit verification code to
                <span class="font-medium text-gray-900 dark:text-white">{{ $admin->email }}</span>
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-red-50 p-4 dark:bg-red-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit="verify" class="mt-8 space-y-6">
            <div>
                <label for="code" class="block text-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                    Enter verification code
                </label>
                
                <div class="flex justify-center">
                    <x-auth.input-otp 
                        wire:model="code"
                        digits="6"
                        name="code"
                    />
                </div>

                @error('code')
                    <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove>Verify Code</span>
                    <span wire:loading>Verifying...</span>
                </button>
            </div>

            <div class="flex items-center justify-between text-sm">
                <button
                    type="button"
                    wire:click="resendOtp"
                    wire:loading.attr="disabled"
                    class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="resendOtp">Resend code</span>
                    <span wire:loading wire:target="resendOtp">Sending...</span>
                </button>

                <a 
                    href="{{ route('admin.login') }}"
                    wire:navigate
                    class="font-medium text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300"
                >
                    Back to login
                </a>
            </div>
        </form>

        <div class="text-center text-xs text-gray-500 dark:text-gray-400">
            <p>Code expires in 10 minutes</p>
        </div>
    </div>
</div>