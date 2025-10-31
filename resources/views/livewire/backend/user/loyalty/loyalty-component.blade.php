<div class="min-h-screen py-8 px-4">
    <div class="">
        {{-- Top Cards Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Bronze Level Card --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-text-primary font-open-sans text-lg">How it works?</h3>
                    <div class="flex items-center gap-2 bg-primary-800/50 px-3 py-1.5 rounded-lg">
                        <x-phosphor-coin class="text-secondary-500 w-5 h-5" weight="fill" />
                        <span class="text-white font-semibold">500</span>
                    </div>
                </div>

                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-600 to-yellow-800 flex items-center justify-center shadow-lg">
                            <x-phosphor-crown class="text-yellow-300 w-14 h-14" weight="fill" />
                        </div>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h4 class="text-white font-semibold text-xl mb-2">Bronze</h4>
                    <div class="text-text-secondary text-sm">500/2400</div>
                    <div class="w-full bg-primary-800/50 rounded-full h-2 mt-2">
                        <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-2 rounded-full"
                            style="width: 20%"></div>
                    </div>
                </div>

                <p class="text-text-secondary text-center text-sm">
                    You need an additional 1,900 points to reach the Silver level.
                </p>
            </div>

            {{-- Available Points Card --}}
            <div
                class="glass-card rounded-2xl p-6 border border-secondary-700/30 bg-gradient-to-br from-secondary-900/40 to-secondary-950/40">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-text-primary font-open-sans text-lg">Available points</h3>
                    <div class="flex items-center gap-2 bg-secondary-800/50 px-3 py-1.5 rounded-lg">
                        <x-phosphor-coin class="text-secondary-400 w-5 h-5" weight="fill" />
                        <span class="text-white font-semibold">500</span>
                    </div>
                </div>

                <p class="text-text-secondary text-sm mb-6">
                    Collect a minimum of 10,000 points and unlock a $1 reward.
                </p>

                <div class="bg-primary-900/50 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <div class="text-white font-bold text-2xl mb-1">10,000 points</div>
                        <div class="text-text-secondary text-sm">$1 Store credit</div>
                    </div>
                    <button
                        class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 flex items-center gap-2">
                        <span>Redeem</span>
                        <x-phosphor-arrow-right class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>

        {{-- Achievements Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <x-phosphor-trophy class="text-secondary-500 w-8 h-8" weight="fill" />
                <h2 class="text-white font-open-sans text-2xl font-bold">Achievements completed</h2>
            </div>
            <p class="text-text-secondary text-sm ml-11">0 / 10 completed</p>
        </div>

        {{-- Achievement Cards Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Critic Achievement --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <x-phosphor-pencil-line class="text-secondary-500 w-6 h-6" weight="fill" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-semibold text-lg mb-1">Critic</h4>
                        <p class="text-text-secondary text-sm">Write reviews for sellers</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-secondary">0 / 1 To unlock</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="text-secondary-500 w-4 h-4" weight="fill" />
                        <span class="text-secondary-500 font-semibold">+500</span>
                    </div>
                </div>
                <div class="w-full bg-primary-800/50 rounded-full h-2">
                    <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-2 rounded-full"
                        style="width: 0%"></div>
                </div>
            </div>

            {{-- Explorer Achievement --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <x-phosphor-compass class="text-secondary-500 w-6 h-6" weight="fill" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-semibold text-lg mb-1">Explorer</h4>
                        <p class="text-text-secondary text-sm">Place your first order in each category</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-secondary">0 / 1 To unlock</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="text-secondary-500 w-4 h-4" weight="fill" />
                        <span class="text-secondary-500 font-semibold">+500</span>
                    </div>
                </div>
                <div class="w-full bg-primary-800/50 rounded-full h-2">
                    <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-2 rounded-full"
                        style="width: 0%"></div>
                </div>
            </div>

            {{-- Speedrunner Achievement --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <x-phosphor-lightning class="text-secondary-500 w-6 h-6" weight="fill" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-semibold text-lg mb-1">Speedrunner</h4>
                        <p class="text-text-secondary text-sm">Place 3 orders in one month</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-secondary">0 / 1 To unlock</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="text-secondary-500 w-4 h-4" weight="fill" />
                        <span class="text-secondary-500 font-semibold">+500</span>
                    </div>
                </div>
                <div class="w-full bg-primary-800/50 rounded-full h-2">
                    <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-2 rounded-full"
                        style="width: 0%"></div>
                </div>
            </div>

            {{-- Master Trader Achievement --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <x-phosphor-chart-line-up class="text-secondary-500 w-6 h-6" weight="fill" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-semibold text-lg mb-1">Master Trader</h4>
                        <p class="text-text-secondary text-sm">Place 2 Escudo orders</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-secondary">0 / 1 To unlock</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="text-secondary-500 w-4 h-4" weight="fill" />
                        <span class="text-secondary-500 font-semibold">+500</span>
                    </div>
                </div>
                <div class="w-full bg-primary-800/50 rounded-full h-2">
                    <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 h-2 rounded-full"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        {{-- Dedication Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <x-phosphor-heart class="text-secondary-500 w-8 h-8" weight="fill" />
                <h2 class="text-white font-open-sans text-2xl font-bold">Dedication</h2>
            </div>
            <p class="text-text-secondary text-sm ml-11">Purchase at least 2 products per game to earn points</p>
        </div>

        {{-- CTA Card --}}
        <div
            class="glass-card rounded-2xl p-8 border border-secondary-700/30 bg-gradient-to-br from-secondary-900/40 to-secondary-950/40 text-center">
            <div class="flex justify-center mb-4">
                <x-phosphor-gift class="text-secondary-500 w-16 h-16" weight="fill" />
            </div>
            <h2 class="text-white font-open-sans text-3xl font-bold mb-4">
                Start Your Reward Journey Today
            </h2>
            <p class="text-text-secondary max-w-2xl mx-auto mb-6">
                Make your first purchase today and start tracking your journey toward exciting rewards. Each order helps
                you unlock new levels, bonuses, and exclusive offers. Stay motivated and see your progress grow with
                every step!
            </p>
            <button
                class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg inline-flex items-center gap-2">
                <span>Browse for more</span>
                <x-phosphor-arrow-right class="w-5 h-5" />
            </button>
        </div>
    </div>
</div>
