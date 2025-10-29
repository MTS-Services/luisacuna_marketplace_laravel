<div>
    <div class=" text-white font-sans">
        <!-- Container -->
        <div class="max-w-7xl mx-auto px-12 py-12">

            <!-- Title -->
            <h1 class="lg:text-5xl sm:text-3xl md:text-4xl mb-8">Boosting</h1>

            <!-- Search + Filter -->
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-12">
                <div
                    class="flex items-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white rounded-lg px-3 py-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-600 dark:text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>

                    <input type="text" placeholder="Search"
                        class="w-full bg-transparent text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none px-3" />
                </div>

                <button
                    class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>

            <!-- Popular Boosting -->
            <h2 class="lg:text-5xl sm:text-3xl md:text-4xl mb-6 dark:text-white">Popular Boosting</h2>
            <div class="swiper popular-boosting">
                <div class="swiper-wrapper py-16">
                    <div class="swiper-slide">
                        <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                            <img src="{{ asset('assets/images/class_of_clans.png') }}" alt="Clash of Clans"
                                class="p-2 w-full h-68 object-cover rounded-xl" />
                            <div class="p-4">
                                <h3 class="lg:text-3xl sm:text-1xl md:text-2xl font-medium mb-4 dark:text-white">Clash
                                    of
                                    Clans
                                </h3>
                                <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                                    {{ __('See Seller List') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class=" rounded-xl overflow-hidden shadow-lg py-8 px-2 bg-bg-primary">
                            <img src="{{ asset('assets/images/fortnight.png') }}" alt="Clash of Clans"
                                class="p-2 w-full h-68 object-cover rounded-xl" />
                            <div class="p-4">
                                <h3
                                    class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                                    Fortnite
                                </h3>
                                <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                                    {{ __('See Seller List') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                            <img src="{{ asset('assets/images/gensin_inpact.png') }}" alt="Clash of Clans"
                                class="p-2 w-full h-68 object-cover rounded-xl" />
                            <div class="p-4">
                                <h3
                                    class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                                    Genshin
                                    Impact</h3>
                                <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                                    {{ __('See Seller List') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                            <img src="{{ asset('assets/images/class_of_clans.png') }}" alt="Clash of Clans"
                                class="p-2 w-full h-68 object-cover rounded-xl" />
                            <div class="p-4">
                                <h3 class="lg:text-3xl sm:text-1xl md:text-2xl font-medium mb-4 dark:text-white">Clash
                                    of
                                    Clans
                                </h3>
                                <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                                    {{ __('See Seller List') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class=" rounded-xl overflow-hidden shadow-lg py-8 px-2 bg-bg-primary">
                            <img src="{{ asset('assets/images/fortnight.png') }}" alt="Clash of Clans"
                                class="p-2 w-full h-68 object-cover rounded-xl" />
                            <div class="p-4">
                                <h3
                                    class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                                    Fortnite
                                </h3>
                                <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                                    {{ __('See Seller List') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12">
            <!-- Popular Boosting -->
            <h2 class="text-4xl mb-6 dark:text-white">Newly Boosting</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 ">

                <!-- Card 1 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/darkwar.png') }}" alt="DarkWar: survival"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                            DarkWar:
                            survival</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/kingshort.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                            KingShot
                        </h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/lastwar.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Last
                            war:survival</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

            </div>
            <div class="flex space-x-2 justify-center items-center  mt-8">
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
                <div class="w-4 h-2 rounded-full bg-purple-500"></div>
                <div class="w-4 h-2 rounded-full bg-gray-200"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <!-- Popular Boosting -->
            <h2 class="text-4xl mb-6 text-white">All Boosting</h2>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/ApexLegends.jpg') }}" alt="Apex Legends"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Apex
                            Legends
                        </h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Battlefield.jpg') }}" alt="Battlefield"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">
                            Battlefield
                        </h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Black Desert Online.jpg') }}" alt="Black Desert Online"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class=" lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Black
                            Desert Online</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12 py-12">
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Call of Duty.jpg') }}" alt="Call of Duty"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Call
                            of
                            Duty</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Clash of Clans.png') }}" alt="Clash of Clans"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Clash
                            of
                            Clans</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Dead By Daylight.jpg') }}" alt="Dead By Daylight"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Dead
                            By
                            Daylight</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <!-- Popular Boosting -->

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/EA Sports FC.jpg') }}" alt="EA Sports FC"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">EA
                            Sports
                            FC</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Elder Scrolls Online.jpg') }}" alt="Elder Scrolls Online"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Elder
                            Scrolls Online</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-bg-primary rounded-xl overflow-hidden shadow-lg py-8 px-2 ">
                    <img src="{{ asset('assets/images/Escape from Tarkov.jpg') }}" alt="Escape from Tarkov"
                        class="p-2 w-full h-68 object-cover rounded-xl" />
                    <div class="p-4">
                        <h3 class="lg:text-3xl sm:text-1xl md:text-2xl text-xl font-medium mb-4 dark:text-white">Escape
                            from
                            Tarkov</h3>
                        <x-ui.button href="{{ route('boost.seller-list') }}" class="w-full p-6">
                            {{ __('See Seller List') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-8 mb-18">
                <button
                    class="lg:text-xl sm:text-1xl md:text-2xl w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 px-18 rounded-full transition">
                    Load More
                </button>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.popular-boosting', {
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

</div>
