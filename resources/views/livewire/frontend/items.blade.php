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
                {{ __('Items') }}
            </h1>
        </div>
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Items') }}</h2>
        </div>
        {{-- filter section --}}
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

    {{-- popular items --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Popular Items') }}
                </h2>
            </div>
            <div wire:ignore class="swiper popular-items">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68">
                                    <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Grand Theft Auto 5') }}
                                    </h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Valorant') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">
                                        {{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'items', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
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
    {{-- all items --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('All Item') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            @foreach ($items as $item)
                <x-currency-card :data="$item" />
            @endforeach
        </div>

        <div class="pagination mb-24">
            <x-frontend.pagination-ui :pagination="$pagination" />
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-items', {
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
