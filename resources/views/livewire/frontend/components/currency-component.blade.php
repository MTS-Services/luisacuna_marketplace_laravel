<main class="overflow-x-hidden">
    {{-- menu card --}}
    <section class="max-w-5xl mx-auto mt-6">
        <div class="bg-bg-primary flex align-items-center justify-between rounded-lg py-11 px-10">
            <div class="pt-10">
                <h3 class="text-text-white text-base font-semibold pt-2 mb-6">Popular games</h3>
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="flex align-items-center gap-2.5 p-2.5">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 100.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">New World Coins</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 94.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Worldforge Legends</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 93.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Exilecon Official Trailer</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 96.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Echoes of the Terra</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 103.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Path of Exile 2 Currency</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 102.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Epochs of Gaia</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 105.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Throne and Liberty Lucent</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 98.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Titan Realms</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 97.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Blade Ball Tokens</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame 99.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">Kingdoms Across Skies</p>
                    </div>
                    <div class="flex align-items-center gap-2.5 p-2.5 ">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/game_icon/Frame1001.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <p class="text-base font-normal text-text-white">EA Sports FC Coins</p>
                    </div>
                    <div class="">
                        <div class="flex align-items-center gap-2.5 p-2.5 ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/Frame 111.png') }}" alt=""
                                    class="w-full h-full">
                            </div>
                            <p class="text-base font-normal text-text-white">Realmwalker: New Dawn</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="">
                    <span class="relative">
                        <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search for game"
                            class="form-input w-full text-text-white" />
                    </span>
                </div>
                <div class="">
                    <p class="text-xs font-normal text-text-white p-2.5 mt-2">All games</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">EA Sports FC Coins</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">Albion Online Silver</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">Animal Crossing: New Horizons Bells</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">Black Desert Online Silver</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">Blade & Soul NEO Divine Gems</p>
                    <p class="text-base font-normal text-text-white p-2.5 mt-2">Blade Ball Tokens</p>
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
            <h2 class="font-semibold text-40px">Popular Currency</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-6">
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-68">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">EA sports FC Coins</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-68">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Blade Ball Tokens</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">New World Coins</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
        </div>
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-20 mb-6">
            <h2 class="font-semiq text-40px">All Currency</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-6">
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Exilecon Official Trailer</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 164.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">RuneScape 3 Gold</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 165.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Silver Farming</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (6).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Hand Farmed Low Price Gold</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (7).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">RuneScape 3 Gold</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (8).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Free Club Coins FC25</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (9).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Worldforge Legends</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (10).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Echoes of the Terra</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (11).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Epochs of Gaia</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (12).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Titan Realms</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (13).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Kingdoms Across Skies</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full min-h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (14).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Realmwalker: New Dawn</h3>
                    <p class="text-pink-500 mb-8">50 offer</p>
                    <x-ui.button class="">See Seller List</x-ui.button>
                </div>
            </div>
        </div>
        <div class="mt-10 mb-30 text-center">
            <x-ui.button class="w-sm mx-auto">Load More</x-ui.button>
        </div>
    </section>
</main>
