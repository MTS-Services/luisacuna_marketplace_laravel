<div>
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Feedback') }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <!-- Completed Orders Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor name="arrows-down-up" class="w-6 h-6 text-zinc-400 rotate-90" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Completed orders') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $completedOrder ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Positive Feedback Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-zinc-500" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Positive feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $positiveFeedback ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Negative Feedback Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-info w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-thumbs-up-fill class="w-6 h-6 fill-red-500 rotate-180" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Negative feedback') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $negativeFeedback ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Feedback Score Card -->
        <div class="bg-bg-secondary p-6 rounded-2xl  hover:border-zinc-700 transition-all duration-300">
            <div class="flex flex-col space-y-4">
                <div class="bg-bg-hover w-15 h-15 rounded-xl flex items-center justify-center">
                    <x-phosphor-star-fill class="w-6 h-6 fill-yellow-400" />
                </div>
                <div>
                    <p class="text-text-secondary text-sm mb-1">{{ __('Feedback score') }}</p>
                    <p class="text-text-white text-3xl font-bold">{{ $feedbackScore ?? '0' }}{{ __('%') }}</p>
                </div>
            </div>
        </div>
    </div>


   <div class="py-15">
        <div class="max-w-8xl mx-auto bg-bg-secondary p-5 sm:p-15 rounded-lg">
            <!-- Filter Buttons -->
            <div class="flex items-center gap-2 sm:gap-4 mt-5 mb-5">
                <div class="">
                    <button x-on:click="$wire.set('type', 'all')"
                        class="{{ $reviewItem === 'all' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl">{{ __('All') }}</button>
                </div>
                <div>
                    <button x-on:click="$wire.set('type', 'positive')"
                        class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                        {{ __('Positive') }}
                        {{-- <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-500 w-6 h-6 p-0! m-0!" /> --}}
                        <x-phosphor name="thumbs-up" variant="solid"
                            class="{{ $reviewItem === 'positive' ? 'fill-white' : 'fill-zinc-500' }} w-6 h-6 p-0! m-0!" />
                    </button>
                </div>
                <div>
                    <button x-on:click="$wire.set('type', 'negative')"
                        class="{{ $reviewItem === 'negative' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                        {{ __('Negative') }}

                        {{-- <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}" alt=""
                        class="inline-block"> --}}
                         <x-phosphor name="thumbs-down" variant="solid" class="fill-[#AF0F0F] w-6 h-6 p-0! m-0!" />
                    </button>
                </div>
            </div>

            <div class="flex flex-col gap-5">
                @forelse ($feedbacks as $feedback)
                    <div class="p-6 bg-bg-info rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <x-phosphor name="{{ $feedback->type->icon() }}" variant="solid"
                                        class="w-5 h-5 {{ $feedback->type->iconColor() }}" />
                                    <p class="font-semibold text-2xl">{{ $feedback->order->source->translatedName(app()->getLocale()) }}</p>
                                    {{-- <span class="border-l border-text-white self-stretch"></span>
                                    <p class="text-xs">{{ __('Yeg***') }}</p> --}}
                                </div>
                                <div class="">
                                    <span>{{ $feedback->created_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="font-normal text-base">
                                   {{ $feedback->translatedMessage(app()->getLocale()) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-10 bg-bg-info rounded-2xl flex flex-col items-center justify-center text-center">
                        <x-phosphor-chat-centered-dots class="w-12 h-12 mb-3 opacity-50" />
                        <p class="text-lg font-medium opacity-70">
                            {{ __('No feedback found yet') }}
                        </p>
                        <p class="text-sm opacity-50">
                            {{ __('When you receive feedback, it will appear here.') }}
                        </p>
                    </div>
                @endforelse
            </div>
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </div>
</div>
