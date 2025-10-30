<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
        <div class="flex items-center gap-1 mt-10">
            <div class="w-3 h-3">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
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
        <div class="flex items-center gap-1 mt-14 mb-10">
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">Accounts</h2>
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
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">Popular Accoounts</h2>
            </div>
            <div class="swiper popular-accounts">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68">
                                    <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
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
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">All Item</h2>
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
                        <img src="{{ asset('assets/images/items/WOWMistsOfPandariaClassic.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
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

        {{-- <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div> --}}
    </section>

    @push('scripts')
        <script>
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
        </script>
    @endpush
</main>
