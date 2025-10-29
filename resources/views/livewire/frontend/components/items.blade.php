<main class="mx-auto">
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
                        <button wire:navigate wire:click="switchTab('giftCard')" class="navbar_style group {{ $activeTab === 'giftCard' ? 'active' : '' }}">
                            <span class="relative z-10">Gift Card</span>
                            <span class="navbar_indicator"></span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>

    </section>

    @if ($activeTab === 'items')
        <section class="container mx-auto">
            {{-- paginate --}}
            <div class="flex items-center gap-1 mt-10">
                <div class="w-3 h-3">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo"
                        class="w-full h-full object-cover">
                </div>
                <div class="text-muted text-base">
                    <span class="text-base text-text-white">Home</span>
                </div>
                <div class="px-2 text-text-white text-base">
                    >
                </div>
                <div class="text-text-white text-base">
                    Items
                </div>
            </div>



            {{-- filter section --}}
            <div class="flex items-center gap-1 mt-10 mb-10">
                <div class="w-12 h-12">
                    <img src="{{ asset('assets/images/items/item-logo.png') }}" alt="m logo"
                        class="w-full h-full object-cover">
                </div>
                <div class="">
                    <h2 class="font-semibold text-text-white text-5xl">Items</h2>
                </div>
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

        {{-- popular items --}}
        <section class="container mx-auto">
            <div class="mt-10">
                <div class="mb-10">
                    <h2 class="font-semibold text-text-white text-5xl">Popular Item</h2>
                </div>
                <div class="swiper popular-items">
                    <div class="swiper-wrapper py-16">
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68">
                                        <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Grand Theft Auto 5</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Valorant</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-10">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        {{-- all items --}}
        <section class="container mx-auto mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-5xl">All Item</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68">
                            <img src="{{ asset('assets/images/items/language-legends.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">League of Legends</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Fortnite.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Fortnite</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/RainbowSixSiegeX.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Rainbow Six Siege X</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/ClashRoyale.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Clash Royale</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Counter-Strike2.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Counter-Strike 2</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/CallofDuty.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/GrandTheftAuto5.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Grand Theft Auto 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant1.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Valorant</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Minecraft</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/ForzaHorizon5.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Forza Horizon 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/WOWMistsOfPandariaClassic.jpg') }}"
                                alt="" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">WOW Mists of Pandaria Classic</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/1945USAirForce.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">1945 US Air Force</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="mt-10 mb-10 text-center">
                <x-ui.button class="w-sm mx-auto block">Load More</x-ui.button>
            </div>
            <div class="pagination mb-24">
                <x-frontend.pagination-ui />
            </div>
        </section>
    @endif
    @if ($activeTab === 'accounts')
        <section class="container mx-auto">
            {{-- paginate --}}
            <div class="flex items-center gap-1 mt-10">
                <div class="w-3 h-3">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo"
                        class="w-full h-full object-cover">
                </div>
                <div class="text-text-white text-base">
                    Home
                </div>
                <div class="px-2 text-text-white text-base">
                    >
                </div>
                <div class="text-text-white text-base">
                    Accounts
                </div>
            </div>



            {{-- filter section --}}
            <div class="flex items-center gap-1 mt-10 mb-10">
                <div class="">
                    <h2 class="font-semibold text-text-white text-5xl">Accounts</h2>
                </div>
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

        {{-- popular accounts --}}
        <section class="container mx-auto">
            <div class="mt-10">
                <div class="mb-10">
                    <h2 class="font-semibold text-text-white text-5xl">Popular Accoounts</h2>
                </div>
                <div class="swiper popular-accounts">
                    <div class="swiper-wrapper py-16">
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68">
                                        <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Grand Theft Auto 5</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Valorant</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-10">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                {{-- <div class=" sm:flex items-center gap-6">
                    <div class="p-6 bg-bg-primary rounded-2xl">
                        <div class="">
                            <div class="w-full h-68">
                                <img src="{{ asset('assets/images/items/b9448e58e81f17534ad44dab6cafb2c9435fd19f.jpg') }}"
                                    alt="" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <div class="mt-5 mb-8">
                                <h2 class="text-2xl text-semibold text-text-white">Grand Theft Auto 5</h2>
                            </div>
                        </div>
                        <div class="">
                            <x-ui.button class="">
                                See seller list
                            </x-ui.button>
                        </div>
                    </div>
                    <div class="p-6 bg-bg-primary rounded-2xl">
                        <div class="">
                            <div class="w-full h-68 rounded-2xl">
                                <img src="{{ asset('assets/images/items/Valorant1.jpg') }}" alt=""
                                    class="w-full h-full object-cover rounded-lg">
                            </div>
                            <div class="mt-5 mb-8">
                                <h2 class="text-2xl text-semibold text-text-white">Valorant</h2>
                            </div>
                        </div>
                        <div class="">
                            <x-ui.button class="">
                                See seller list
                            </x-ui.button>
                        </div>
                    </div>
                    <div class="p-6 bg-bg-primary rounded-2xl">
                        <div class="">
                            <div class="w-full h-68 rounded-2xl">
                                <img src="{{ asset('assets/images/items/CallofDuty.jpg') }}" alt=""
                                    class="w-full h-full object-cover rounded-lg">
                            </div>
                            <div class="mt-5 mb-8">
                                <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                            </div>
                        </div>
                        <div class="">
                            <x-ui.button class="">
                                See seller list
                            </x-ui.button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
        {{-- all items --}}
        <section class="container mx-auto mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-5xl">All Item</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68">
                            <img src="{{ asset('assets/images/items/language-legends.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">League of Legends</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Fortnite.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Fortnite</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/RainbowSixSiegeX.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Rainbow Six Siege X</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/ClashRoyale.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Clash Royale</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Counter-Strike2.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Counter-Strike 2</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/CallofDuty.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Call of Duty</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/GrandTheftAuto5.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Grand Theft Auto 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant1.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Valorant</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Minecraft</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/ForzaHorizon5.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Forza Horizon 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/WOWMistsOfPandariaClassic.jpg') }}"
                                alt="" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">WOW Mists of Pandaria Classic</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/1945USAirForce.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">1945 US Air Force</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="mt-10 mb-10 text-center">
                <x-ui.button class="w-sm mx-auto block">Load More</x-ui.button>
            </div>
            <div class="pagination mb-24">
                <x-frontend.pagination-ui />
            </div>
        </section>
    @endif
    @if ($activeTab === 'topUps')
        <section class="container mx-auto">
            {{-- paginate --}}
            <div class="flex items-center gap-1 mt-10">
                <div class="w-3 h-3">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo"
                        class="w-full h-full object-cover">
                </div>
                <div class="text-muted text-base">
                    <span class="text-base text-text-white">Home</span>
                </div>
                <div class="px-2 text-text-white text-base">
                    >
                </div>
                <div class="text-text-white text-base">
                    Top Up
                </div>
            </div>



            {{-- filter section --}}
            <div class="flex items-center justify-between my-10">
                <div class="w-full">
                    <h2 class="font-semibold text-text-white text-5xl">Top up</h2>
                    <p class="text-text-white text-20px pt-3">
                        Different from gift cards or vouchers, U7BUY provides a Top Up service with which you can add
                        funds directly to your balance. It contains a large variety, including mobile games, live
                        streaming, shopping, entertainment, etc.
                    </p>
                </div>
                <div class="w-full h-80">
                    <img src="{{ asset('assets/images/items/top-up.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>
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

        {{-- popular top up --}}
        <section class="container mx-auto">
            <div class="mt-10">
                <div class="mb-10">
                    <h2 class="font-semibold text-text-white text-5xl">Popular Now</h2>
                </div>
                <div class="swiper popular-toUp">
                    <div class="swiper-wrapper py-16">
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68">
                                        <img src="{{ asset('assets/images/items/ClashofClans.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Clash of Clans</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Fortnite.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Fortnite</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/GenshinImpact.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Genshin Impact</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/GenshinImpact.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Genshin Impact</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/GenshinImpact.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Genshin Impact</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-10">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Newly Launched --}}
        <section class="container mx-auto">
            <div class="mt-10">
                <div class="mb-10">
                    <h2 class="font-semibold text-text-white text-5xl">Newly Launched</h2>
                </div>
                <div class="swiper popular-launched">
                    <div class="swiper-wrapper py-16">
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68">
                                        <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">DarkWar: survival</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Kingshot.png') }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Kingshot</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Last war:survival</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Last war:survival</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="p-6 bg-bg-primary rounded-2xl">
                                <div class="">
                                    <div class="w-full h-68 rounded-2xl">
                                        <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}"
                                            alt="" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="mt-5 mb-8">
                                        <h2 class="text-2xl text-semibold text-text-white">Last war:survival</h2>
                                    </div>
                                </div>
                                <div class="">
                                    <x-ui.button class="">
                                        See seller list
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div class="mt-10">
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- All Game --}}
        <section class="container mx-auto mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-5xl">All Game</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68">
                            <img src="{{ asset('assets/images/items/Rectangle163.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">League of Legends</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/ArenaBreakout.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Arena Breakout</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/MonopolyGo.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Monopoly Go</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/AnimeStrike.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Anime Strike</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Standoff2.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Standoff2</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Fortnite2.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Fortnite</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/TikTok.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">TikTok</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/MoCo.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">MoCo</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
                <div class="p-6 bg-bg-primary rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/FreeFire.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-text-white">Free Fire</h2>
                        </div>
                    </div>
                    <div class="">
                        <x-ui.button class="">
                            See seller list
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="mt-10 mb-10 text-center">
                <x-ui.button class="w-sm mx-auto block">Load More</x-ui.button>
            </div>
            <div class="pagination mb-24">
                <x-frontend.pagination-ui />
            </div>
        </section>
    @endif

    @if ($activeTab === 'giftCard')
        
    @endif



    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.popular-items', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.popular-accounts', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.popular-toUp', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.popular-launched', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</main>
