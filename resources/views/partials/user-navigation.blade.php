<nav class="hidden xl:flex gap-8 text-sm items-center relative" x-data="{ open: '', searchActive: false }" x-cloak>

    <!-- Categories -->
    <div x-show="!searchActive" class="flex gap-8" x-transition:opacity.duration.300ms>
        @foreach (gameCategories() as $category)
            <a href="{{ $category['url'] }}" wire:navigate x-on:mouseenter="open = '{{ $category['slug'] }}'"
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

    <div class="relative flex items-center justify-end overflow-hidden transition-all duration-300 ease-in-out " :class="searchActive ? 'w-3xl' : 'w-22'"
        x-transition:enter.duration.300ms x-transition:leave.duration.300ms
        x-transition:enter-start="w-22" x-transition:enter-end="w-3xl">

        <flux:icon name="magnifying-glass"
            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary" />

        <input type="text" placeholder="Search" x-on:click="searchActive = true; open = ''"
            x-on:blur="searchActive = false"
            class="border dark:border-white border-gray-600 rounded-full py-2 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary w-full bg-transparent placeholder:text-text-primary">
    </div>


    <livewire:frontend.partials.search-modal />

</nav>
