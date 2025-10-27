<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-6">
        <div class="container mx-auto min-h-[80vh]">
            <script>
                function togglePassword(id) {
                    const input = document.getElementById(id);
                    input.type = input.type === "password" ? "text" : "password";
                }
            </script>

            <div class="min-h-screen flex items-center justify-center bg-[#0D061A] text-white px-4 sm:px-6 lg:px-8">
                <form method="POST" wire:submit.prevent="resetPassword" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
                    <div class="bg-[#1a0b2e] rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col justify-between h-[900px]">

                        <!-- Header -->
                        <div class="mb-6 text-center">
                            <h2 class="text-3xl sm:text-4xl font-medium text-white">Create Password</h2>
                            <p class="text-gray-300 lg:text-xl sm:text-lg mt-2">
                                Hi! Welcome back, you’ve been missed
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-white">Email</label>
                            <input type="email" placeholder="example@gmail.com" wire:model="email"
                                class="text-white w-full px-4 py-2 bg-[#2d1f43] border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                        </div>

                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Password -->
                        <div class="mb-2 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-white">Password</label>

                            <div class="relative">
                                <input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                                    class="text-white w-full px-4 py-2 bg-[#2d1f43] border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="gray" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Confirm Password -->
                        <div class="mb-2 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-white">Confirm
                                Password</label>

                            <div class="relative">
                                <input type="password" id="confirmPassword" placeholder="Aex@8465"
                                    wire:model="password_confirmation"
                                    class="text-white w-full px-4 py-2 bg-[#2d1f43] border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400" />
                                <button type="button" onclick="togglePassword('confirmPassword')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="gray" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('confirmPassword')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Submit button -->
                        <div class="flex justify-center mb-6 px-2 sm:px-6">
                            <button type="submit"
                                class="bg-[#853fee] hover:bg-purple-700 transition-colors text-white font-medium py-3 w-full sm:w-auto sm:px-24 md:px-48 rounded-full">
                                Sign in
                            </button>
                        </div>

                        <!-- Divider -->
                        <div class="flex items-center mb-6 px-4">
                            <hr class="flex-1 border-gray-700" />
                            <span class="px-3 text-sm sm:text-md text-gray-200">Or sign in with</span>
                            <hr class="flex-1 border-gray-700" />
                        </div>

                        <!-- Social login -->
                        <div class="flex justify-center gap-4 mb-6">
                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                                    alt="Google" />
                            </button>

                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10" alt="Apple" />
                            </button>

                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-facebook.svg') }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10" alt="Facebook" />
                            </button>
                        </div>

                        <!-- Sign up link -->
                        <div class="text-center text-sm text-gray-300">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="text-purple-400 hover:underline">Sign up</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
