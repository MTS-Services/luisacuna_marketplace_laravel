<x-frontend::app>
    <x-slot name="title">{{ __('Expired Checkout Link') }}</x-slot>
    <x-slot name="pageSlug">expired-checkout-link</x-slot>

    <style>
        @keyframes ring-pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .animate-ring {
            animation: ring-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    <div class="relative min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12 overflow-hidden">
        <div class="w-full max-w-md relative z-10">
            <div class="glass-card border border-white/10 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl">

                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full border-2 border-pink-500 animate-ring"></div>
                        <div
                            class="absolute inset-0 rounded-full border-2 border-pink-500 animate-ring [animation-delay:1s]">
                        </div>

                        <div
                            class="relative flex items-center justify-center w-24 h-24 rounded-full bg-bg-secondary border border-pink-500/30 text-pink-500 shadow-xl">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path class="origin-center animate-[spin_10s_linear_infinite]" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3" />
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-3 mb-10">
                    <h1 class="text-40px font-black text-text-primary tracking-tight leading-none">{{ __('403') }}
                    </h1>
                    <h2 class="text-xl font-bold text-text-primary uppercase tracking-widest">{{ __('Link Expired') }}
                    </h2>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('home') }}"
                        class="animate-shimmer bg-linear-to-r from-pink-600 via-pink-400 to-pink-600 bg-[length:200%_100%] flex items-center justify-center w-full py-4 text-white font-bold rounded-2xl shadow-lg transition-transform duration-200">
                        {{ __('Back to Homepage') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-frontend::app>
