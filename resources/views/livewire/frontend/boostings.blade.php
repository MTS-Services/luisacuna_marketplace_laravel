<div>
    <div class=" text-white font-sans">
        <!-- Container -->
        <div class="container mx-auto">
            <!-- Title -->
            <div class="flex items-center gap-1 my-10 font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <div class="text-muted text-base">
                    <span class="text-base text-text-white">{{ __('Home') }}</span>
                </div>
                <div class="px-2 text-text-white text-base">
                    >
                </div>
                <h1 class="text-text-white text-base">
                    {{ __('Boosting') }}
                </h1>
            </div>
            <div class="title mb-5">
                <h2 class="font-semibold text-4xl">{{ __('Boosting') }}</h2>
            </div>

            <!-- Search + Filter -->
            <div class="flex flex-col sm:flex-row items-center gap-4 relative" x-data="{ filter: false }">
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

                <button @click="filter = !filter"
                    class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span>{{ __('Filter') }}</span>
                </button>
                <div class="absolute top-14 right-0 z-10 shadow-glass-card" x-show="filter" x-transition x-cloak
                    @click.outside="filter = false">
                    {{-- filter Options --}}
                    <div class="bg-bg-primary rounded-md p-4">
                        <div class="flex flex-col gap-2">
                            <button class="">{{ __('Option 1') }}</button>
                            <button class="">{{ __('Option 2') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Popular Boosting') }}</h2>
            </div>
            <div class="swiper popular-boosting">
                <div class="swiper-wrapper py-16">
                    @foreach ($popular_boostings as $popular_boosting)
                        <div class="swiper-slide">
                            <x-currency-card :data="$popular_boosting" />
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <!-- Newly Boosting -->
        <div class="max-w-7xl mx-auto px-12">
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Newly Boosting') }}</h2>
            </div>
            <div class="swiper popular-boosting">
                <div class="swiper-wrapper py-16">
                    @foreach ($newly_boostings as $newly_boosting)
                        <div class="swiper-slide">
                            <x-currency-card :data="$newly_boosting" />
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>


        <!-- All Boosting -->
        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Fortnite') }}</h2>
            </div>
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($boostings as $boosting)
                    <x-currency-card :data="$boosting" />
                @endforeach
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <div class="flex justify-center mt-8 mb-18">
                <button
                    class="lg:text-xl sm:text-1xl md:text-2xl w-full sm:w-auto bg-purple-600 hover:bg-purple-700 text-white text-sm py-3 px-18 rounded-full transition">
                    {{ __('Load More') }}
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
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
