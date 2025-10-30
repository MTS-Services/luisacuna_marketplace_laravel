<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 mt-10">
            <div class="w-3 h-3">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <span class="text-base text-text-white">Home</span>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <div class="text-text-white text-base">
                Currency
            </div>
        </div>


        <div class="title mt-14 mb-5">
            <h2 class="font-semibold text-4xl">Currency</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-10">
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
                            <x-ui.button class="">See Seller List</x-ui.button>
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
                            <x-ui.button class="">See Seller List</x-ui.button>
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
                            <x-ui.button class="">See Seller List</x-ui.button>
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
                            <x-ui.button class="">See Seller List</x-ui.button>
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
                            <x-ui.button class="">See Seller List</x-ui.button>
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
        <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
