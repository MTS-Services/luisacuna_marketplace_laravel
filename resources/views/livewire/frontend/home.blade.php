<main class="overflow-x-hidden  bg-page ">

    <!-- Hero Section -->

    <div class="swiper swiper-hero">
        <div class="swiper-wrapper">
            @forelse ($heros as $key=> $hero)
                <div class="swiper-slide">
                    <x-home.hero :data="$hero" />
                </div>
            @empty
                <div class="swiper-slide">
                    <x-home.hero :data="null" />
                </div>
            @endforelse
        </div>

         <!-- Add Pagination and Navigation -->
        <div class="">
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </div>


    <section class="py-20" id="popular-games">
        {{-- New Bosting Games Section --}}
        <section class="container mx-auto mt-10">
            <div class="mx-0 sm:mx-5 md:mx-10 lg:mx-14 xl:mx-20">
                <div class="title mt-10">
                    <h2 class="text-40px font-bold mb-4 text-text-white">
                        {{ __('Newly Boosting') }}
                    </h2>
                </div>
                <div wire:ignore class="swiper new-boosting">
                    <div class="swiper-wrapper py-10">
                        @foreach ($new_bostings as $index => $boosting)
                            <div class="swiper-slide">
                                <x-game-card :data="$boosting" :categorySlug="'boosting'" />
                            </div>
                        @endforeach
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

        {{-- New Boosting Ends --}}

        {{-- Popular Games Section --}}
        <section class="container mx-auto mt-10">
            <div class="mx-0 sm:mx-5 md:mx-10 lg:mx-14 xl:mx-20">
                <div class="title mt-10">
                    <h2 class="text-40px font-bold mb-4 text-text-white">
                        {{ __('Popular Games') }}
                    </h2>
                </div>
                <div wire:ignore class="swiper popular-games">
                    <div class="swiper-wrapper py-10">
                        @foreach ($games as $game)
                            <div class="swiper-slide">
                                <x-game-card :data="$game" />
                            </div>
                        @endforeach
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

        {{-- Popular Games Ends --}}


        {{-- Top selling  Section --}}
        <section class="container mx-auto mt-10">
            <div class="mx-0 sm:mx-5 md:mx-10 lg:mx-14 xl:mx-20">
                <div class="title mt-10">
                    <h2 class="text-40px font-bold mb-4 text-text-white">
                        {{ __('Top-Selling Offers') }}
                    </h2>
                </div>
                <div wire:ignore class="swiper top-sellings">
                    <div class="swiper-wrapper py-10">
                        @foreach ($datas as $item)
                            <div class="swiper-slide">
                                <x-ui.shop-card :gameSlug="$item->games->slug" :categorySlug="$item->category->slug" :data="$item"
                                    :game="$game" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Pagination and Navigation -->
                    <div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
{{--  --}}
        {{-- Top Selling Ends --}}



    </section>

    <!-- How It Works Section -->
    <section class="py-20 pt-10">
        <div class="container mx-auto">
            <div class="mx-0 sm:mx-5 md:mx-10 lg:mx-14 xl:mx-20">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4 text-text-white">{{ __('How It Works') }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                            <img src="{{ asset('assets/images/home_page/secure_transaction.png') }}" alt="">
                        </div>
                        <h3 class="font-semibold text-2xl mb-2 text-text-white">{{ __('Secure Transactions') }}</h3>
                        <p class="text-text-white text-base font-normal">
                            {{ __('Our platform uses industry-leading encryption to ensure your  transactions are safe and secure, guaranteeing asafeshopping experience.') }}
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center relative">
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                            <img src="{{ asset('assets/images/home_page/verified_sellers.png') }}" alt="">
                        </div>
                        <div class="absolute top-8 left-[-25%] z-20 hidden md:block">
                            <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                        </div>
                        <h3 class="font-semibold text-2xl mb-2 text-text-white">{{ __('Verified Sellers') }}</h3>
                        <p class="text-text-white text-base font-normal">
                            {{ __('We meticulously verify every seller through an ID verification process, ensuring you receive genuine digital goods from trusted sources.') }}
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center relative">
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl">
                            <img src="{{ asset('assets/images/home_page/effortless_buying.png') }}" alt="">
                        </div>
                        <div class="absolute top-8 left-[-25%] z-20 hidden md:block">
                            <img src="{{ asset('assets/images/home_page/right-arrow.png') }}" alt="">
                        </div>
                        <h3 class="font-semibold text-2xl mb-2 text-text-white">
                            {{ __('Effortless Buying & Selling') }}
                        </h3>
                        <p class="text-text-white text-base font-normal">
                            {{ __('Our intuitive platform streamlines the buying and selling process, set with quick delivery and software within reach.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="container p-5 md:p-10 xl:p-20 bg-gradient-to-r from-zinc-900  to-pink-950">
        <div class="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-semibold mb-6 dark:text-text-white text-white  ">{{ __('About us') }}</h2>
                    <p class="dark:text-text-white text-white mb-4 text-xl font-normal">
                        {{ __('Digital Commerce is your go-to destination for buying and selling high-quality digital products. We connect buyers and verified sellers, ensuring secure transactions, fast delivery, and dedicated support for a seamless experience.') }}
                    </p>
                    {{-- <button class="btn-primary">
                        <span><x-flux::icon name="user" class="w-6 h-6 inline-block" stroke="white" /></span>
                        Explore Products</button> --}}
                    <x-ui.button class=" mt-10! py-3! px-4! w-auto! text-base font-normal ">

                        {{ __('Explore Products') }}
                    </x-ui.button>
                </div>

                <div class="w-full h-full">
                    <img src="{{ asset('assets/images/home_page/about.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <livewire:frontend.partials.faq :faqs_buyer="$faqs_buyer" :faqs_seller="$faqs_seller" />
  
    <div class="my-20"></div>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.swiper-hero', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },

                    slidesPerView: 1, // Always 1 item
                    spaceBetween: 20,
                });
            });
            // Home Boosting Slider

            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.new-boosting', {
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
                            slidesPerView: 2,
                        },

                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            // Home Popular Slider

            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-games', {
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
                            slidesPerView: 2,
                        },

                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            // top-sellings Slider

            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.top-sellings', {
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
                            slidesPerView: 2,
                        },

                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
        </script>
    @endpush
</main>
