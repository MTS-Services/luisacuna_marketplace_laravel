<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Access Denied') }}</title>
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
                            class="absolute -inset-6 bg-gradient-to-r from-pink-500/20 to-rose-500/20 rounded-full blur-2xl">
                        </div>
                        <div class="relative bg-gradient-to-br from-pink-500 to-rose-600 rounded-full p-6 w-24 h-24 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4v2m0 6v2M6.34 4.97a1 1 0 100 1.41 1 1 0 000-1.41zm11.32 0a1 1 0 100 1.41 1 1 0 000-1.41zM5 12a1 1 0 11-2 0 1 1 0 012 0zm14 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m0 0h6m-6 0V6m0 6v6">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Code -->
                <div class="text-center mb-6">
                    <p class="text-7xl lg:text-8xl font-black bg-gradient-to-r from-pink-500 to-rose-600 bg-clip-text text-transparent tracking-tighter">
                        403
                    </p>
                </div>

                <!-- Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-text-white text-center mb-4">
                    {{ __('Access Denied') }}
                </h1>

                <!-- Description -->
                <div class="bg-bg-primary rounded-xl p-6 mb-8">
                    <p class="text-text-white text-center text-base leading-relaxed">
                        {{ __('Sorry, the checkout link has expired or you do not have permission to access this page.') }}
                    </p>
                    <div class="mt-4 p-4 bg-rose-500/10 border border-rose-500/30 rounded-lg">
                        <p class="text-rose-400 text-sm font-medium text-center">
                            {{ __('Please check your email for a new checkout link or request a new one.') }}
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
                        {{ __('Need help?') }}
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
                    {{ __('Error Code') }}: <span class="font-mono text-pink-500">ERR_403_CHECKOUT</span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
