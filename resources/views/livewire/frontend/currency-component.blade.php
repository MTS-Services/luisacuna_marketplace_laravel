{{-- <div>
    <div class="bg-[#0D061A]">


        <div class="container mx-auto  ">

            <div class="navbar  bg-bg-black w-2/3 shadow-sm">
                <div class="flex-1 menu-horizontal ">
                    <a href=""><img src="{{ asset('assets/logo/Rectangle 12410.png') }}" alt=""></a>
                    <a class="btn btn-ghost text-xl">Fortnite</a>
                </div>
                <div class="flex-none items-center">
                    <ul class="menu menu-horizontal items-start px-1">
                        <li><a>items</a></li>
                        <li><a href="">Accound</a></li>
                        <li><a href="">tup Ups </a></li>
                        <li><a href="">Gift Card</a></li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10 ">

                <div class="md:w-1/2 space-y-6 text-center md:text-left">
                    <h1 class="text-4xl font-bold text-white">Top</h1>
                    <p class="text-whaite font-medium text-2xl tleading-relaxed">
                        Different from gift cards or vouchers, U7BUY provides a Top Up service with which you can add
                        funds directly to your balance. It contains a large variety, including mobile games, live
                        streaming,
                        shopping, entertainment, etc.
                    </p>
                </div>

                <!-- Right Side (Image) -->
                <div class="md:w-1/2 flex justify-center md:justify-end">
                    <img src="{{ asset('assets/images/section-8/Top ups img/Rectangle.png') }}" alt="Top Up Service"
                        class="rounded-2xl shadow-md w-full max-w-md object-cover">
                </div>

            </div>

        </div>

        <div class="bg-[#0D061A] py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-4">

                    <div class="flex-1 relative">
                        <input type="search" placeholder="Search"
                            class="w-full pl-12 pr-4 py-4 sm:py-5 text-white bg-[#110B24] border-2 border-[#6A5ACD] rounded-4xl placeholder-gray-400 text-lg focus:ring-0 focus:outline-none shadow-xl transition">

                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </g>
                        </svg>
                    </div>

                    <button
                        class="flex items-center justify-center w-auto px-6 py-4 sm:py-5 bg-[#110B24] border-2 border-[#6A5ACD] rounded-4xl text-white font-medium hover:bg-[#1A1433] transition shadow-xl">
                        <svg class="w-15 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v3.586a1 1 0 01-1.447.894l-2-1A1 1 0 018 16.586v-3.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <span class="text-lg">Filter</span>
                    </button>
                </div>
            </div>
        </div>

        <section class="bg-[#110B24] py-16 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-10">
                    Popular Now
                </h2>

                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide p-2">
                            <div class="card bg-[#1A1433] rounded-2xl shadow-xl w-full">
                                <figure class="p-4 pt-4">
                                    <img src="/path/to/clash-of-clans.png" alt="Clash of Clans"
                                        class="rounded-xl w-full h-auto object-cover" />
                                </figure>
                                <div class="card-body p-6 pt-3 text-left space-y-4">
                                    <h3 class="card-title text-white text-xl font-bold">Clash of Clans</h3>
                                    <button
                                        class="btn w-full bg-[#6A5ACD] hover:bg-[#5A4ABB] text-white border-none rounded-lg text-base font-medium transition duration-300">
                                        See seller list
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide p-2">
                            <div class="card bg-[#1A1433] rounded-2xl shadow-xl w-full">
                                <figure class="p-4 pt-4">
                                    <img src="/path/to/fortnite.png" alt="Fortnite"
                                        class="rounded-xl w-full h-auto object-cover" />
                                </figure>
                                <div class="card-body p-6 pt-3 text-left space-y-4">
                                    <h3 class="card-title text-white text-xl font-bold">Fortnite</h3>
                                    <button
                                        class="btn w-full bg-[#6A5ACD] hover:bg-[#5A4ABB] text-white border-none rounded-lg text-base font-medium transition duration-300">
                                        See seller list
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide p-2">
                            <div class="card bg-[#1A1433] rounded-2xl shadow-xl w-full">
                                <figure class="p-4 pt-4">
                                    <img src="/path/to/genshin-impact.png" alt="Genshin Impact"
                                        class="rounded-xl w-full h-auto object-cover" />
                                </figure>
                                <div class="card-body p-6 pt-3 text-left space-y-4">
                                    <h3 class="card-title text-white text-xl font-bold">Genshin Impact</h3>
                                    <button
                                        class="btn w-full bg-[#6A5ACD] hover:bg-[#5A4ABB] text-white border-none rounded-lg text-base font-medium transition duration-300">
                                        See seller list
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide p-2">...</div>
                        <div class="swiper-slide p-2">...</div>

                    </div>

                    <div class="swiper-pagination mt-10"></div>
                </div>

            </div>
        </section>

        <style>
            .swiper-pagination-bullet {
                width: 10px !important;
                height: 10px !important;
                background: #4A4A68 !important;
                opacity: 1 !important;
                margin: 0 4px !important;
            }

            .swiper-pagination-bullet-active {
                width: 20px !important;
                border-radius: 5px !important;
                background: #FFFFFF !important;/
            }
        </style>

        <script>
            var swiper = new Swiper(".mySwiper", {
                // Breakpoints for responsiveness: Shows 1 card on mobile, 3 on desktop
                slidesPerView: 1,
                spaceBetween: 24,
                breakpoints: {
                    640: { // sm
                        slidesPerView: 2,
                    },
                    1024: { // lg
                        slidesPerView: 3,
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        </script>


    </div>
</div> --}}
<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="container mx-auto">
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
                Currency
            </h1>
        </div>


        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">Currency</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-10 relative" x-data={filter:false}>
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded-full!" />
            </div>
            <button @click="filter = !filter"
                class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                </svg>
                <span>Filter</span>
            </button>
            <div class="absolute top-14 right-0 z-10 shadow-glass-card" x-show="filter" x-transition x-cloak @click.outside="filter = false">
                {{-- filter Options --}}
                <div class="bg-bg-primary rounded-md p-4">
                    <div class="flex flex-col gap-2">
                        <button class="">Option 1</button>
                        <button class="">Option 1</button>
                    </div>
                </div>  
            </div>
        </div>
    </section>
    {{-- popular currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-10">
            <h2 class="font-semibold text-40px">Popular Currency</h2>
        </div>
        <div class="swiper popular-currency">
            <div class="swiper-wrapper py-10">
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">EA sports FC Coins</h3>
                            <p class="text-pink-500 mb-8">50 offer</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="">See Seller List</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Blade Ball Tokens</h3>
                            <p class="text-pink-500 mb-8">50 offer</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="">See Seller List</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full min-h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">New World Coins</h3>
                            <p class="text-pink-500 mb-8">50 offer</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="">See Seller List</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">Blade Ball Tokens</h3>
                            <p class="text-pink-500 mb-8">50 offer</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="">See Seller List</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full min-h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-2xl mb-3 mt-5  text-text-white">New World Coins</h3>
                            <p class="text-pink-500 mb-8">50 offer</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="">See Seller List</x-ui.button>
                            </a>
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
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mb-10">
            <h2 class="font-semibold text-40px">All Currency</h2>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'runescape-3-gold']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'silver-farming']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'hand-farmed-low-price-gold']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'runescape-3-gold']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'free-club-coins-fc25']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'worldforge-legends']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'echoes-of-the-terra']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'epochs-of-gaia']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'titan-realms']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'kingdoms-across-skies']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
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
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        <x-ui.button class="">See Seller List</x-ui.button>
                    </a>
                </div>
            </div>
        </div>
        <div class="pagination mb-24">
            <x-frontend.pagination-ui :pagination = "$pagination"/>
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-currency', {
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
