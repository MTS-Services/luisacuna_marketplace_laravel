<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <span class="text-base text-text-white">Home</span>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                Coaching
            </h1>
        </div>

        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">Coaching</h2>
        </div>



        {{-- filter section --}}
        <div class="flex items-center justify-between gap-4 mt-14 mb-10">
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
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">Popular Now</h2>
            </div>
            <div class="swiper popular-coaching">
                <div class="swiper-wrapper pt-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68">
                                    <img src="{{ asset('assets/images/items/WorldOfwarcraft.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">World Of warcraft</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/FC25.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">FC 25</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/WOWMistsofPandariaClassic.png') }}"
                                        alt="" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">WOW Mists of Pandaria
                                        Classic</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/WOWMistsofPandariaClassic.png') }}"
                                        alt="" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">WOW Mists of Pandaria
                                        Classic</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/WOWMistsofPandariaClassic.png') }}"
                                        alt="" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">WOW Mists of Pandaria
                                        Classic</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
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
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">Newly Launched</h2>
            </div>
            <div class="swiper popular-launched">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68">
                                    <img src="{{ asset('assets/images/items/ApexLegends.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">Apex Legends</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Diablo4.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">Diablo 4.png</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/ClashRoyale.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">Clash Royale</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">Last war:survival</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="text-2xl text-semibold text-text-white">Last war:survival</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    See seller list
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="">
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- All brands for Coaching --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">All brands for Coaching</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68">
                        <img src="{{ asset('assets/images/items/BlueProtocol.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Blue Protocol</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Brawlhalla.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Brawlhalla</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ClashOfClans(Global).png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Clash Of Clans (Global)</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Des2.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Des2</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Diablo2Resurrected.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Diablo 2: Resurrected</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ESO.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">ESO</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Dota2.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Dota 2</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/FinalFantasyXIV(ARR).png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Final Fantasy XIV (ARR)</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/DragonDogma2.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="text-2xl text-semibold text-text-white">Dragon's Dogma 2</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="" href="{{ route('game.index',['categorySlug'=>'coaching','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        See seller list
                    </x-ui.button>
                </div>
            </div>
        </div>

        <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-coaching', {
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
            document.addEventListener('livewire:navigated', function() {
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
