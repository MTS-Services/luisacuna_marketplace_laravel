@props([
    'gameSlug' => '',
    'categorySlug' => '',
    'datas' => [],
    'game' => [],
])
<section>
    <div class="container ">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />
        <div class="max-w-7xl mx-auto lg:px-8 lg:py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-md font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-blue-100 text-text-primary">
                    {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                </h1>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">{{ __('Shop') }}</span>
            </div>

            <!-- Filters Section -->
            <div class="mb-8 space-y-4">
                <div class="flex gap-4 justify-between items-center md:justify-start relative" x-data={filter:false}>
                    <div class="flex-1 w-auto md:min-w-64">
                        <div class="relative">
                            <input type="text" placeholder="Search" wire:model.live.debounce.500ms="search"
                                wire:change="serachFilter"
                                class="w-full bg-bg-primary border border-zinc-700 rounded px-4 py-2 pl-10 focus:outline-none focus:border-zinc-500">
                            <span class="absolute left-3 top-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                            
                            <!-- Loading Spinner -->
                            <span class="absolute right-3 top-2.5" wire:loading wire:target="search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters">
                                <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                  

                <div class="flex-nowrap gap-5 relative hidden md:flex" x-data="{ open: false, selectedOption: '' }" @click.away="open = false">
                    <div class="flex justify-between border border-zinc-700 bg-bg-primary items-center w-50 px-2 py-2 rounded cursor-pointer"
                        @click="open = !open">
                        <span x-text="selectedOption || '{{ __('Platform') }}'"></span>
                        <flux:icon name="chevron-down" class="w-5 h-5" />
                    </div>
                    
                    <div class="absolute top-[110%] left-0 w-50! rounded bg-bg-primary border border-zinc-700 z-20"
                        x-show="open"
                        x-transition
                        @click.stop>
                        <ol class="list">
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 first:rounded-t last:rounded-b"
                                data-value=""
                                @click="selectedOption = '{{ __('Platform') }}'; $wire.selectedPlatform = ''; open = false; $wire.call('serachFilter')">
                                {{ __('Platform') }}
                            </li>
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 last:rounded-b"
                                data-value="device1"
                                @click="selectedOption = 'Device 1'; $wire.selectedPlatform = 'device1'; open = false; $wire.call('serachFilter')">
                                Device 1
                            </li>
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 last:rounded-b"
                                data-value="device2"
                                @click="selectedOption = 'Device 2'; $wire.selectedPlatform = 'device2'; open = false; $wire.call('serachFilter')">
                                Device 2
                            </li>
                        </ol>
                    </div>
                </div>


                <div class="flex-nowrap gap-5 relative hidden md:flex" x-data="{ open: false, selectedMin: '', selectedMax: '' }" @click.away="open = false">
                    <div class="price-input flex justify-between border border-zinc-700 bg-bg-primary items-center w-50 px-2 py-2 rounded cursor-pointer"
                        @click="open = !open">
                        <span x-text="selectedMin && selectedMax ? `$${selectedMin} - $${selectedMax}` : 'Price'"></span>
                        <flux:icon name="chevron-down" class="w-5 h-5" />
                    </div>
                    
                    <div class="price-dropdown absolute top-[110%] left-0 w-100! rounded bg-bg-primary border border-zinc-700 z-20 px-5 py-5"
                        x-show="open"
                        x-transition
                        @click.stop>
                        <div class="flex justify-center gap-2">
                            <x-ui.input type="text" placeholder="Min" wire:model="minPrice" class="border-zinc-700" x-model="selectedMin"/>
                            <x-ui.input type="text" placeholder="Max" wire:model="maxPrice" class="border-zinc-700" x-model="selectedMax"/>
                            <x-ui.button class="py-2! px-3! w-auto! rounded! hidden md:flex bg-transparent!"
                                :variant="'primary'" 
                                @click="selectedMin = ''; selectedMax = ''; $wire.minPrice = ''; $wire.maxPrice = ''; $wire.call('serachFilter')">
                            <flux:icon name="trash" class="w-5 h-5" />
                            </x-ui.button>
                        </div>
                        <ol class="list pt-2.5">
                            <li class="py-3 px-2 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 rounded"
                                data-min="100" 
                                data-max="500"
                                @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; $wire.minPrice = $el.dataset.min; $wire.maxPrice = $el.dataset.max; open = false; $wire.call('serachFilter')">
                                100 to 500
                            </li>
                            <li class="py-3 px-2 text-text-primary mt-2 bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 rounded"
                                data-min="500" 
                                data-max="1000"
                                @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; $wire.minPrice = $el.dataset.min; $wire.maxPrice = $el.dataset.max; open = false; $wire.call('serachFilter')">
                                500 to 1000
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="flex-nowrap gap-5 relative hidden md:flex" x-data="{ open: false, selectedOption: '' }" @click.away="open = false">
                    <div class="flex justify-between border border-zinc-700 bg-bg-primary items-center w-50 px-2 py-2 rounded cursor-pointer"
                        @click="open = !open">
                        <span x-text="selectedOption || '{{ __('Select Delivery Time') }}'"></span>
                        <flux:icon name="chevron-down" class="w-5 h-5" />
                    </div>
                    
                    <div class="absolute top-[110%] left-0 w-50! rounded bg-bg-primary border border-zinc-700 z-20"
                        x-show="open"
                        x-transition
                        @click.stop>
                        <ol class="list">
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 first:rounded-t last:rounded-b"
                                data-value=""
                                @click="selectedOption = '{{ __('Select Delivery Time') }}'; $wire.selectedDeliveryTime = ''; open = false; $wire.call('serachFilter')">
                                {{ __('Select Delivery Time') }}
                            </li>
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 last:rounded-b"
                                data-value="instant"
                                @click="selectedOption = '{{ __('Instant Delivery') }}'; $wire.selectedDeliveryTime = 'instant'; open = false; $wire.call('serachFilter')">
                                {{ __('Instant Delivery') }}
                            </li>
                            <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-zinc-700 last:rounded-b"
                                data-value="week"
                                @click="selectedOption = '{{ __('In a Week') }}'; $wire.selectedDeliveryTime = 'week'; open = false; $wire.call('serachFilter')">
                                {{ __('In a Week') }}
                            </li>
                        </ol>
                    </div>
                </div>


                    <x-ui.button class="py-2! px-3! w-auto! rounded!  hidden md:flex bg-transparent!"
                        :variant="'primary'" wire:click="resetAllFilters">
                        {{ __('Clear All') }}
                    </x-ui.button>
                    <button @click="filter = !filter"
                        class="flex items-center gap-2 border border-zinc-500 rounded px-5 py-2 hover:bg-zinc-600  transition md:hidden group"
                        :class="{ 'bg-zinc-600': filter }">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 group-hover:stroke-white transition-color duration-300"
                            :class="{ 'stroke-white': filter }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                        </svg>
                        <span class="group-hover:text-white transition-color duration-300"
                            :class="{ 'text-white': filter }">{{ __('Filter') }}</span>
                    </button>
{{-- This filter for mobile Menu --}}
                    <div x-show="filter"
                        class="glass-card bg-bg-primary/50 text-text-white p-6 rounded-lg w-full absolute top-16 right-0 z-10 md:hidden">
                        <!-- Header -->
                        <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4">
                            <h2 class="text-lg font-semibold">Seller list</h2>
                        </div>

                        <!-- Toggle Buttons -->
                        <div class="flex justify-between mb-6 space-x-3">
                            <button class="px-5 py-2 rounded-full bg-bg-secondary text-text-white font-semibold">Instant
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
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">Fastest Delivery</option>
                                    <option class="bg-bg-primary">Top Selling</option>
                                    <option class="bg-bg-primary">Cheapest Price</option>
                                    <option class="bg-bg-primary">Recent Sales</option>
                                    <option class="bg-bg-primary">Highest Price</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Platform</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">ANDROID</option>
                                    <option class="bg-bg-primary">PS</option>
                                    <option class="bg-bg-primary">XBOX</option>
                                    <option class="bg-bg-primary">IOS</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Contain Rare Skin</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">OG</option>
                                    <option class="bg-bg-primary">Renegade Raider</option>
                                    <option class="bg-bg-primary">Travis Scott</option>
                                    <option class="bg-bg-primary">Black Knight</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Pickaxes</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">0-10</option>
                                    <option class="bg-bg-primary">11-30</option>
                                    <option class="bg-bg-primary">31-50</option>
                                    <option class="bg-bg-primary">51-100</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">V-Bucks</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">None</option>
                                    <option class="bg-bg-primary">1-1000</option>
                                    <option class="bg-bg-primary">1001-5000</option>
                                    <option class="bg-bg-primary">5001-10000</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Outfits</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
                                    <option class="bg-bg-primary">None</option>
                                    <option class="bg-bg-primary">Random</option>
                                    <option class="bg-bg-primary">1-10</option>
                                    <option class="bg-bg-primary">11-20</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Price (USD)</label>
                                <select class="w-full bg-transparent border-b border-zinc-500 py-2 focus:outline-none">
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
                            <x-ui.button class="py-2">
                                {{ __('Confirm') }}
                            </x-ui.button>
                        </div>
                    </div>
{{-- End of Filter --}}
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
                                    x-text="tag" @click="$wire.tagSelected(tag)"></span>
                            </template>
                        </template>

                        <!-- Desktop View -->
                        <template x-if="window.innerWidth >= 640">
                            <template x-for="(tag, index) in tags" :key="index">
                                <span
                                    class="px-3 py-1 bg-bg-primary rounded text-sm hover:bg-bg-hover transition cursor-pointer text-text-white"
                                    x-text="tag" @click="$wire.tagSelected(tag)"></span>
                            </template>
                        </template>

                        <!-- Toggle Button (Mobile Only) -->
                        <button @click="showAll = !showAll"
                            class="flex items-center gap-1 text-sm text-text-secondary hover:text-text-primary transition sm:hidden">
                            <svg :class="{ 'rotate-180': showAll }" class="w-6 h-6 transition-transform duration-300"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right Filters -->
                <div class="gap-3 justify-end hidden md:flex">
                    
                    <button
                        class="px-4 py-2 border border-green text-green rounded-full text-sm hover:bg-green hover:text-white transition">{{ __('● Online Seller') }}
                    </button>

                
                </div>
            </div>


            <!-- Products Grid Section -->
         <div class="relative min-h-[40vh]">
            <!-- Skeleton Loading -->
                <x-loading-animation 
                      :target="'search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters'" 
                      />
            <!-- Actual Product Cards -->
            <div wire:loading.class="opacity-0"
                wire:target="search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters"
                x-transition:enter="transition ease-out duration-300" 
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" 
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 w-full">

                @foreach ($datas as $item)
                    <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" :data="$item" :game="$game" />
                @endforeach

            </div>
        </div>

            <!-- Pagination (Outside of loading container) -->
            <div class="flex justify-end items-center space-x-3 p-4 mt-10">
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


@push("script")
    <script>
        function updatePriceValue(event) {
            console.log(event.target.value);
            
        }
    </script>
@endpush