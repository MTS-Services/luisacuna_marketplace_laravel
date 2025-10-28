<main class="overflow-x-hidden">
    {{-- menu card --}}
    <section class="max-w-5xl mx-auto mt-6">
        <div class="bg-zinc-950 flex align-items-center justify-between p-10">
            <div class="pt-10">
                <h3 class="text-3xl pb-3 text-base-600">Popular games</h3>
                <div class="grid grid-cols-2 gap-5">
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 100.png') }}" alt="">
                            <p class="text-base-400">New World Coins</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 94.png') }}" alt="">
                            <p class="text-base-400">Worldforge Legends</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 93.png') }}" alt="">
                            <p class="text-base-400">Exilecon Official Trailer</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 96.png') }}" alt="">
                            <p class="text-base-400">Echoes of the Terra</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 103.png') }}" alt="">
                            <p class="text-base-400">Path of Exile 2 Currency</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 102.png') }}" alt="">
                            <p class="text-base-400">Epochs of Gaia</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 105.png') }}" alt="">
                            <p class="text-base-400">Throne and Liberty Lucent</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 98.png') }}" alt="">
                            <p class="text-base-400">Titan Realms</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 97.png') }}" alt="">
                            <p class="text-base-400">Blade Ball Tokens</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 99.png') }}" alt="">
                            <p class="text-base-400">Kingdoms Across Skies</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 101.png') }}" alt="">
                            <p class="text-base-400">EA Sports FC Coins</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/game_icon/Frame 111.png') }}" alt="">
                            <p class="text-base-400">Realmwalker: New Dawn</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="">
                    <div class="">
                        <span class="relative">
                            <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search for game"  class="form-input w-full text-zinc-50!" />
                        </span>
                         <span class="absolute top-35 right-125">
                            <x-flux::icon name="magnifying-glass" class="w-6 h-6 inline-block " stroke="white" />
                         </span>
                    </div>
                    <div class="">
                        <p class="text-[12px] font-[400] mt-3 mb-3">All games</p>
                        <p class="text-base-400">EA Sports FC Coins</p>
                        <p class="text-base-400 mt-3">Albion Online Silver</p>
                        <p class="text-base-400 mt-3">Animal Crossing: New Horizons Bells</p>
                        <p class="text-base-400 mt-3">Black Desert Online Silver</p>
                        <p class="text-base-400 mt-3">Blade & Soul NEO Divine Gems</p>
                        <p class="text-base-400 mt-3">Blade Ball Tokens</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="title mt-20 mb-5">
            <h2 class="font-bold text-4xl">Currency</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full" />
            </div>
            <div class="filter flex items-center">
                <div class="border border-primary rounded-xl h-10 w-30 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/light.png') }}" alt="" class="w-5 h-5">
                    <p>Filter</p>
                </div>
            </div>
        </div>
    </section>
    {{-- popular currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-20 mb-6">
            <h2 class="font-bold text-4xl">Popular Currency</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-10">
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full h-[272px]">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">EA sports FC Coins</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full h-[272px]">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Blade Ball Tokens</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">New World Coins</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
        </div>
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-20 mb-6">
            <h2 class="font-bold text-4xl">All Currency</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-10">
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Exilecon Official Trailer</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 164.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">RuneScape 3 Gold</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3 px-4! py-2!">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 165.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Silver Farming</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (6).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Hand Farmed Low Price Gold</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (7).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">RuneScape 3 Gold</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (8).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Free Club Coins FC25</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (9).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Worldforge Legends</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (10).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Echoes of the Terra</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (11).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Epochs of Gaia</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (12).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Titan Realms</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (13).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Kingdoms Across Skies</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
            <div class="bg-zinc-900 p-5 rounded-2xl">
                <div class="images w-full min-h-[272px]">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (14).png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h3 class="font-bold text-lg mb-2 mt-3  text-white">Realmwalker: New Dawn</h3>
                    <p class="text-sm text-pink-500 mb-4">50 offer</p>
                    <button class="btn-primary w-full !px-4 !py-2 sm:!px-5 sm:!py-3">See Seller List</button>
                </div>
            </div>
        </div>
        <div class="mt-10 mb-30 text-center">
            <button class="btn-primary w-sm">Load More</button>
        </div>
    </section>
</main>
