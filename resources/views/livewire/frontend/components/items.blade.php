<main class="mx-auto">
    <section class="container mx-auto">
        <div class="flex items-center gap-1 mt-10">
            <div class="w-3 h-3">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-white text-base">
                Home
            </div>
            <div class="px-2 text-white text-base">
                >
            </div>
            <div class="text-white text-base">
                Items
            </div>
        </div>
    </section>
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 mt-10 mb-10">
            <div class="w-12 h-12">
                <img src="{{ asset('assets/images/items/item-logo.png') }}" alt="m logo"
                    class="w-full h-full object-cover">
            </div>
            <div class="">
                <h2 class="font-semibold text-white text-5xl">Items</h2>
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
                <h2 class="font-semibold text-white text-5xl">Popular Item</h2>
            </div>
            <div class=" sm:flex items-center gap-6">
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-full h-68">
                            <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Grand Theft Auto 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Valorant</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-full h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Call of Duty</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- all items --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-white text-5xl">All Item</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68">
                        <img src="{{ asset('assets/images/items/language-legends.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">League of Legends</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Fortnite.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Fortnite</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/RainbowSixSiegeX.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Rainbow Six Siege X</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ClashRoyale.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Clash Royale</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Counter-Strike2.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Counter-Strike 2</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/CallofDuty.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Call of Duty</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/GrandTheftAuto5.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Grand Theft Auto 5</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Valorant1.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Valorant</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Minecraft</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ForzaHorizon5.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">Forza Horizon 5</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/WOWMistsOfPandariaClassic.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">WOW Mists of Pandaria Classic</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
            <div class="p-6 bg-zinc-900 rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/1945USAirForce.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-white">1945 US Air Force</h2>
                    </div>
                </div>
                <div class="">
                    <button class="btn-primary w-full">
                        See seller list
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-10 mb-10 text-center">
            <button class="btn-primary w-sm">Load More</button>
        </div>
        <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div>
    </section>
</main>
