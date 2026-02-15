<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Checkout Not Found') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-page antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-2xl">
            <!-- Main Error Card -->
            <div class="bg-zinc-50 dark:bg-bg-secondary rounded-2xl p-8 lg:p-12 shadow-2xl">
                <!-- Icon Section -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div
                            class="absolute -inset-6 bg-gradient-to-r from-orange-500/20 to-pink-500/20 rounded-full blur-2xl">
                        </div>
                        <div class="relative bg-gradient-to-br from-orange-500 to-pink-600 rounded-full p-6 w-24 h-24 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Code -->
                <div class="text-center mb-6">
                    <p class="text-7xl lg:text-8xl font-black bg-gradient-to-r from-orange-500 to-pink-600 bg-clip-text text-transparent tracking-tighter">
                        404
                    </p>
                </div>

                <!-- Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-text-white text-center mb-4">
                    {{ __('Checkout Not Found') }}
                </h1>

                <!-- Description -->
                <div class="bg-bg-primary rounded-xl p-6 mb-8">
                    <p class="text-text-white text-center text-base leading-relaxed">
                        {{ __('Sorry, the checkout link is invalid or has expired. This could happen if:') }}
                    </p>
                    <ul class="mt-4 space-y-2 text-text-secondary text-sm">
                        <li class="flex items-start gap-3">
                            <span class="text-pink-500 font-bold mt-1">•</span>
                            <span>{{ __('The checkout link has already been used') }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-pink-500 font-bold mt-1">•</span>
                            <span>{{ __('The link expired (typically after 24 hours)') }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-pink-500 font-bold mt-1">•</span>
                            <span>{{ __('You may have followed an incorrect link') }}</span>
                        </li>
                    </ul>
                    <div class="mt-4 p-4 bg-orange-500/10 border border-orange-500/30 rounded-lg">
                        <p class="text-orange-400 text-sm font-medium text-center">
                            {{ __('Request a new checkout link from the seller') }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}"
                        class="px-8 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-center">
                        {{ __('Back to Home') }}
                    </a>

                    <a href="{{ route('user.order.purchased-orders') }}"
                        class="px-8 py-3 bg-bg-primary hover:bg-bg-primary/80 text-text-white font-semibold rounded-lg transition-all duration-200 border border-zinc-500 hover:border-zinc-400 text-center">
                        {{ __('View My Orders') }}
                    </a>
                </div>

                <!-- Help Section -->
                <div class="mt-10 pt-8 border-t border-zinc-500">
                    <p class="text-text-secondary text-sm text-center mb-4">
                        {{ __('Still need help?') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center text-sm">
                        <a href="{{ route('faq') }}"
                            class="text-pink-500 hover:text-pink-600 font-medium transition-colors">
                            {{ __('View FAQ') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Message -->
            <div class="text-center mt-8">
                <p class="text-text-secondary text-sm">
                    {{ __('Error Code') }}: <span class="font-mono text-pink-500">ERR_404_CHECKOUT</span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
