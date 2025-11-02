<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <div class="bg-bg-primary/70 p-6 rounded-2xl hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor name="arrows-down-up" class="w-6 h-6 text-zinc-400 rotate-90" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Completed orders') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $completedOrders ?? 1300 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-bg-primary/70 p-6 rounded-2xl hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-zinc-500" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Positive feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $positiveFeedback ?? 1290 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-bg-primary/70 p-6 rounded-2xl hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-red-500 rotate-180" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Negative feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $negativeFeedback ?? 10 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-bg-primary/70 p-6 rounded-2xl hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-star-fill class="w-6 h-6 fill-yellow-400" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Feedback score') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $feedbackScore ?? '99.23%' }}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="py-15">
        <div class="max-w-8xl mx-auto bg-bg-primary/70 p-6 sm:p-8 lg:p-10 xl:p-15 rounded-lg">
            <div class="flex justify-start gap-3 mb-6">
                <button
                    class="px-3 sm:px-6 py-2 sm:py-2.5 rounded-full bg-accent text-text-white font-medium hover:bg-accent/90 transition-all duration-300 shadow-lg text-sm sm:text-base">
                    {{ __('All') }}
                </button>

                <button
                    class="px-3 sm:px-6 py-2 sm:py-2.5 rounded-full bg-white text-accent font-medium hover:bg-gray-50 transition-all duration-300 shadow-md flex items-center gap-2 text-sm sm:text-base">
                    {{ __('Positive') }}
                    <x-phosphor-thumbs-up-fill class="w-4 h-4 sm:w-5 sm:h-5 fill-accent" />
                </button>

                <button
                    class="px-3 sm:px-6 py-2 sm:py-2.5 rounded-full bg-white text-accent font-medium hover:bg-gray-50 transition-all duration-300 shadow-md flex items-center gap-2 text-sm sm:text-base">
                    {{ __('Negative') }}
                    <x-phosphor-thumbs-up-fill class="w-4 h-4 sm:w-5 sm:h-5 fill-red-500 rotate-180" />
                </button>
            </div>


            <div class="space-y-4">
                <div
                    class="bg-zinc-50/10 backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <x-phosphor-thumbs-up-fill class="w-5 h-5 mt-1 shrink-0" />
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-text-white font-semibold">{{ __('Items') }}</span>
                                    <span class="text-zinc-500">|</span>
                                    <span class="text-zinc-400 text-sm">Yes***</span>
                                </div>
                                <p class="text-zinc-400 text-sm">Yes***</p>
                            </div>
                        </div>
                        <span class="text-zinc-500 text-sm">24.10.25</span>
                    </div>
                </div>

                <div
                    class="bg-zinc-50/10 backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <x-phosphor-thumbs-up-fill class="w-5 h-5 text-accent mt-1 shrink-0" />
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-text-white font-semibold">{{ __('Items') }}</span>
                                    <span class="text-zinc-500">|</span>
                                    <span class="text-zinc-400 text-sm">Yes***</span>
                                </div>
                                <p class="text-zinc-400 text-sm">Yes***</p>
                            </div>
                        </div>
                        <span class="text-zinc-500 text-sm">24.10.25</span>
                    </div>
                </div>

                <div
                    class="bg-zinc-50/10 backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <x-phosphor-thumbs-up-fill class="w-5 h-5 text-accent mt-1 shrink-0" />
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-text-white font-semibold">{{ __('Items') }}</span>
                                    <span class="text-zinc-500">|</span>
                                    <span class="text-zinc-400 text-sm">Yes***</span>
                                </div>
                                <p class="text-zinc-400 text-sm">Yes***</p>
                            </div>
                        </div>
                        <span class="text-zinc-500 text-sm">24.10.25</span>
                    </div>
                </div>

                <div
                    class="bg-zinc-50/10 backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <x-phosphor-thumbs-up-fill class="w-5 h-5 text-accent mt-1 shrink-0" />
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-text-white font-semibold">{{ __('Items') }}</span>
                                    <span class="text-zinc-500">|</span>
                                    <span class="text-zinc-400 text-sm">Yes***</span>
                                </div>
                                <p class="text-zinc-400 text-sm">Yes***</p>
                            </div>
                        </div>
                        <span class="text-zinc-500 text-sm">24.10.25</span>
                    </div>
                </div>

                <div
                    class="bg-zinc-50/10 backdrop-blur-sm rounded-2xl p-6 border border-zinc-800/10 hover:border-zinc-700 transition-all duration-300">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-start gap-3">
                            <x-phosphor-thumbs-down-fill class="w-5 h-5 text-red-500 mt-1 shrink-0" />
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-text-white font-semibold">{{ __('Items') }}</span>
                                    <span class="text-zinc-500">|</span>
                                    <span class="text-zinc-400 text-sm">Yes***</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-zinc-500 text-sm">24.10.25</span>
                    </div>
                    <p class="text-zinc-400 text-sm leading-relaxed ml-8">
                        {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>