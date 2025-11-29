<main class="mx-auto">
    {{-- @if ($categorySlug == 'gift-card' || $categorySlug == 'top-up') --}}
    @if (true)
    <x-grid-layout :arr="['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug]" />

    @else
        <section>
            <div class="container ">
                <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                <div class="max-w-7xl mx-auto lg:px-8 lg:py-8">
                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-2 mb-8 text-md font-semibold">
                        <div class="w-4 h-4">
                            <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo"
                                class="w-full h-full object-cover">
                        </div>
                        <h1 class="text-blue-100 text-text-primary">
                            {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                        </h1>
                        <span class=" text-text-primary">></span>
                        <span class=" text-text-primary">{{ __('Shop') }}</span>
                      
                    </div>

                    <!-- Filters Section -->
                    <div class="mb-8 space-y-4">
                        <div class="flex gap-4 justify-between items-center md:justify-start md:flex-wrap relative"
                            x-data={filter:false}>
                            <div class="flex-1 w-auto md:min-w-64">
                                <div class="relative">
                                    <input type="text" placeholder="Search"
                                        class="w-full bg-bg-primary border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-zinc-500">
                                    <span class="absolute left-3 top-2.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Device') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Account type') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Price') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full! hidden md:flex">
                                <option value="">{{ __('Select Delivery Time') }}</option>
                            </x-ui.select>
                            <button
                                class="text-text-primary hover:text-text-primary/80 transition hidden md:flex">{{ __('Clear all') }}</button>
                            <button @click="filter = !filter"
                                class="flex items-center gap-2 border border-zinc-500 rounded-full px-5 py-2 hover:bg-zinc-600  transition md:hidden group" :class="{ 'bg-zinc-600': filter }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:stroke-white transition-color duration-300" :class="{ 'stroke-white': filter }" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                                </svg>
                                <span class="group-hover:text-white transition-color duration-300" :class="{ 'text-white': filter }">{{ __('Filter') }}</span>
                            </button>

                            <div x-show="filter"
                                class="glass-card bg-bg-primary/50 text-text-white p-6 rounded-lg w-full absolute top-16 right-0 z-10 md:hidden">
                                <!-- Header -->
                                <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
                                    <h2 class="text-lg font-semibold">Seller list</h2>
                                </div>

                                <!-- Toggle Buttons -->
                                <div class="flex justify-between mb-6 space-x-3">
                                    <button
                                        class="px-5 py-2 rounded-full bg-bg-secondary text-text-white font-semibold">Instant
                                        delivery</button>
                                    <button
                                        class="px-5 py-2 rounded-full bg-bg-secondary/70 text-text-white font-semibold flex items-center gap-2">
                                        <span class="w-4 h-4 bg-green rounded-full"></span>
                                        <span>Online Seller</span>
                                    </button>
                                </div>

                                <!-- Dropdown Filters -->
                                <div class="space-y-4 h-[calc(100vh-360px)] overflow-y-auto">
                                    <div>
                                        <label class="text-sm text-gray-400">Short by</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">Fastest Delivery</option>
                                            <option class="bg-bg-primary">Top Selling</option>
                                            <option class="bg-bg-primary">Cheapest Price</option>
                                            <option class="bg-bg-primary">Recent Sales</option>
                                            <option class="bg-bg-primary">Highest Price</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Platform</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">ANDROID</option>
                                            <option class="bg-bg-primary">PS</option>
                                            <option class="bg-bg-primary">XBOX</option>
                                            <option class="bg-bg-primary">IOS</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Contain Rare Skin</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">OG</option>
                                            <option class="bg-bg-primary">Renegade Raider</option>
                                            <option class="bg-bg-primary">Travis Scott</option>
                                            <option class="bg-bg-primary">Black Knight</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Pickaxes</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">0-10</option>
                                            <option class="bg-bg-primary">11-30</option>
                                            <option class="bg-bg-primary">31-50</option>
                                            <option class="bg-bg-primary">51-100</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">V-Bucks</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">None</option>
                                            <option class="bg-bg-primary">1-1000</option>
                                            <option class="bg-bg-primary">1001-5000</option>
                                            <option class="bg-bg-primary">5001-10000</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Outfits</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">None</option>
                                            <option class="bg-bg-primary">Random</option>
                                            <option class="bg-bg-primary">1-10</option>
                                            <option class="bg-bg-primary">11-20</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm text-gray-400">Price (USD)</label>
                                        <select
                                            class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                            <option class="bg-bg-primary">≤ $5.00</option>
                                            <option class="bg-bg-primary">$5.00 - $15.00</option>
                                            <option class="bg-bg-primary">$15.00 - $50.00</option>
                                            <option class="bg-bg-primary">$50.00 - $100.00</option>
                                            <option class="bg-bg-primary">$100.00+</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-between gap-4 mt-8">
                                    <x-ui.button class="py-2" variant='secondary'>
                                        {{ __('Reset') }}
                                    </x-ui.button>
                                    {{-- <button
                                    class="w-[45%] py-2 bg-transparent border border-purple-400 text-purple-400 rounded-full font-medium">Reset</button>
                                <button
                                    class="w-[45%] py-2 bg-purple-600 hover:bg-purple-700 rounded-full font-medium">Confirm</button> --}}
                                    <x-ui.button class="py-2">
                                        {{ __('Confirm') }}
                                    </x-ui.button>
                                </div>
                                <div>

                                </div>
                                <div>

                                </div>
                            </div>
                        </div>


                        <div x-data="{
                            showAll: false,
                            limit: 5,
                            tags: [
                                'Robux',
                                'Steal A Brainrot',
                                'Grow A Garden',
                                'Hunty Zombie',
                                '99 Nights In The Forest',
                                'Prospecting',
                                'All Star Tower Defense X',
                                'Ink Game',
                                'Garden Tower Defense',
                                'Bubble Gum Simulator',
                                'Dead Rails',
                                'TYPE./ ISOUL',
                                'Hypershot',
                                'Build A Zoo',
                                'Gems',
                                'Rivals',
                                'MM2',
                                'Blox Fruit',
                                'Pet Simulator 99',
                                'Spin',
                                'Adopt Me'
                            ]
                        }" class="w-full">
                            <div class="flex flex-wrap gap-2 sm:gap-3 transition-all duration-300">
                                <!-- Mobile View -->
                                <template x-if="window.innerWidth < 640">
                                    <template x-for="(tag, index) in (showAll ? tags : tags.slice(0, limit))"
                                        :key="index">
                                        <span
                                            class="px-3 py-1 bg-bg-primary rounded text-sm hover:bg-bg-hover transition cursor-pointer text-text-white"
                                            x-text="tag" @click="$dispatch('tag-selected', tag)"></span>
                                    </template>
                                </template>

                                <!-- Desktop View -->
                                <template x-if="window.innerWidth >= 640">
                                    <template x-for="(tag, index) in tags" :key="index">
                                        <span
                                            class="px-3 py-1 bg-bg-primary rounded text-sm hover:bg-bg-hover transition cursor-pointer text-text-white"
                                            x-text="tag" @click="$dispatch('tag-selected', tag)"></span>
                                    </template>
                                </template>

                                <!-- Toggle Button (Mobile Only) -->
                                <button @click="showAll = !showAll"
                                    class="flex items-center gap-1 text-sm text-text-secondary hover:text-text-primary transition sm:hidden">
                                    <svg :class="{ 'rotate-180': showAll }"
                                        class="w-6 h-6 transition-transform duration-300" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>






                        <!-- Right Filters -->
                        <div class="gap-3 justify-end hidden md:flex">
                            <button
                                class="px-4 py-2 border border-green text-green rounded-full text-sm hover:bg-green hover:text-white transition">{{ __('● Online Seller') }}</button>

                            <button class="px-5 py-2 rounded-full bg-bg-primary text-text-white font-semibold">Instant
                                delivery</button>
                        </div>
                    </div>




                    <div class=" flex items-center justify-center ">
                        <!-- Product Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 w-full">
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                            <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
                        </div>
                    </div>


                    <div class="flex justify-end items-center space-x-3  p-4 m-10">
                        <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Previous') }}</button>

                        <button class="bg-zinc-600 text-white text-sm px-3 py-1 rounded">1</button>
                        <button class="text-text-primary text-sm hover:text-zinc-500">2</button>
                        <button class="text-text-primary text-sm hover:text-zinc-500">3</button>
                        <button class="text-text-primary text-sm hover:text-zinc-500">4</button>
                        <button class="text-text-primary text-sm hover:text-zinc-500">5</button>

                        <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Next') }}</button>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
