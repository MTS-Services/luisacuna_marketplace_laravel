<main class="mx-auto">
    @if ($categorySlug == 'gift-cards' || $categorySlug == 'top-ups')
        <section class="container mt-2">
            <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
            <div class="flex items-center gap-2 mt-8 text-lg font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-blue-100 text-text-primary">
                    {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                </h1>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">{{ __('Shop') }}</span>
            </div>
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <div class="">
                        <span class="text-base font-semibold">{{ __('Select region') }}</span>
                    </div>
                    {{-- <div class="hidden md:flex items-center gap-2">

                    </div> --}}
                    <div class="block md:hidden relative z-10" x-data="{ open: false }">

                        <div @click="open = !open" class="cursor-pointer inline-block">
                            <x-phosphor name="sort-ascending" variant="bold" class="fill-white w-6 h-6" />
                        </div>

                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 p-2 bg-bg-primary rounded-2xl shadow-lg origin-top-right"
                            style="display: none;">
                            <a href="#"
                                class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                                {{ __('Lowest To Highest') }}
                            </a>
                            <a href="#"
                                class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                                {{ __('highest to lowest') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-3 mb-6 flex items-center justify-between">
                <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                    <option value="">{{ __('Global') }}</option>
                    <option value="completed">{{ __('Completed') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="processing">{{ __('Processing') }}</option>
                </x-ui.select>

                <x-ui.select id="status-select" class="py-0.5! w-auto! pl-5! hidden md:flex rounded-full!">
                    <option value="">{{ __('Sort by') }}</option>
                    <option value="">{{ __('lowest to highest') }}</option>
                    <option value="">{{ __('highest to lowest') }}</option>
                </x-ui.select>

            </div>

            <div class="mb-10">
                <span class="text-base font-semibold text-text-white">
                    {{ __('About 21 results') }}
                </span>
            </div>
        </section>

        {{-- main --}}
        <section class="container">
            <div class="md:flex gap-6 h-auto">
                <div class="w-full md:w-[65%] grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">
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
                <div class="w-full md:w-[35%] mt-4 md:mt-0">
                    <div class="">
                        <div class="bg-bg-primary rounded-2xl py-7 px-6">
                            <div class="flex items-center gap-1 mb-8">
                                <div class="w-8 h-8">
                                    <img src="{{ asset('assets/images/gift_cards/V-Bucks1.png') }}" alt=""
                                        class="w-full h-full object-cover">
                                </div>
                                <p>{{ __('IOOOV-Bucks') }}</p>
                            </div>
                            <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                            <div class="flex items-center justify-between py-3">
                                <p class="text-base text-text-white">{{ __('IOOOV-Bucks') }}</p>
                                <p class="text-base text-text-white font-semibold">{{ __('15 min') }}</p>
                            </div>
                            <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                            <div class="mt-4">
                                <a href="{{ route('game.checkout', ['orderId' => 12345]) }}">
                                    <x-ui.button class="">{{ __('$76.28 | Buy now') }} </x-ui.button>
                                </a>
                            </div>
                            <div class="flex items-center gap-2 mt-8">
                                <flux:icon name="shield-check" class="w-6 h-6 50" />
                                <p class="text-text-white text-base font-semibold">{{ __('Money-back Guarantee') }}
                                </p>
                                <span class="text-xs text-zinc-200/60">{{ __('Protected by TradeShield') }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-4">
                                <flux:icon name="bolt" class="w-6 h-6 50" />
                                <p class="text-text-white text-base font-semibold">{{ __('Fast Checkout Options') }}
                                </p>
                                <div class="flex items-center gap-2 w-11 h-7">
                                    <img src="{{ asset('assets/images/gift_cards/google.png') }}" alt=""
                                        class="w-full h-full">
                                    <img src="{{ asset('assets/images/gift_cards/apple.png') }}" alt=""
                                        class="w-full h-full">
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6">
                                    <rect fill="none" />
                                    <path d="M224,200v8a32,32,0,0,1-32,32H136" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path
                                        d="M224,128H192a16,16,0,0,0-16,16v40a16,16,0,0,0,16,16h32V128a96,96,0,1,0-192,0v56a16,16,0,0,0,16,16H64a16,16,0,0,0,16-16V144a16,16,0,0,0-16-16H32"
                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                </svg>
                                <p class="text-text-white text-base font-semibold">{{ __('24/7 Live Support') }}</p>
                                <span class="text-xs text-zinc-200/60">{{ __('We\'re always here to help') }}</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="bg-bg-primary rounded-2xl py-7 px-6">
                                <h3 class="text-text-white text-base font-semibold mb-2">
                                    {{ __('Delivery instructions') }}</h3>
                                <div class="flex gap-2">
                                    <span class="text-sm text-text-white">{{ __('Welcome') }}</span>
                                    <span class="inline-block w-px h-3 bg-zinc-500"></span>
                                    <span class="text-sm text-text-white">{{ __('Why choose us') }}</span>
                                </div>
                                <div class="mt-4">
                                    <p class="text-sm text-text-white">
                                        {{ __('1. V-BUCKS are safe to hold and guaranteed!') }}</p>
                                    <p class="text-sm text-text-white mt-2  mb-4">
                                        {{ __('2. Fast replies and delivery.') }}</p>

                                    <a href="#"
                                        class="text-base font-semibold text-pink-500">{{ __('See all') }}</a>
                                </div>
                                <span class="border-t-2 border-zinc-500 w-full inline-block mt-8"></span>
                                <div class="">
                                    <div class="flex gap-4 items-center mt-4">
                                        <div class="w-14 h-14">
                                            <img src="{{ asset('assets/images/gift_cards/profile.png') }}"
                                                alt="" class="w-full h-full">
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <h2 class="text-text-white font-semibold text-base">
                                                    {{ __('Devon Lane') }}</h2>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-600" />
                                                <span class="text-xs text-text-white">99.3%</span>
                                                <span class="w-px h-4 bg-zinc-200"></span>
                                                <span class="text-xs text-text-white">{{ __('2434 reviews') }}</span>
                                                <span class="w-px h-4 bg-zinc-200"></span>
                                                <span class="text-xs text-text-white">{{ __('1642 Sold') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- seller list secton --}}
        <section class="container mt-32">
            <div class="mb-10">
                <h2 class="text-text-white font-semibold trxt-40px">{{ __('Other sellers (84)') }}</h2>
            </div>
            <div class="mt-10 mb-6 flex items-center justify-between">
                <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                    <option value="">{{ __('Recommended') }}</option>
                    <option value="completed">{{ __('Completed') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="processing">{{ __('Processing') }}</option>
                </x-ui.select>
                <button
                    class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">
                    {{ __('● Online Seller') }} </button>
            </div>
            <div class="min-w-full text-left border-collapse">
                <div class="flex justify-between text-text-white text-sm">
                    <div class="px-4 py-3">{{ __('All Sellers (8)') }}</div>
                    <div class="px-4 py-3 hidden md:block">{{ __('Delivery Time') }}</div>
                    <div class="px-4 py-3 hidden md:block">{{ __('Delivery Method') }}</div>
                    <div class="px-4 py-3 hidden md:block">{{ __('Stock') }}</div>
                    <div class="px-4 py-3 hidden md:block">{{ __('Price') }}</div>
                </div>

                <div class="py-7 space-y-7">
                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10">
                                    <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                        class="w-full h-full rounded-full">
                                </div>
                                <div>
                                    <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                    <div class="flex items-center gap-1">
                                        <x-phosphor name="thumbs-up" variant="solid"
                                            class="fill-zinc-600 inline-block" />
                                        <span class="text-xs text-text-white">99.3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>

                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10">
                                    <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                        class="w-full h-full rounded-full">
                                </div>
                                <div>
                                    <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                    <div class="flex items-center gap-1">
                                        <x-phosphor name="thumbs-up" variant="solid"
                                            class="fill-zinc-600 inline-block" />
                                        <span class="text-xs text-text-white">99.3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>

                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10">
                                    <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                        class="w-full h-full rounded-full">
                                </div>
                                <div>
                                    <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                    <div class="flex items-center gap-1">
                                        <x-phosphor name="thumbs-up" variant="solid"
                                            class="fill-zinc-600 inline-block" />
                                        <span class="text-xs text-text-white">99.3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>

                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10">
                                    <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                        class="w-full h-full rounded-full">
                                </div>
                                <div>
                                    <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                    <div class="flex items-center gap-1">
                                        <x-phosphor name="thumbs-up" variant="solid"
                                            class="fill-zinc-600 inline-block" />
                                        <span class="text-xs text-text-white">99.3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>

                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10">
                                    <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                        class="w-full h-full rounded-full">
                                </div>
                                <div>
                                    <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                    <div class="flex items-center gap-1">
                                        <x-phosphor name="thumbs-up" variant="solid"
                                            class="fill-zinc-600 inline-block" />
                                        <span class="text-xs text-text-white">99.3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section>
            <div class="container ">
                <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                <div class="max-w-7xl mx-auto lg:px-8 lg:py-8">
                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-2 mb-8 text-md font-semibold">
                        <div class="w-4 h-4">
                            <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo"
                                class="w-full h-full object-cover">
                        </div>
                        <h1 class="text-blue-100 text-text-primary">
                            {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                        </h1>
                        <span class=" text-text-primary">></span>
                        <span class=" text-text-primary">{{ __('Shop') }}</span>
                    </div>

                    {{-- <!-- Filters Section -->
                    <div class="mb-8 space-y-4">
                        <div class="flex gap-4 justify-between md:justify-start md:flex-wrap relative"
                            x-data={filter:false}>
                            <div class="flex-1 w-auto md:min-w-64">
                                <div class="relative">
                                    <input type="text" placeholder="Search"
                                        class="w-full bg-bg-primary border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                                    <span class="absolute left-3 top-2.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Device') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Account type') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Price') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Select Delivery Time') }}</option>
                            </x-ui.select>
                            <button
                                class="text-text-primary hover:text-white transition hidden md:flex">{{ __('Clear all') }}</button>
                            <button @click="filter = !filter"
                                class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition md:hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                                </svg>
                                <span>{{ __('Filter') }}</span>
                            </button>

                            <div x-show="filter"
                                class="glass-card bg-bg-primary/50 text-text-white p-6 rounded-lg w-full absolute top-16 right-0 z-10 md:hidden">
                                <!-- Header -->
                                <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
                                    <h2 class="text-lg font-semibold">Seller list</h2>
                                </div>

                                <!-- Toggle Buttons -->
                                <div class="flex justify-between mb-6 space-x-3">
                                    <button
                                        class="px-5 py-2 rounded-full bg-bg-secondary text-text-white font-semibold">Instant
                                        delivery</button>
                                    <button
                                        class="px-5 py-2 rounded-full bg-bg-secondary/70 text-text-white font-semibold flex items-center gap-2">
                                        <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                                        <span>Online Seller</span>
                                    </button>
                                </div>

                                <!-- Dropdown Filters -->
                                <div class="space-y-4 h-[calc(100vh-360px)] overflow-y-auto">
                                    <div>
                                        <label class="text-sm text-gray-400">Short by</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">Fastest Delivery</option>
                                            <option class="bg-gray-800">Top Selling</option>
                                            <option class="bg-gray-800">Cheapest Price</option>
                                            <option class="bg-gray-800">Recent Sales</option>
                                            <option class="bg-gray-800">Highest Price</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Platform</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">ANDROID</option>
                                            <option class="bg-gray-800">PS</option>
                                            <option class="bg-gray-800">XBOX</option>
                                            <option class="bg-gray-800">IOS</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Contain Rare Skin</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">OG</option>
                                            <option class="bg-gray-800">Renegade Raider</option>
                                            <option class="bg-gray-800">Travis Scott</option>
                                            <option class="bg-gray-800">Black Knight</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Pickaxes</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">0-10</option>
                                            <option class="bg-gray-800">11-30</option>
                                            <option class="bg-gray-800">31-50</option>
                                            <option class="bg-gray-800">51-100</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">V-Bucks</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">None</option>
                                            <option class="bg-gray-800">1-1000</option>
                                            <option class="bg-gray-800">1001-5000</option>
                                            <option class="bg-gray-800">5001-10000</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Outfits</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">None</option>
                                            <option class="bg-gray-800">Random</option>
                                            <option class="bg-gray-800">1-10</option>
                                            <option class="bg-gray-800">11-20</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Price (USD)</label>
                                        <select
                                            class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                            <option class="bg-gray-800">≤ $5.00</option>
                                            <option class="bg-gray-800">$5.00 - $15.00</option>
                                            <option class="bg-gray-800">$15.00 - $50.00</option>
                                            <option class="bg-gray-800">$50.00 - $100.00</option>
                                            <option class="bg-gray-800">$100.00+</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-between gap-4 mt-8">
                                    <x-ui.button class="py-2" variant='secondary'>
                                        {{ __('Reset') }}
                                    </x-ui.button>
                                    {{-- <button
                                    class="w-[45%] py-2 bg-transparent border border-purple-400 text-purple-400 rounded-full font-medium">Reset</button>
                                <button
                                    class="w-[45%] py-2 bg-purple-600 hover:bg-purple-700 rounded-full font-medium">Confirm</button> --}}
                                    <x-ui.button class="py-2">
                                        {{ __('Confirm') }}
                                    </x-ui.button>
                                </div>
                                <div>

                                </div>
                                <div>

                                </div>
                            </div>
                        </div>

                        {{-- <div x-data="{
                            showAll: false,
                            limit: 8,
                            tags: [
                                'Robux',
                                'Steal A Brainrot',
                                'Grow A Garden',
                                'Hunty Zombie',
                                '99 Nights In The Forest',
                                'Prospecting',
                                'All Star Tower Defense X',
                                'Ink Game',
                                'Garden Tower Defense',
                                'Bubble Gum Simulator',
                                'Dead Rails',
                                'TYPE./ ISOUL',
                                'Hypershot',
                                'Build A Zoo',
                                'Gems',
                                'Rivals',
                                'MM2',
                                'Blox Fruit',
                                'Pet Simulator 99',
                                'Spin',
                                'Adopt Me'
                            ]
                        }" class="w-full">
                            <!-- Tag List -->
                            <div class="flex flex-wrap gap-2 sm:gap-3 transition-all duration-300">
                                <template x-for="(tag, index) in (showAll ? tags : tags.slice(0, limit))"
                                    :key="index">
                                    <span
                                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-600 transition cursor-pointer"
                                        x-text="tag" @click="$dispatch('tag-selected', tag)"></span>
                                </template>

                                <button @click="showAll = !showAll"
                                    class="flex items-center gap-1 text-sm text-gray-300 hover:text-white transition sm:hidden">
                                    <svg :class="{ 'rotate-180': showAll }"
                                        class="w-6 h-6 transition-transform duration-300" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div> --}}


                        <div x-data="{
                            showAll: false,
                            limit: 5,
                            tags: [
                                'Robux',
                                'Steal A Brainrot',
                                'Grow A Garden',
                                'Hunty Zombie',
                                '99 Nights In The Forest',
                                'Prospecting',
                                'All Star Tower Defense X',
                                'Ink Game',
                                'Garden Tower Defense',
                                'Bubble Gum Simulator',
                                'Dead Rails',
                                'TYPE./ ISOUL',
                                'Hypershot',
                                'Build A Zoo',
                                'Gems',
                                'Rivals',
                                'MM2',
                                'Blox Fruit',
                                'Pet Simulator 99',
                                'Spin',
                                'Adopt Me'
                            ]
                        }" class="w-full">
                            <div class="flex flex-wrap gap-2 sm:gap-3 transition-all duration-300">
                                <!-- Mobile View -->
                                <template x-if="window.innerWidth < 640">
                                    <template x-for="(tag, index) in (showAll ? tags : tags.slice(0, limit))"
                                        :key="index">
                                        <span
                                            class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-600 transition cursor-pointer"
                                            x-text="tag" @click="$dispatch('tag-selected', tag)"></span>
                                    </template>
                                </template>

                                <!-- Desktop View -->
                                <template x-if="window.innerWidth >= 640">
                                    <template x-for="(tag, index) in tags" :key="index">
                                        <span
                                            class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-600 transition cursor-pointer"
                                            x-text="tag" @click="$dispatch('tag-selected', tag)"></span>
                                    </template>
                                </template>

                                <!-- Toggle Button (Mobile Only) -->
                                <button @click="showAll = !showAll"
                                    class="flex items-center gap-1 text-sm text-gray-300 hover:text-white transition sm:hidden">
                                    <svg :class="{ 'rotate-180': showAll }"
                                        class="w-6 h-6 transition-transform duration-300" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>






                        <!-- Right Filters -->
                        <div class="gap-3 justify-end hidden md:flex">
                            <button
                                class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">{{ __('● Online Seller') }}</button>

                            <button class="px-5 py-2 rounded-full bg-bg-primary text-text-white font-semibold">Instant
                                delivery</button>
                        </div>
                    </div> --}}

                    {{-- Mobile Device Filter --}}
                    <div class="flex items-center justify-between gap-4 mb-8 relative" x-data="{ filter: false }">
                        <div class="flex-1 min-w-64">
                            <div class="relative">
                                <input type="text" placeholder="Search"
                                    class="w-full bg-bg-primary border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                                <span class="absolute left-3 top-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!" x-on:click="filter = !filter">
                            <option value="">{{ __('Device') }}</option>
                        </x-ui.select>
                        <div x-show="filter" class="glass-card text-white p-6 rounded-lg w-full absolute top-16 right-0 z-10">
                            <!-- Header -->
                            <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
                                <h2 class="text-lg font-semibold">Seller list</h2>
                                <div class="text-gray-500 text-xl">—</div>
                            </div>

                            <!-- Toggle Buttons -->
                            <div class="flex justify-center mb-6 space-x-3">
                                <button class="px-5 py-2 rounded-full bg-purple-600 text-white font-semibold">Instant
                                    delivery</button>
                                <button
                                    class="px-5 py-2 rounded-full bg-transparent border border-green-500 text-green-400 font-semibold">Online
                                    Seller</button>
                            </div>

                            <!-- Dropdown Filters -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-gray-400">Short by</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">Fastest Delivery</option>
                                        <option class="bg-gray-800">Top Selling</option>
                                        <option class="bg-gray-800">Cheapest Price</option>
                                        <option class="bg-gray-800">Recent Sales</option>
                                        <option class="bg-gray-800">Highest Price</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">Platform</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">ANDROID</option>
                                        <option class="bg-gray-800">PS</option>
                                        <option class="bg-gray-800">XBOX</option>
                                        <option class="bg-gray-800">IOS</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">Contain Rare Skin</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">OG</option>
                                        <option class="bg-gray-800">Renegade Raider</option>
                                        <option class="bg-gray-800">Travis Scott</option>
                                        <option class="bg-gray-800">Black Knight</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">Pickaxes</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">0-10</option>
                                        <option class="bg-gray-800">11-30</option>
                                        <option class="bg-gray-800">31-50</option>
                                        <option class="bg-gray-800">51-100</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">V-Bucks</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">None</option>
                                        <option class="bg-gray-800">1-1000</option>
                                        <option class="bg-gray-800">1001-5000</option>
                                        <option class="bg-gray-800">5001-10000</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">Outfits</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">None</option>
                                        <option class="bg-gray-800">Random</option>
                                        <option class="bg-gray-800">1-10</option>
                                        <option class="bg-gray-800">11-20</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm text-gray-400">Price (USD)</label>
                                    <select
                                        class="w-full bg-transparent border-b border-purple-500 py-2 focus:outline-none">
                                        <option class="bg-gray-800">≤ $5.00</option>
                                        <option class="bg-gray-800">$5.00 - $15.00</option>
                                        <option class="bg-gray-800">$15.00 - $50.00</option>
                                        <option class="bg-gray-800">$50.00 - $100.00</option>
                                        <option class="bg-gray-800">$100.00+</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-between mt-8">
                                <button
                                    class="w-[45%] py-2 bg-transparent border border-purple-400 text-purple-400 rounded-full font-medium">Reset</button>
                                <button
                                    class="w-[45%] py-2 bg-purple-600 hover:bg-purple-700 rounded-full font-medium">Confirm</button>
                            </div>
                        </div>
                    </div>




                    <div class=" flex items-center justify-center ">
                        <!-- Product Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                        </div>
                    </div>


                    <div class="flex justify-end items-center space-x-3  p-4 m-10">
                        <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Previous') }}</button>

                        <button class="bg-purple-600 text-text-white text-sm px-3 py-1 rounded">1</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">2</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">3</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">4</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">5</button>

                        <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Next') }}</button>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
