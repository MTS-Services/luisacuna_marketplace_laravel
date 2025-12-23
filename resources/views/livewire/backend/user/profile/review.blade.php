<div>
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
            <div class="">
                <button wire:navigate wire:click="switchReviewItem('positive')"
                    class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                    {!! $reviewItem === 'positive'
                        ? '<img src="' . asset('assets/images/user_profile/thumb up filled.svg') . '" alt="" class="inline-block">'
                        : '<img src="' . asset('assets/images/user_profile/thumb up filled.svg') . '" alt="" class="inline-block">' !!}
                    {{ __('Positive') }}
                </button>
            </div>
            <div class="">
                <button wire:navigate wire:click="switchReviewItem('negative')"
                    class="{{ $reviewItem === 'negative' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} border-1 border-zinc-500 font-semibold py-1 px-2 xxs:py-2 xxs:px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt=""
                        class="inline-block">
                    {{ __('Negative') }}
                </button>
            </div>
        </div>
        @if ($reviewItem === 'all')
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
