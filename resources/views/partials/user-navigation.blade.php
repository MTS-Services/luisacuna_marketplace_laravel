<nav class="hidden xl:flex gap-8 text-sm items-center relative" x-data="{ searchActive: false }" x-cloak>
    <div x-show="!searchActive" class="flex gap-8" x-transition:opacity.duration.300ms>
        @foreach ($categories as $category)
            <a wire:navigate href="{{ route('category.generic', ['categorySlug' => $category->slug]) }}"
                x-on:mouseenter="if (dropdownCloseTimeout) { clearTimeout(dropdownCloseTimeout); dropdownCloseTimeout = null }; if (!dropdownJustClosed) { open = (open == '{{ $category->slug }}' || open == '' || open != '{{ $category->slug }}' ? '{{ $category->slug }}' : '') }"
                x-on:mouseleave="if (dropdownCloseTimeout) clearTimeout(dropdownCloseTimeout); dropdownCloseTimeout = setTimeout(() => { open = ''; dropdownCloseTimeout = null }, 150)"
                class="navbar_style group relative"
                :class="{
                    'active': open == '{{ $category->slug }}' ||
                        {{ request()->routeIs($category->slug) ? 'true' : 'false' }}
                }">
                {{-- <span class="relative z-10">{{ $category->categoryTranslations->first()?->name ?? $category->name }}</span> --}}
                <span class="relative z-10">{{ $category->translatedName(app()->getLocale()) }} </span>
                <span
                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 transition-transform duration-300 ease-in-out origin-left"
                    :class="{
                        '!scale-x-100': open == '{{ $category->slug }}' ||
                            {{ request()->routeIs($category->slug) ? 'true' : 'false' }}
                    }"></span>
            </a>
        @endforeach
    </div>

    <div class="relative flex items-center ml-auto" wire:click="openGlobalSearch"
        :style="searchActive ? 'width: 50rem' : 'width: 5.5rem'" style="transition: width 300ms ease-in-out">

        <flux:icon name="magnifying-glass"
            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary pointer-events-none z-10" />

        <input type="text" wire:model.live="search" placeholder="{{ __('Search') }}"
            x-on:click="searchActive = true; open = ''; globalSearch = true"
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
        style="width: 50rem" x-on:click.outside="globalSearch = false; searchActive = false">

        <div class="bg-bg-primary flex flex-col rounded-lg shadow-2xl py-4 px-4 max-h-[70vh]">
            {{-- Loading Spinner --}}
            <div wire:loading.flex wire:target="openGlobalSearch,search"
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

                <div class="space-y-1 pb-4">




                    <div class="px-4 py-3 flex-1 overflow-y-auto">
                        @if (empty($search))
                            <h3
                                class="text-xs font-semibold text-text-white/70 uppercase tracking-wider mb-2 pt-1 px-2.5">
                                {{ __('POPULAR CATEGORIES') }}
                            </h3>
                            <div class="space-y-1 pb-4">
                                @forelse ($popular_games as $item)
                                    <a href="{{ route('game.index', ['gameSlug' => $item->slug, 'categorySlug' => $category->slug]) }}"
                                        wire:navigate
                                        class="flex items-center gap-3 p-2 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                                        <div class="w-6 h-6 flex items-center justify-center">
                                            <img src="{{ storage_url($item->logo) }}" alt="{{ $item->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                        <p class="text-base lg:text-lg font-normal text-text-white">
                                            {{ $item->translatedName(app()->getLocale()) }}
                                        </p>
                                    </a>
                                @empty
                                    <div class="text-center py-8">
                                        <p class="text-text-white/50">{{ __('No popular games found') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        @else
                            <h3
                                class="text-xs font-semibold text-text-white/70 uppercase tracking-wider mb-2 pt-1 px-2.5">
                                {{ __('SEARCH RESULTS') }}
                            </h3>
                            <div class="space-y-1 pb-4">
                                @forelse ($search_results as $item)
                                    <a href="{{ route('game.index', ['gameSlug' => $item->slug, 'categorySlug' => $category->slug]) }}"
                                        wire:navigate
                                        class="flex items-center gap-3 p-2 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                                        <div class="w-6 h-6 flex items-center justify-center">
                                            <img src="{{ storage_url($item->logo) }}" alt="{{ $item['name'] }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                        <p class="text-base lg:text-lg font-normal text-text-white">{{ $item['name'] }}
                                        </p>
                                    </a>
                                @empty
                                    <div class="text-center py-8">
                                        <p class="text-text-white/50">{{ __('No results found') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
