<nav class="hidden xl:flex gap-8 text-sm items-center" x-clock>
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
    <div class="relative hidden xl:block">
        <flux:icon name="magnifying-glass"
            class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 stroke-text-primary" />

        <input type="text" placeholder="Search" x-on:click="globalSearchModal = true" x-clock
            class="border dark:border-white border-gray-600 rounded-full py-1.5 pl-8 pr-2 text-sm focus:outline-none focus:border-purple-500 focus:bg-bg-primary transition-all w-22 bg-transparent placeholder:text-text-primary">
    </div>

</nav>
