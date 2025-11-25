<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
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
                {{ __('Top Up') }}
            </h1>
        </div>

        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Top Ups') }}</h2>
        </div>



        {{-- filter section --}}
        <div class="flex items-center justify-between my-10">
            <div class="w-full">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Top Up') }}</h2>
                <p class="text-text-white text-20px pt-3">
                    {{ __('Different from gift cards or vouchers, U7BUY provides a Top Up service with which you can add
                                                                                                    funds directly to your balance. It contains a large variety, including mobile games, live
                                                                                                    streaming, shopping, entertainment, etc.') }}
                </p>
            </div>
            <div class="w-full h-80">
                <img src="{{ asset('assets/images/items/top-up.png') }}" alt=""
                    class="w-full h-full object-cover">
            </div>
        </div>
        <div class="flex items-center justify-between gap-4 mt-10 relative" x-data="{ filter: false }">
            <div class="search flex-1">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded-full!" />
            </div>
            <div class="flex-shrink-0">
                <button @click="filter = !filter"
                    class="flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2 bg-bg-primary rounded-md w-[120px] sm:w-[140px]">
                    <div class="flex items-center gap-1 sm:gap-2 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                        </svg>
                        <span class="text-text-white text-xs sm:text-sm whitespace-nowrap truncate">
                            @if ($sortOrder === 'asc')
                                {{ __('A-Z') }}
                            @elseif($sortOrder === 'desc')
                                {{ __('Z-A') }}
                            @else
                                {{ __('Default') }}
                            @endif
                        </span>
                    </div>
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0 transition-transform"
                        :class="filter ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div class="absolute top-14 right-0 z-10 shadow-glass-card min-w-30" x-show="filter" x-transition
                    x-cloak @click.outside="filter = false">
                    <div class="bg-bg-primary rounded-md p-2">
                        <div class="flex flex-col gap-1">
                            <button wire:click="sortBy('default')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition text-sm {{ $sortOrder === 'default' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                {{ __('Default') }}
                            </button>
                            <button wire:click="sortBy('asc')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition text-sm {{ $sortOrder === 'asc' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                {{ __('A-Z') }}
                            </button>
                            <button wire:click="sortBy('desc')" @click="filter = false"
                                class="text-left px-3 py-2 rounded transition text-sm {{ $sortOrder === 'desc' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                {{ __('Z-A') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    {{-- popular top up --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Popular Now') }}</h2>
            </div>
            <div wire:ignore class="swiper popular-toUp">
                <div class="swiper-wrapper py-10">
                    @foreach ($popular_topUps as $popular_topUp)
                        <div class="swiper-slide">
                            <x-currency-card :data="$popular_topUp" />
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

    {{-- Newly Launched --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Newly Launched') }}
                </h2>
            </div>
            <div wire:ignore class="swiper popular-launched">
                <div class="swiper-wrapper py-10">
                    @foreach ($newly_topUps as $newly_topUp)
                        <div class="swiper-slide">
                            <x-currency-card :data="$newly_topUp" />
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

    {{-- All Game --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('All Game') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            @foreach ($topUps as $topUp)
                <x-currency-card :data="$topUp" />
            @endforeach
        </div>

        <div class="pagination mb-24">
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-toUp', {
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
