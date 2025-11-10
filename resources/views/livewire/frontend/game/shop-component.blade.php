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
                                <a href="" class="bg-zinc-500 text-white py-1 px-2 rounded-2xl">
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
                                <a href="" class="bg-zinc-500 text-white py-1 px-2 rounded-2xl">
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
                                <a href="" class="bg-zinc-500 text-white py-1 px-2 rounded-2xl">
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
                                <a href="" class="bg-zinc-500 text-white py-1 px-2 rounded-2xl">
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

                    <!-- Filters Section -->
                    <div class="mb-8 space-y-4">
                        <div class="flex gap-4 flex-wrap">
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
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Device') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Account type') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Price') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Select Delivery Time') }}</option>
                            </x-ui.select>
                            <button
                                class="text-text-primary hover:text-white transition">{{ __('Clear all') }}</button>
                        </div>

                        <!-- Game Tags -->
                        <div class="flex gap-2 flex-wrap">
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Robux') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Steel
                                                                                                                                                                                                A
                                                                                                                                                                                                Brainrot') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Grow
                                                                                                                                                                                                A
                                                                                                                                                                                                Garden') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Hunty
                                                                                                                                                                                                Zombie') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('99
                                                                                                                                                                                                Nights In
                                                                                                                                                                                                The Forest') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('prospecting') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('All
                                                                                                                                                                                                Star
                                                                                                                                                                                                Tower
                                                                                                                                                                                                Defense X') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Ink
                                                                                                                                                                                                Game') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Garden
                                                                                                                                                                                                Tower
                                                                                                                                                                                                Defense') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Bubble
                                                                                                                                                                                                Gum
                                                                                                                                                                                                Simulator') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Dead
                                                                                                                                                                                                Rails') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('TYPE./
                                                                                                                                                                                                ISOUL') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Hypershot') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Build
                                                                                                                                                                                                A
                                                                                                                                                                                                Zoo') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Gems') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Rivals') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('MM2') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Blox
                                                                                                                                                                                                Fruit') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Pet
                                                                                                                                                                                                Simulator
                                                                                                                                                                                                99') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Spin') }}</span>
                            <span
                                class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Adopt
                                                                                                                                                                                                Me') }}</span>
                        </div>

                        <!-- Right Filters -->
                        <div class="flex gap-3 justify-end">
                            <button
                                class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">{{ __('● Online Seller') }}</button>

                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('All statuses') }}</option>
                                <option value="completed">{{ __('Completed') }}</option>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="processing">{{ __('Processing') }}</option>
                            </x-ui.select>

                        </div>
                    </div>



                    <div class=" flex items-center justify-center ">

                        {{-- Card 1 --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">

                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 2 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 4 --}}

                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 5 --}}
                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 6 --}}
                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 7 --}}
                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 8 --}}
                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                            {{-- Card 9 --}}
                            {{-- Card 3 --}}
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                            wire:navigate>
                            <!-- Card -->
                            <div class="bg-bg-primary rounded-2xl p-5 shadow-lg transition">

                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="bg-orange-500 text-white font-bold rounded-md w-6 h-6 flex items-center justify-center">
                                            F</div>
                                        <span class="text-green-400 font-medium">Xbox</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">• Stacked</span>
                                </div>

                                <div class="flex flex-row my-2">
                                    <p class="text-text-secondary text-sm mt-4 ml-1 mx-6">
                                        Blue Squire Skin – 50 VB – Xbox / PSN / PC Full Access
                                    </p>

                                    <img class="w-16 h-16 rounded float-right"
                                        src="{{ asset('assets/images/Rectangle.png') }}"
                                        alt="Image">
                                </div>

                                <div class=" flex items-center justify-between ">
                                    <span class="text-text-white font-medium text-lg">PEN175.27</span>
                                    <div class="flex items-center space-x-1 text-gray-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Instant</span>
                                    </div>
                                </div>

                                <div class="border-t border-purple-900 mt-4 pt-3 flex items-center">

                                    <div class="relative">
                                        <img src="{{ asset('assets/images/2 1.png') }}"
                                            class="w-14 h-14 rounded-full border-[3px] border-white" alt="profile" />
                                        <span
                                            class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-[3px] border-white rounded-full"></span>
                                    </div>

                                    <div class="ml-3 ">
                                        <p class="text-text-white font-medium">Victoria</p>

                                        <div class="flex items-center space-x-2 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="#853EFF" class="w-5 h-5">
                                                <path
                                                    d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                            </svg>
                                            <p class="text-gray-400 text-xs">99.3% | 2434 reviews | 1642 Sold</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>

                        </div>
                    </div>


                    <div class="flex justify-end items-center space-x-3  p-4 m-10">
                        <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Previous') }}</button>

                        <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
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
