<main class="mx-auto">
    <section class="container mt-16">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" />
        <div class="flex items-center gap-2 mt-8 text-lg font-semibold">
            <h1 class="text-blue-100 text-text-primary">
                {{$gameName. ' ' . ucwords(request()->get('game-category'))}}
            </h1>
            <span class=" text-text-primary">></span>
            <span class=" text-text-primary">Seller list</span>
        </div>
        <div class="mt-8">
            <div class="flex items-center justify-between">
                <div class="">
                    <span class="text-base font-semibold">Select region</span>
                </div>
                <div class="hidden md:flex items-center gap-2">
                    <div class="">
                        <span class="text-text-white">
                            Sort by:
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/gift_cards/Ellipse 4.png') }}" alt="">
                        <span class="text-text-white">Recommended</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/gift_cards/Ellipse 5.png') }}" alt="">
                        <span class="text-text-white">Lowest Price</span>
                    </div>
                </div>
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
                            Recommended
                        </a>
                        <a href="#"
                            class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                            Lowest Price
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-3 mb-6">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                <option value="">Global</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </x-ui.select>
        </div>

        <div class="mb-10">
            <span class="text-base font-semibold text-text-white">
                About 21 results
            </span>
        </div>
        </div>
    </section>

    {{-- main --}}
    <section class="container">
        <div class="md:flex gap-6">
            <div class="w-full md:w-[65%]  grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div
                    class="bg-bg-primary rounded-2xl p-7 border border-transparent hover:border-pink-500 transition-all duration-300">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
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
                            <p>IOOOV-Bucks</p>
                        </div>
                        <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                        <div class="flex items-center justify-between py-3">
                            <p class="text-base text-text-white">IOOOV-Bucks</p>
                            <p class="text-base text-text-white font-semibold">15 min</p>
                        </div>
                        <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                        <div class="mt-4">
                            <a href="{{ route('gift-card.check-out') }}">
                                <x-ui.button class="">$76.28 | Buy now </x-ui.button>
                            </a>
                        </div>
                        <div class="flex items-center gap-2 mt-8">
                            <flux:icon name="shield-check" class="w-6 h-6 50" />
                            <p class="text-text-white text-base font-semibold">Money-back Guarantee</p>
                            <span class="text-xs text-zinc-200/60">Protected by TradeShield</span>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <flux:icon name="bolt" class="w-6 h-6 50" />
                            <p class="text-text-white text-base font-semibold">Fast Checkout Options</p>
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
                            <p class="text-text-white text-base font-semibold">24/7 Live Support</p>
                            <span class="text-xs text-zinc-200/60">We're always here to help</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="bg-bg-primary rounded-2xl py-7 px-6">
                            <h3 class="text-text-white text-base font-semibold mb-2">Delivery instructions</h3>
                            <div class="flex gap-2">
                                <span class="text-sm text-text-white">Welcome</span>
                                <span class="inline-block w-px h-3 bg-zinc-500"></span>
                                <span class="text-sm text-text-white">Why choose us</span>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-text-white">1. V-BUCKS are safe to hold and guaranteed!</p>
                                <p class="text-sm text-text-white mt-2  mb-4">2. Fast replies and delivery.</p>

                                <a href="#" class="text-base font-semibold text-pink-500">See all</a>
                            </div>
                            <span class="border-t-2 border-zinc-500 w-full inline-block mt-8"></span>
                            <div class="">
                                <div class="flex gap-4 items-center mt-4">
                                    <div class="w-14 h-14">
                                        <img src="{{ asset('assets/images/gift_cards/profile.png') }}" alt=""
                                            class="w-full h-full">
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <h2 class="text-text-white font-semibold text-base">Devon Lane</h2>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-600" />
                                            <span class="text-xs text-text-white">99.3%</span>
                                            <span class="w-px h-4 bg-zinc-200"></span>
                                            <span class="text-xs text-text-white">2434 reviews</span>
                                            <span class="w-px h-4 bg-zinc-200"></span>
                                            <span class="text-xs text-text-white">1642 Sold</span>
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
            <h2 class="text-text-white font-semibold trxt-40px">Other sellers (84)</h2>
        </div>
        <div class="mt-10 mb-6">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                <option value="">Recommended</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </x-ui.select>
        </div>
        <div class="min-w-full text-left border-collapse">
            <div class="flex justify-between text-text-white text-sm">
                <div class="px-4 py-3">All Sellers (8)</div>
                <div class="px-4 py-3 hidden md:block">Delivery Time</div>
                <div class="px-4 py-3 hidden md:block">Delivery Method</div>
                <div class="px-4 py-3 hidden md:block">Stock</div>
                <div class="px-4 py-3 hidden md:block">Price</div>
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
                                <h3 class="text-text-white text-base font-semibold">Devon Lane</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">Instants</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">Login Top UP</div>
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
                                <h3 class="text-text-white text-base font-semibold">Devon Lane</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">Instants</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">Login Top UP</div>
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
                                <h3 class="text-text-white text-base font-semibold">Devon Lane</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">Instants</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">Login Top UP</div>
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
                                <h3 class="text-text-white text-base font-semibold">Devon Lane</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">Instants</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">Login Top UP</div>
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
                                <h3 class="text-text-white text-base font-semibold">Devon Lane</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">Instants</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">Login Top UP</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                    <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                </div>
            </div>
        </div>
    </section>
</main>