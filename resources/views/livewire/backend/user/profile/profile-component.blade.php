<section class=" mx-auto relative">
    <section class="">
        <div class="inner_banner h-16 sm:h-32">
            <img src="{{ asset('assets/images/user_profile/inner_banner.png') }}" alt="" class="w-full h-full">
        </div>
    </section>
    {{-- profile header --}}
    <section
        class="container mx-auto bg-bg-primary p-10 rounded-2xl absolute left-1/2 -translate-x-1/2 top-10 sm:top-5 md:top-15">
        <div class="flex justify-between">
            <div class="flex items-center gap-6">
                <div class="">
                    <div class="relative">
                        <div class="w-20 h-20 sm:w-40 sm:h-40">
                            <img src="{{ auth_storage_url(user()->avatar) }}" alt="" class="h-full w-full">
                        </div>
                        <div class="absolute -right-5 top-7 sm:-right-3 sm:top-20 w-10 h-10 sm:w-15 sm:h-15">
                            <img src="{{ asset('assets/images/user_profile/Frame 1261153813.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>

                </div>
                <div class="">
                    <h3 class="text-4xl font-semibold text-text-white mb-2">{{ user()->name }}</h3>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#12D212"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-base-400 text-text-white">{{ __('Online') }}</span>
                    </div>

                </div>
            </div>
            <div class="icon">
                <a href="{{ route('user.account-settings') }}" wire:navigate>
                    <x-flux::icon name="pencil-square" class="w-6 h-6 inline-block stroke-text-text-white"
                        stroke="currentColor" />
                </a>
            </div>
        </div>
        <div class="border-b border-zinc-700 mt-6 mb-4"></div>
        <div class="flex gap-6">
            <button wire:navigate wire:click="switchInnerMenu('shop')"
                class="{{ $activeInnerMenu === 'shop' ? 'border-b-3 border-zinc-500' : '' }} group">
                <span class="relative z-10 text-text-white ">{{ __('Shop') }}</span>
            </button>
            <button wire:navigate wire:click="switchInnerMenu('reviews')"
                class="{{ $activeInnerMenu === 'reviews' ? 'border-b-3 border-zinc-500' : '' }} group">
                <span class="relative z-10 text-text-white">{{ __('Reviews') }}</span>
            </button>
            <button wire:navigate wire:click="switchInnerMenu('about')"
                class="{{ $activeInnerMenu === 'about' ? 'border-b-3 border-zinc-500' : '' }} group">
                <span class="relative z-10 text-text-white ">{{ __('About') }}</span>
            </button>
        </div>
    </section>
    {{-- about --}}
    <div class="min-h-70"></div>
    {{-- shop --}}
    @if ($activeInnerMenu === 'shop')
        
    @endif
    @if ($activeInnerMenu === 'reviews')
        <section class="container mx-auto bg-bg-primary p-10! rounded-2xl mb-10">
            <div class="">
                <h2 class="font-semibold text-3xl">{{ __('Reviews') }}</h2>
            </div>
            <div class="flex items-center gap-4 mt-5 mb-5">
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('all')"
                        class="{{ $reviewItem === 'all' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-2 px-4 sm:py-3 sm:px-6 rounded-2xl">{{ __('All') }}</button>
                </div>
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('positive')"
                        class="{{ $reviewItem === 'positive' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} font-semibold border-1 border-zinc-500 py-2 px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                        {!! $reviewItem === 'positive'
                            ? '<img src="' . asset('assets/images/user_profile/New Project.png') . '" alt="" class="inline-block">'
                            : '<img src="' . asset('assets/images/user_profile/thumb up filled.svg') . '" alt="" class="inline-block">' !!}


                    </button>
                </div>
                <div class="">
                    <button wire:navigate wire:click="switchReviewItem('negative')"
                        class="{{ $reviewItem === '' ? 'bg-zinc-500 text-text-white' : 'bg-zinc-50 text-zinc-500' }} border-1 border-zinc-500 font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-2xl inline-block">
                        <img src="{{ asset('assets/images/user_profile/Subtract.png') }}" alt=""
                            class="inline-block">
                        {{ __('Negative') }}
                    </button>
                </div>
            </div>
            @if ($reviewItem === 'all')
                <div class="flex flex-col gap-5">
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($reviewItem === 'positive')
                <div class="flex flex-col gap-5">
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
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
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
                                        alt="">
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
                                        alt="">
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-white/10 rounded-2xl">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/user_profile/Subtract.png') }}"
                                        alt="">
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
                                    {{ __('Did not respond in over 24 hours to the messages, even though "average delivery
                                                                                                                                                                                    time" is
                                                                                                                                                                                    3
                                                                                                                                                                                    hours, and being online on Fortnite. Was friended for over 48 hours and did not send
                                                                                                                                                                                    the
                                                                                                                                                                                    gift nor reply to the messages.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="pagination">
                <x-frontend.pagination-ui />
            </div>

        </section>
    @endif
    @if ($activeInnerMenu === 'about')
        <section class="container mx-auto bg-bg-primary rounded-2xl mb-10 p-5 sm:p-10 md:p-20">
            <div class="mb-5">
                <h2 class="font-semibold text-3xl">{{ __('About') }}</h2>
            </div>
            <div class="flex flex-col gap-5">
                <div class="p-6 bg-white/10 rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div class="">
                            <h3 class="text-2xl font-semibold text-text-white">{{ __('Description') }}</h3>
                        </div>
                        <div class="">
                            <x-flux::icon name="pencil-square" class="w-5 h-5 inline-block" stroke="white" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="">
                            <p class="text-base text-text-white">
                                {{ __('Hey there!') }}
                            </p>
                        </div>
                        <div class="">
                            <p class="text-base text-text-white">
                                {{ __('At PixelStoreLAT, we bring you the best digital deals, game keys, and in-game items —
                                                                                                                                                                fast, safe, and hassle-free. Trusted by thousands of gamers worldwide with 97% positive
                                                                                                                                                                reviews. Level up your experience with us today!') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white/10 rounded-2xl">
                    <div class="">
                        <p class="text-base text-text-white">
                            {{ __('Registered: Feb 20, 2023') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif
</section>
