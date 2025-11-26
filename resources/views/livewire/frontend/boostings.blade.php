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
            <div class="flex items-center justify-between gap-4 mt-3.5">
                <div class="search w-full">
                    <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                        class="form-input w-full rounded-full!" />
                </div>
                <div class="min-w-30 flex items-center justify-between gap-2 relative" x-data={filter:false}>

                    {{-- Filter Button --}}
                    <button @click="filter = !filter"
                        class="flex items-center gap-2 px-4 py-2 bg-bg-primary rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                        </svg>
                        <span class="text-text-white text-sm">
                            @if ($sortOrder === 'asc')
                                {{ __('a-z') }}
                            @elseif($sortOrder === 'desc')
                                {{ __('z-a') }}
                            @else
                                {{ __('Default') }}
                            @endif
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div class="absolute top-14 right-0 z-10 shadow-glass-card" x-show="filter" x-transition x-cloak
                        @click.outside="filter = false">
                        <div class="bg-bg-primary rounded-md p-4">
                            <div class="flex flex-col gap-2">
                                <button wire:click="sortBy('asc')" @click="filter = false"
                                    class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'asc' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                    {{ __('A-Z') }}
                                </button>
                                <button wire:click="sortBy('desc')" @click="filter = false"
                                    class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'desc' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                    {{ __('Z-A') }}
                                </button>
                                <button wire:click="sortBy('default')" @click="filter = false"
                                    class="text-left px-3 py-2 rounded transition {{ $sortOrder === 'default' ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                                    {{ __('Default') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Popular Boosting') }}</h2>
            </div>
            <div wire:ignore class="swiper popular-boosting">
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

        <div class="max-w-7xl mx-auto px-12">
            <div class="title mt-10">
                <h2 class="font-semibold text-40px">{{ __('Newly Boosting') }}</h2>
            </div>
            <div wire:ignore class="swiper popular-boosting">
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

        <div class="max-w-7xl mx-auto px-12 py-6  ">
            <!-- Popular Boosting -->
            <div class="title mb-5">
                <h2 class="font-semibold text-4xl">{{ __('Fortnite') }}</h2>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                @foreach ($boostings as $boosting)
                    <x-currency-card :data="$boosting" />
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
