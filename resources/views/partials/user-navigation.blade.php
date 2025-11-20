<div class="hidden xl:flex items-center " x-cloak>
    <!-- Navigation Menu - Hidden when search is active -->
    <nav x-show="!globalSearchModal" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="flex gap-8 text-sm items-center w-full">
        @foreach (gameCategories() as $category)
            <a href="{{ $category['url'] }}" wire:navigate
                x-on:mouseenter="open = (open == '{{ $category['slug'] }}' || open == '' || open != '{{ $category['slug'] }}' ? '{{ $category['slug'] }}' : '')"
                class="navbar_style group relative whitespace-nowrap"
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
        
        <div class="relative ml-auto">
            <flux:icon name="magnifying-glass"
                class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary" />

            <input type="text" placeholder="Search" x-on:click="globalSearchModal = true"
                class="border dark:border-white border-gray-600 rounded-full py-1.5 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary transition-all w-22 bg-transparent placeholder:text-text-primary cursor-pointer">
        </div>
    </nav>

    <!-- Full-Width Search Bar Container - Shows when search is active -->
    <div x-show="globalSearchModal" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.stop
        class="flex items-center gap-3 w-3xl">
        <div class="relative flex-1">
            <flux:icon name="magnifying-glass"
                class="w-5 h-5 absolute left-4 top-1/2 transform -translate-y-1/2 stroke-text-primary z-10" />
            
            <input type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search for games, categories, items..."
                x-ref="searchInput"
                x-init="$nextTick(() => $refs.searchInput.focus())"
                @click.stop
                class="w-full border-2 dark:border-purple-500 border-purple-600 rounded-full py-2.5 pl-12 pr-4 text-base focus:outline-none focus:border-purple-400 dark:bg-bg-primary bg-white transition-all placeholder:text-text-secondary shadow-lg">
        </div>
    </div>

    <!-- Search Dropdown Modal - Positioned relative to header -->
    <div x-show="globalSearchModal" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        @click.stop
        @click.outside="globalSearchModal = false"
        @keydown.escape.window="globalSearchModal = false"
        class="absolute left-0 right-40 top-[calc(100%-5px)] z-50 px-4 max-w-4xl! mx-auto">
        
        <div class="bg-bg-primary border border-purple-500/30 rounded-2xl shadow-2xl max-h-[70vh] overflow-hidden backdrop-blur-xl">
            {{-- Loading Spinner --}}
            <div wire:loading.flex wire:target="search"
                class="absolute inset-0 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center rounded-2xl z-50">
                <div class="relative flex items-center justify-center w-12 h-12">
                    <div class="absolute w-12 h-12 border-4 border-purple-500/30 rounded-full"></div>
                    <div class="absolute w-12 h-12 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
                <p class="text-sm text-purple-300 mt-3 font-medium tracking-wide">{{ __('Searching...') }}</p>
            </div>

            {{-- Search Results Content --}}
            <div class="overflow-y-auto max-h-[70vh] custom-scrollbar">
                {{-- Popular Categories Section --}}
                <div class="p-6">
                    <h3 class="text-xs font-semibold text-text-white/70 uppercase tracking-wider mb-4 px-2">
                        {{ __('POPULAR CATEGORIES') }}
                    </h3>
                    <div class="grid grid-cols-1 gap-1">
                        @php
                            $popularCategories = [
                                ['name' => 'New World Coins Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 100.png', 'slug' => 'new-world-coins'],
                                ['name' => 'Worldforge Legends Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 94.png', 'slug' => 'worldforge-legends'],
                                ['name' => 'Exilecon Official Trailer Accounts', 'categorySlug' => 'accounts', 'icon' => 'Frame 93.png', 'slug' => 'exilecon-official-trailer'],
                                ['name' => 'Echoes of the Terra Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 96.png', 'slug' => 'echoes-of-the-terra'],
                                ['name' => 'Path of Exile 2 Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 103.png', 'slug' => 'path-of-exile-2-currency'],
                                ['name' => 'Epochs of Gaia Top-Ups', 'categorySlug' => 'top-ups', 'icon' => 'Frame 102.png', 'slug' => 'epochs-of-gaia'],
                                ['name' => 'Throne and Liberty Lucent Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 105.png', 'slug' => 'throne-and-liberty-lucent'],
                                ['name' => 'Titan Realms Top-Ups', 'categorySlug' => 'top-ups', 'icon' => 'Frame 98.png', 'slug' => 'titan-realms'],
                                ['name' => 'Blade Ball Tokens Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 97.png', 'slug' => 'blade-ball-tokens'],
                                ['name' => 'Kingdoms Across Skies Currency', 'categorySlug' => 'currency', 'icon' => 'Frame 99.png', 'slug' => 'kingdoms-across-skies'],
                                ['name' => 'EA Sports FC Currency', 'categorySlug' => 'currency', 'icon' => 'Frame1001.png', 'slug' => 'ea-sports-fc-coins'],
                                ['name' => 'Realmwalker: New Dawn Accounts', 'categorySlug' => 'accounts', 'icon' => 'Frame 111.png', 'slug' => 'realmwalker-new-dawn'],
                            ];
                        @endphp

                        @foreach ($popularCategories as $item)
                            <a href="{{ route('game.index', ['gameSlug' => $item['slug'], 'categorySlug' => $item['categorySlug']]) }}"
                                wire:navigate
                                @click="globalSearchModal = false"
                                class="flex items-center gap-3 p-3 hover:bg-purple-500/10 rounded-lg transition-all duration-200 cursor-pointer group">
                                <div class="w-8 h-8 flex items-center justify-center flex-shrink-0 bg-bg-hover rounded-lg p-1">
                                    <img src="{{ asset('assets/images/game_icon/' . $item['icon']) }}"
                                        alt="{{ $item['name'] }}" 
                                        class="w-full h-full object-contain">
                                </div>
                                <p class="text-base font-normal text-text-white group-hover:text-purple-400 transition-colors">
                                    {{ $item['name'] }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>