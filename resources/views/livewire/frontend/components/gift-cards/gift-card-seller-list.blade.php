<main class="mx-auto">
    {{-- header --}}
    <section class="container mx-auto mt-16">
        {{-- inner nav --}}
        <div class="sm:py-4 sm:px-8 lg:py-0 lg:px-0">
            <div class=" text-text-white px-18 lg:px-0 md:px-0">
                <div
                    class="max-w-[900px] mx-auto flex flex-col md:flex-row gap-4 md:items-center justify-between w-full sm:px-6 sm:py-6 lg:py-0 lg:px-0 mt-4">
                    <!-- Logo -->
                    <div class="flex gap-8">
                        <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                            <img src="{{ asset('assets/images/fortnite.png') }}" alt="">
                        </div>
                        <span class="text-xl font-medium">Fortnite</span>
                    </div>
                    <!-- Navigation Links -->
                    <nav
                        class=" peer-checked:flex flex-col lg:flex lg:flex-row gap-6 w-full lg:w-auto  lg:bg-transparent border-t border-gray-800 lg:border-none z-50">
                        <button wire:navigate wire:click="switchTab('items')"
                            class="navbar_style group {{ $activeTab === 'items' ? 'active' : '' }} ">
                            <span class="relative z-10">Items</span>
                            <span class="navbar_indicator"></span>
                        </button>
                        <button wire:navigate wire:click="switchTab('accounts')"
                            class="navbar_style group {{ $activeTab === 'accounts' ? 'active' : '' }}">
                            <span class="relative z-10">Accounts</span>
                            <span class="navbar_indicator"></span>
                        </button>
                        <button wire:navigate wire:click="switchTab('topUps')"
                            class="navbar_style group {{ $activeTab === 'topUps' ? 'active' : '' }}">
                            <span class="relative z-10">Top Ups</span>
                            <span class="navbar_indicator"></span>
                        </button>
                        <button wire:navigate wire:click="switchTab('giftCard')"
                            class="navbar_style group {{ $activeTab === 'giftCard' ? 'active' : '' }}">
                            <span class="relative z-10">Gift Card</span>
                            <span class="navbar_indicator"></span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
        {{-- paginate --}}
        <div class="flex items-center gap-1 mt-10">
            <div class="w-3 h-3">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <span class="text-base text-text-white">Gift card</span>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <div class="text-text-white text-base">
                Seller list
            </div>
        </div>

        {{--  --}}
        <div class="mt-10">
            <div class="flex items-center justify-between">
                <div class="">
                    <span class="text-base font-semibold">Select region</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="">
                        <span class="">
                            Sort by:
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/gift_cards/Ellipse 4.png') }}" alt="">
                        <span>Recommended</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/gift_cards/Ellipse 5.png') }}" alt="">
                        <span>Lowest Price</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-6">
                <select name="" id=""
                    class="borbder border-2 border-zinc-800 rounded-full py-4 px-8 w-sm text-text-white">
                    <option value="">Global</option>
                </select>
            </div>
            <div class="mb-10">
                <span class="text-base font-semibold text-text-white">
                    About 21 results
                </span>
            </div>
        </div>
    </section>

    {{-- main --}}
    <section class="container mx-auto">
        <div class="flex gap-6">
            <div class="w-[65%] grid grid-cols-3 gap-6">
                <div class="bg-bg-primary rounded-2xl p-7 border border-pink-500">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-bg-primary rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
            </div>
            <div class="w-[35%]">
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
                            <x-ui.button class="">$76.28 | Buy now </x-ui.button>
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
                                            <x-phosphor name="thumbs-up" variant="regular" class="fill-zinc-600" />
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
</main>
