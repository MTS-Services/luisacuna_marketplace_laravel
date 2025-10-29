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
        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-zinc-800 rounded-2xl p-7 border border-pink-500">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
                <div class="bg-zinc-800 rounded-2xl p-7">
                    <div class="w-6 h-6">
                        <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                    <p class="text-xs text-text-white mt-2">V-Bucks</p>
                    <span class="text-base font-semibold text-pink-500 mt-4">$44.16</span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-zinc-800 rounded-2xl py-7 px-6">
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
                </div>
                <div class="">
                    <x-icons::chevron-down class="w-4 h-4 text-text-white" />
                    <span>text-base text-text-white</span>
                </div>
            </div>
        </div>
    </section>
</main>
