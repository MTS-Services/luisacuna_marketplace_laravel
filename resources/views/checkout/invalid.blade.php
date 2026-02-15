<x-frontend::app>
    <x-slot name="title">{{ __('Invalid Checkout Link') }}</x-slot>
    <x-slot name="pageSlug">invalid-checkout-link</x-slot>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(3deg);
            }

            50% {
                transform: translateY(-10px) rotate(-3deg);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>

    <div class="relative min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12 overflow-hidden">
        <div class="absolute top-0 -left-20 w-72 h-72 bg-zinc-500/10 rounded-full blur-[100px] pointer-events-none">
        </div>

        <div class="w-full max-w-md relative z-10">
            <div
                class="glass-card border border-zinc-200/20 dark:border-zinc-700/30 rounded-[2.5rem] p-8 sm:p-10 shadow-2xl">

                <div class="text-center mb-8">
                    <div
                        class="animate-float inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-linear-to-tr from-pink-500 to-zinc-500 shadow-lg shadow-pink-500/20 mb-6">
                        <svg class="w-12 h-12 text-white animate-spin [animation-duration:8s]" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>

                    <h1 class="text-3xl font-black text-text-primary mb-2 uppercase tracking-tight">
                        {{ __('Link Invalid') }}</h1>
                    <div class="h-1 w-12 bg-pink-500 mx-auto rounded-full animate-shimmer bg-[length:200%_100%]"></div>
                </div>

                <div class="bg-bg-secondary/50 rounded-2xl p-5 mb-8 border border-zinc-500/10">
                    <p class="text-text-secondary text-sm leading-relaxed text-center italic">
                        "{{ __('This link has either expired, been used, or contains a security mismatch.') }}"
                    </p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('home') }}"
                        class="flex items-center justify-center w-full py-4 bg-zinc-600 dark:bg-zinc-500 hover:bg-zinc-700 dark:hover:bg-zinc-400 text-white font-bold rounded-xl shadow-lg transition-all duration-300">
                        {{ __('Return Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-frontend::app>
