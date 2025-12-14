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

            {{-- filter section --}}
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Boostings') }}</h2>
        </div>

            <x-filter :sortOrder="$sortOrder"/>

            {{-- Page Serach Layout --}}

            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Popular Boosting') }}</h2>
            </div>
            <div wire:ignore class="swiper popular-boosting">
                <div class="swiper-wrapper">
                    @foreach ($popular_boostings as $popular_boosting)
                        <div class="swiper-slide">
                            <x-product-card :data="$popular_boosting" />
                        </div>
                    @endforeach
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-12">
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Newly Boosting') }}</h2>
            </div>
            <div wire:ignore class="swiper popular-boosting">
                <div class="swiper-wrapper py-16">
                    @foreach ($newly_boostings as $newly_boosting)
                        <div class="swiper-slide">
                            <x-product-card :data="$newly_boosting" />
                        </div>
                    @endforeach
                </div>

                <!-- Add Pagination and Navigation -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <!-- Popular Boosting -->
            <div class="title mb-5">
                <h2 class="font-semibold text-4xl">{{ __('Fortnite') }}</h2>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                @foreach ($boostings as $boosting)
                    <x-product-card :data="$boosting" />
                @endforeach

            </div>
        </div>


        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <div class="pagination mb-24">
                <x-frontend.pagination-ui :pagination="$pagination" />
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
