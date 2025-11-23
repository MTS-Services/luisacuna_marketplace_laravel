<div>
    <div class="bg-bg-secondary min-h-screen flex items-center justify-center p-4">
        <div class="w-full  max-w-lg bg-gradient-to-br bg-bg-primary rounded-2xl px-8 py-22 shadow-2xl ">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-medium text-white mb-4">{{ __('Sign Up') }}</h1>
                <p class="text-gray-300">{{ __('Hi! Welcome back, you\'ve been missed') }}</p>
            </div>

            <!-- Form -->
            <form wire:submit="save" class="space-y-6">
                <!-- First name Input -->
                <div>
                    <x-ui.label value="First name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Enter First Name" wire:model="first_name"
                        class="border-none! bg-purple-300/10! bg-opacity-50!" />
                    <x-ui.input-error :messages="$errors->get('first_name')" />
                </div>

                <!-- Last name Input -->
                <div>
                    <x-ui.label value="Last name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Enter Last Name" wire:model="last_name"
                        class="border-none! bg-purple-300/10! bg-opacity-50!" />
                    <x-ui.input-error :messages="$errors->get('last_name')" />
                </div>

                <!-- Next Button -->
                <div>
                    <x-ui.button class="w-full! py-2!" type="submit">
                        <span class="text-text-btn-primary group-hover:text-text-btn-secondary">
                            {{ __('Next') }}
                        </span>
                    </x-ui.button>
                </div>
            </form>

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
                    <svg class="w-6 h-6 text-blue-600" fill="black" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </button>
            </div>

            <!-- Sign Up Link -->
            <p class="text-center text-text-white">
                {{ __('Have an account already?') }}
                <a href="{{ route('login') }}" class="text-purple-700 transition font-medium">{{ __('Sign in') }}</a>
            </p>
        </div>
    </div>
</div>
