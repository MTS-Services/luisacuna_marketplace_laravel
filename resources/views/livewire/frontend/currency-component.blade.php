<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Currency') }}
            </h1>
        </div>


        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Currency') }}</h2>
        </div>

        {{-- Filter --}}
        <x-filter :sortOrder="$sortOrder" />
        {{-- Filter --}}


    </section>
    {{-- popular currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-10">
            <h2 class="font-semibold text-40px">{{ __('Popular Currency') }}</h2>
        </div>
        <div wire:ignore class="swiper popular-currency">
            <div class="swiper-wrapper py-10">
                @foreach ($popular_games as $popular_game)
                    <div class="swiper-slide">
                        <x-currency-card :data="$popular_game" :categorySlug="$categorySlug" />
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
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mb-10">
            <h2 class="font-semibold text-40px">{{ __('All Currency') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-6">
           
            @foreach ($games as $game)
                <x-currency-card :data="$game" :categorySlug="$categorySlug" />
            @endforeach
        </div>
        <div class="pagination mb-24">
            {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
            {{ $games->links() }}
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
