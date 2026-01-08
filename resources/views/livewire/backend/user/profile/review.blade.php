<div class="bg-bg-primary pb-10">
    <livewire:backend.user.profile.profile-component :user="$user" />
    <section class="container mx-auto bg-bg-secondary p-5! sm:p-10! rounded-2xl mb-10">
        <div class="">
            <h2 class="font-semibold text-3xl">{{ __('Reviews') }}</h2>
        </div>
        <div class="flex items-center gap-2 sm:gap-4 mt-5 mb-5">
            <div class="">
                <button wire:navigate wire:click="switchReviewItem('all')"
                    class="{{ $reviewItem === 'all' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl">{{ __('All') }}</button>
            </div>
            <div>
                <button wire:navigate wire:click="switchReviewItem('positive')"
                    class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                    {{ __('Positive') }}
                    {{-- <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-500 w-6 h-6 p-0! m-0!" /> --}}
                    <x-phosphor name="thumbs-up" variant="solid"
                        class="{{ $reviewItem === 'positive' ? 'fill-white' : 'fill-zinc-500' }} w-6 h-6 p-0! m-0!" />
                </button>
            </div>
            <div>
                <button wire:navigate wire:click="switchReviewItem('negative')"
                    class="{{ $reviewItem === 'negative' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-flex items-center gap-2 justify-center">

                    {{ __('Negative') }}

                    {{-- <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}" alt=""
                        class="inline-block"> --}}
                    <x-phosphor name="thumbs-down" variant="solid" class="fill-[#AF0F0F] w-6 h-6 p-0! m-0!" />
                </button>
            </div>
        </div>
        @if ($reviewItem === 'all')
            <div class="flex flex-col gap-5">
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($reviewItem === 'positive')
            <div class="flex flex-col gap-5">
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">

                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/thumb up filled.svg') }}"
                                    alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-text-white self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Yeg***') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($reviewItem === 'negative')
            <div class="flex flex-col gap-5">
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-zinc-700 self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-zinc-700 self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-bg-info rounded-2xl">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt="">
                                <p class="font-semibold text-2xl">{{ __('Items') }}</p>
                                <span class="border-l border-zinc-700 self-stretch"></span>
                                <p class="text-xs">{{ __('Yeg***') }}</p>
                            </div>
                            <div class="">
                                <span>{{ __('24.10.25') }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="font-normal text-base">
                                {{ __('Did not respond in over 24 hours to the messages, even though "average delivery time" is 3 hours, and being online on Fortnite. Was friended for over 48 hours and did not send the gift nor reply to the messages.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- <div class="pagination">
            <x-frontend.pagination-ui />
        </div> --}}

    </section>
</div>
