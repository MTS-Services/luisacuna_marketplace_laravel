<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- ============================================================
             STATE 1: No profile yet → prompt to start
        ============================================================ --}}
        @if (!$sellerProfile)
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">🔍</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">
                    {{ __('Seller verification required') }}
                </h2>
                <p class="dark:text-text-white text-zinc-500/50 mb-2">
                    {{ __('To sell currencies, please verify your identity first.') }}
                </p>
                <p class="dark:text-text-white text-zinc-500/50 mb-8">
                    {{ __('Our 24/7 support team will review your ID in up to 15 minutes.') }}
                </p>

                <a class="cursor-pointer bg-bg-secondary rounded-lg p-6 mb-6 inline-block"
                    wire:click.prevent="startVerification">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">{{ __('Seller Verification') }}</p>
                            <span class="inline-block px-3 py-1 bg-pink-500 text-white text-sm rounded-full">
                                {{ __('Documents required') }}
                            </span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </a>

                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">
                    {{ __('Why do I need to verify my ID?') }}
                </a>
            </div>

            {{-- ============================================================
             STATE 2: Rejected → show reason + allow re-submission
        ============================================================ --}}
        @elseif ($sellerProfile->rejected_at && !$sellerProfile->seller_verified)
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">❌</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">
                    {{ __('Your verification was rejected') }}
                </h2>
                <p class="dark:text-text-white text-zinc-500/50 mb-2">
                    {{ __('Unfortunately, your submitted documents did not meet our requirements.') }}
                </p>
                {{-- <p class="dark:text-text-white text-zinc-500/50 mb-6">
                    {{ __('Please review the reason below and re-submit with the correct documents.') }}
                </p> --}}

                {{-- Rejection Reason Card --}}
                <div class="max-w-lg mx-auto mb-8">
                    <div
                        class="rounded-2xl border border-red-200 dark:border-red-500/30 bg-red-50 dark:bg-red-500/10 p-6 text-left space-y-4">

                        {{-- Rejected At --}}
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest">
                                    {{ __('Rejected At') }}
                                </p>
                                <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                    {{ $sellerProfile->rejected_at->format('d M, Y  H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- Reason --}}
                        @if ($sellerProfile->rejected_reason)
                            <div class="pt-4 border-t border-red-100 dark:border-red-500/20">
                                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">
                                    {{ __('Reason') }}
                                </p>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">
                                    {{ $sellerProfile->rejected_reason }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Re-submit CTA --}}
                {{-- <a class="cursor-pointer bg-bg-secondary rounded-lg p-6 mb-6 inline-block hover:opacity-90 transition-opacity"
                    wire:click.prevent="startVerification">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">{{ __('Re-submit Verification') }}</p>
                            <span class="inline-block px-3 py-1 bg-red-500 text-white text-sm rounded-full">
                                {{ __('Action required') }}
                            </span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </a> --}}

                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">
                    {{ __('Why do I need to verify my ID?') }}
                </a>
            </div>

            {{-- ============================================================
             STATE 3: Submitted but pending review
        ============================================================ --}}
        @elseif (!$sellerProfile->is_verified)
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">⏳</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">
                    {{ __('Your documents are pending review') }}
                </h2>
                <p class="dark:text-text-white text-zinc-500/50 mb-2">
                    {{ __('To sell currencies, please verify your identity first.') }}
                </p>
                <p class="dark:text-text-white text-zinc-500/50 mb-8">
                    {{ __('Our 24/7 support team will review your ID in up to 15 minutes.') }}
                </p>

                <a class="cursor-not-allowed bg-bg-secondary rounded-lg p-6 mb-6 inline-block opacity-60">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">{{ __('Seller Verification') }}</p>
                            <span class="inline-block px-3 py-1 bg-amber-500 text-white text-sm rounded-full">
                                {{ __('Under review') }}
                            </span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </a>

                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">
                    {{ __('Why do I need to verify my ID?') }}
                </a>
            </div>

            {{-- ============================================================
             STATE 4: Fully verified
        ============================================================ --}}
        @else
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto w-32 h-32 flex items-center justify-center">
                        <span class="text-8xl">✅</span>
                    </div>
                </div>

                <h2 class="text-2xl font-bold dark:text-text-white text-zinc-500/80 mb-4">
                    {{ __('Your documents have been verified') }}
                </h2>
                <p class="dark:text-text-white text-zinc-500/50 mb-2">
                    {{ __('You are now a verified seller and can start listing currencies.') }}
                </p>
                <p class="dark:text-text-white text-zinc-500/50 mb-8">
                    {{ __('Thank you for completing your identity verification.') }}
                </p>

                <a class="cursor-not-allowed bg-bg-secondary rounded-lg p-6 mb-6 inline-block opacity-60">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center">
                            <img src="{{ asset('assets/images/verification.svg') }}" alt="">
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-semibold">{{ __('Seller Verification') }}</p>
                            <span class="inline-block px-3 py-1 bg-emerald-500 text-white text-sm rounded-full">
                                {{ __('Verified') }}
                            </span>
                        </div>
                        <x-phosphor-caret-right class="w-6 h-6 fill-zinc-500" />
                    </div>
                </a>

                <a href="#" class="block mt-4 text-zinc-600/80 hover:underline">
                    {{ __('Why do I need to verify my ID?') }}
                </a>
            </div>
        @endif

    </div>
</div>
