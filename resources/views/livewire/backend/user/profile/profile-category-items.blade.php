<main class="mx-auto">
    @if ($activeTab == 'giftcards' || $activeTab == 'topups')
        {{-- main --}}
        <section class="container">
            <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">
                <x-ui.select wire:model="country_id" id="country_id">
                    <option value="">{{ __('All Game') }}</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}">
                            {{ $game->name }}
                        </option>
                    @endforeach
                </x-ui.select>
            </div>

            <div class="md:flex gap-6 h-auto mt-10">

                <div class="w-full  grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$40.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$50.20</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$60.20</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$80.20</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$90.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$95.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$100.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$110.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$120.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$130.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$140.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$150.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$160.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$170.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$180.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$190.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$200.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$210.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$220.16</span>
                    </div>
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$230.16</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center space-x-3  p-4 m-10">
                <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Previous') }}</button>

                <button class="bg-zinc-600 text-white text-sm px-3 py-1 rounded">1</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">2</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">3</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">4</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">5</button>

                <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Next') }}</button>
            </div>
        </section>
    @else
        {{-- select game --}}
        <div class="w-full sm:w-sm md:w-md lg:w-md mt-6 border-2 border-zinc-800 rounded-lg">

            <x-ui.select wire:model="country_id" id="country_id">
                <option value="">{{ __('All Game') }}</option>
                @foreach ($games as $game)
                    <option value="{{ $game->id }}">
                        {{ $game->name }}
                    </option>
                @endforeach
            </x-ui.select>
        </div>

        {{-- games --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="95 text-base-600 font-semibold">{{ __('PlayStation') }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-10 h-10 text-text-secondary">
                                <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                            </svg>
                            <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-5">
                    <span class="text-base-400">
                        {{ __('Galaxy Skin – PSN / Xbox / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/product-image-container -_ image.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __(' PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-lg p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/user_profile/frame.png') }}" alt="">
                        <span class="text-[#4ADE80] text-base-400">{{ __('Xbox') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 text-text-secondary">
                            <path d="M12 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" />
                        </svg>
                        <span class="text-text-secondary text-base-600">{{ __('Stacked') }}</span>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span class="text-base-400">
                        {{ __('Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access') }}
                    </span>
                    <img src="{{ asset('assets/images/user_profile/e84f9097828ae420d3f6578c742ab821a27d643b.png') }}"
                        alt="">
                </div>
                <div class="flex items-center justify-between mt-10">
                    <div class="">
                        <span class="text-base-600 font-semibold ">
                            {{ __('PEN175.27') }}
                        </span>
                    </div>
                    <div class="flex
                                        items-center gap-2">
                        <flux:icon name="clock" class="w-6 h-6 50" />
                        <span class="text-xs-400 50">
                            {{ __('Instant') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center space-x-3  p-4 m-10">
            <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Previous') }}</button>

            <button class="bg-zinc-600 text-white text-sm px-3 py-1 rounded">1</button>
            <button class="text-text-primary text-sm hover:text-zinc-500">2</button>
            <button class="text-text-primary text-sm hover:text-zinc-500">3</button>
            <button class="text-text-primary text-sm hover:text-zinc-500">4</button>
            <button class="text-text-primary text-sm hover:text-zinc-500">5</button>

            <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Next') }}</button>
        </div>
    @endif
</main>
