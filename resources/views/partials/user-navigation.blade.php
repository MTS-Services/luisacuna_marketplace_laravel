<nav class="hidden xl:flex gap-8 text-sm items-center relative" x-data="{searchActive: false }" x-cloak>
    <div x-show="!searchActive" class="flex gap-8" x-transition:opacity.duration.300ms>
        @foreach (gameCategories() as $category)
            <a href="{{ $category['url'] }}" wire:navigate
                x-on:mouseenter="open = (open == '{{ $category['slug'] }}' || open == '' || open != '{{ $category['slug'] }}' ? '{{ $category['slug'] }}' : '')"
                class="navbar_style group relative"
                :class="{
                    'active': open == '{{ $category['slug'] }}' ||
                        {{ request()->routeIs($category['slug']) ? 'true' : 'false' }}
                }">
                <span class="relative z-10">{{ $category['name'] }}</span>
                <span
                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 ease-in-out origin-left"
                    :class="{
                        '!scale-x-100': open == '{{ $category['slug'] }}' ||
                            {{ request()->routeIs($category['slug']) ? 'true' : 'false' }}
                    }"></span>
            </a>
        @endforeach
    </div>
   
    <div class="relative flex items-center ml-auto" :style="searchActive ? 'width: 48rem' : 'width: 5.5rem'"
        style="transition: width 300ms ease-in-out">

        <flux:icon name="magnifying-glass"
            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary pointer-events-none z-10" />

        <input type="text" placeholder="Search" x-on:click="searchActive = true; open = ''; globalSearch = true"
            x-on:blur="setTimeout(() => { searchActive = false }, 200)"
            class="border dark:border-white border-gray-600 rounded-full py-2 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary w-full bg-transparent placeholder:text-text-primary">
    </div>

    <!-- Search Modal Dropdown -->
    <div x-show="searchActive && globalSearch" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" class="absolute top-full right-0 mt-1 z-50"
        style="width: 48rem" x-on:click.outside="globalSearch = false; searchActive = false">

        <div class="bg-bg-primary flex flex-col rounded-lg shadow-2xl py-4 px-4 max-h-[70vh]">
            {{-- Loading Spinner --}}
            <div wire:loading.flex wire:target="search"
                class="absolute inset-0 bg-bg-primary/70 backdrop-blur-sm flex flex-col items-center justify-center rounded-lg z-50">
                <div class="relative flex items-center justify-center w-12 h-12">
                    <div class="absolute w-12 h-12 border-4 border-purple-500/30 rounded-full"></div>
                    <div
                        class="absolute w-12 h-12 border-4 border-purple-500 border-t-transparent rounded-full animate-spin">
                    </div>
                </div>
                <p class="text-sm text-purple-300 mt-3 font-medium tracking-wide">{{ __('Loading content...') }}</p>
            </div>

            {{-- Popular Categories --}}
            <div class="px-4 py-3 flex-1 overflow-y-auto">
                <h3 class="text-xs font-semibold text-text-white/70 uppercase tracking-wider mb-2 pt-1 px-2.5">
                    {{ __('POPULAR CATEGORIES') }}
                </h3>
                <div class="space-y-1 pb-4">
                    @php
                        $popularCategories = [
                            [
                                'name' => 'New World Coins Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 100.png',
                                'slug' => 'new-world-coins',
                            ],
                            [
                                'name' => 'Worldforge Legends Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 94.png',
                                'slug' => 'worldforge-legends',
                            ],
                            [
                                'name' => 'Exilecon Official Trailer Accounts',
                                'categorySlug' => 'accounts',
                                'icon' => 'Frame 93.png',
                                'slug' => 'exilecon-official-trailer',
                            ],
                            [
                                'name' => 'Echoes of the Terra Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 96.png',
                                'slug' => 'echoes-of-the-terra',
                            ],
                            [
                                'name' => 'Path of Exile 2 Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 103.png',
                                'slug' => 'path-of-exile-2-currency',
                            ],
                            [
                                'name' => 'Epochs of Gaia Top-Ups',
                                'categorySlug' => 'top-ups',
                                'icon' => 'Frame 102.png',
                                'slug' => 'epochs-of-gaia',
                            ],
                            [
                                'name' => 'Throne and Liberty Lucent Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 105.png',
                                'slug' => 'throne-and-liberty-lucent',
                            ],
                            [
                                'name' => 'Titan Realms Top-Ups',
                                'categorySlug' => 'top-ups',
                                'icon' => 'Frame 98.png',
                                'slug' => 'titan-realms',
                            ],
                            [
                                'name' => 'Blade Ball Tokens Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 97.png',
                                'slug' => 'blade-ball-tokens',
                            ],
                            [
                                'name' => 'Kingdoms Across Skies Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame 99.png',
                                'slug' => 'kingdoms-across-skies',
                            ],
                            [
                                'name' => 'EA Sports FC Currency',
                                'categorySlug' => 'currency',
                                'icon' => 'Frame1001.png',
                                'slug' => 'ea-sports-fc-coins',
                            ],
                            [
                                'name' => 'Realmwalker: New Dawn Accounts',
                                'categorySlug' => 'accounts',
                                'icon' => 'Frame 111.png',
                                'slug' => 'realmwalker-new-dawn',
                            ],
                        ];
                    @endphp

                    @foreach ($popularCategories as $item)
                        <a href="{{ route('game.index', ['gameSlug' => $item['slug'], 'categorySlug' => $item['categorySlug']]) }}"
                            wire:navigate
                            class="flex items-center gap-3 p-2 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <img src="{{ asset('assets/images/game_icon/' . $item['icon']) }}"
                                    alt="{{ $item['name'] }}" class="w-full h-full object-contain">
                            </div>
                            <p class="text-base lg:text-lg font-normal text-text-white">{{ $item['name'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>
