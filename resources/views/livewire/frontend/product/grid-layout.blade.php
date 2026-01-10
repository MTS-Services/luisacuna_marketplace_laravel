<section class="pb-10">
    <div class="container ">

        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />



        <div class="max-w-7xl mx-auto lg:px-8 lg:py-10">
            <!-- Breadcrumb -->

            {{-- <livewire:frontend.partials.breadcrumb :gameSlug="$gameSlug" :categorySlug="$categorySlug" /> --}}

            <!-- Filters Section -->
            <div class="mb-8 space-y-4">
                <div class="flex gap-4 flex-col md:flex-row justify-between items-center md:justify-start relative"
                    x-data={filter:false}>


                    {{-- Search --}}
                    <div class="flex-1 w-full md:min-w-64">
                        <div class="relative">
                            <input type="text" placeholder="Search" wire:model.live="search"
                                class="w-full bg-bg-transparent rounded-full border border-zinc-700 px-4 py-2 pl-10 focus:outline-none focus:border-zinc-500">
                            <span class="absolute left-3 top-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>

                            <!-- Loading Spinner -->
                            <span class="absolute right-3 top-2.5" wire:loading
                                wire:target="search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters">
                                <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>


                    {{-- Platforms --}}


                    <div class="w-full md:min-w-64">
                        <x-ui.custom-select wire-model="platform_id" :wire-live="true"
                            class="rounded-full bg-transparent" label="Platforms">

                            <x-ui.custom-option label="All Platforms" value="" />

                            @foreach ($platforms as $platform)
                                <x-ui.custom-option label="{{ $platform->name }}" value="{{ $platform->id }}" />
                            @endforeach
                        </x-ui.custom-select>
                    </div>


                    {{-- Price Filters --}}
                    <div class="flex-nowrap gap-5 relative hidden md:flex" x-data="{
                        open: false,
                        selectedMin: @entangle('min_price').live,
                        selectedMax: @entangle('max_price').live
                    }"
                        @click.away="open = false">

                        <div class="price-input flex justify-between border border-zinc-700 bg-bg-transparent items-center w-50 px-3 py-2 rounded-full cursor-pointer"
                            @click="open = !open">
                            <span
                                x-text="selectedMin && selectedMax ? `$${selectedMin} - $${selectedMax}` : 'Price'"></span>
                            <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                                x-bind:class="open ? 'rotate-180' : ''" />
                        </div>

                        <div class="price-dropdown absolute top-[110%] left-0 w-100 rounded bg-bg-primary border border-zinc-700 z-20 overflow-hidden origin-top"
                            x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 scale-y-0"
                            x-transition:enter-end="opacity-100 scale-y-100"
                            x-transition:leave="transition ease-in duration-200 transform"
                            x-transition:leave-start="opacity-100 scale-y-100"
                            x-transition:leave-end="opacity-0 scale-y-0" @click.stop>
                            <div class="px-5 py-5">
                                <div class="flex justify-center gap-2">
                                    <div class="relative flex-1">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-text-primary pointer-events-none">$</span>
                                        <x-ui.input type="text" placeholder="Min" class="border-zinc-700 pl-7"
                                            x-model="selectedMin" />
                                    </div>
                                    <div class="relative flex-1">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-text-primary pointer-events-none">$</span>
                                        <x-ui.input type="text" placeholder="Max" class="border-zinc-700 pl-7"
                                            x-model="selectedMax" />
                                    </div>
                                    <x-ui.button class="py-2! px-3! w-auto! rounded! hidden md:flex bg-transparent!"
                                        :variant="'primary'" @click="selectedMin = ''; selectedMax = '';">
                                        <flux:icon name="trash" class="w-5 h-5" />
                                    </x-ui.button>
                                </div>
                                <ol class="list pt-2.5 space-y-2">

                                    <li class="py-3 px-2 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                        data-min="0" data-max="100"
                                        @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; open = false;">
                                        $0 to $100
                                    </li>

                                    <li class="py-3 px-2 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                        data-min="101" data-max="1000"
                                        @click="selectedMin = $el.dataset.min; selectedMax = $el.dataset.max; open = false;">
                                        $101 to $1000
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>


                    {{-- Dellivery Timeline --}}

                    <div class="w-full md:min-w-64">
                        <x-ui.custom-select wire-model="delivery_timeline" :wire-live="true"
                            class="rounded-full bg-transparent" label="Delivery Timeline">

                            <x-ui.custom-option label="All Timeline" value="" />

                            @foreach ($delivery_timelines as $delivery_timeline)
                                <x-ui.custom-option label="{{ $delivery_timeline['label'] }}"
                                    value="{{ $delivery_timeline['value'] }}" />
                            @endforeach
                        </x-ui.custom-select>
                    </div>



                    <x-ui.button
                        class="w-full! md:w-auto! py-2! px-3!  rounded-full  md:flex bg-transparent! text-text-primary! font-normal "
                        :variant="'primary'" wire:click="resetAllFilters">
                        {{ __('Clear All') }}
                    </x-ui.button>

                    {{-- <button @click="filter = !filter"
                        class="flex items-center gap-2 border border-zinc-500 rounded-full px-5 py-2 hover:bg-zinc-600  transition md:hidden group"
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
                    </button> --}}
                    {{-- This filter for mobile Menu --}}

                    <x-currency.mobile-filter />

                    {{-- End of Filter --}}

                </div>

                <div x-data="{
                    showAll: false,
                    limit: 5,
                    tags: @js($tags),
                    search: @entangle('search').live
                }" class="w-full">
                    <div class="flex flex-wrap gap-2 sm:gap-3 transition-all duration-300">
                        <!-- All Tags (Desktop shows all, Mobile shows limited) -->
                        <template
                            x-for="(tag, index) in (window.innerWidth < 640 ? (showAll ? tags : tags.slice(0, limit)) : tags)"
                            :key="index">
                            <span
                                class="px-3 py-1 bg-bg-primary dark:bg-bg-info rounded text-sm hover:bg-bg-hover transition cursor-pointer text-text-white"
                                x-text="tag" @click="search = tag">
                            </span>
                        </template>

                        <!-- Toggle Button (Mobile Only - Shows when tags exceed limit) -->
                        <template x-if="window.innerWidth < 640 && tags.length > limit">
                            <button @click="showAll = !showAll"
                                class="px-3 py-1 bg-bg-secondary dark:bg-bg-secondary rounded text-sm hover:bg-bg-hover transition cursor-pointer text-text-primary flex items-center gap-1">
                                <span x-text="showAll ? 'Show Less' : 'Show More'"></span>
                                <svg :class="{ 'rotate-180': showAll }"
                                    class="w-4 h-4 transition-transform duration-300" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Recommendation -->
                <div class="gap-3 justify-end hidden md:flex">

                    <button
                        class="px-4 py-2 border border-green text-green rounded-full text-sm hover:bg-green hover:text-white transition">{{ __('● Online Seller') }}
                    </button>

                    <div class="flex-nowrap gap-5 relative hidden md:flex" x-data="{ open: false, selectedOption: '', selectedValue: '' }"
                        @click.away="open = false">

                        <!-- Hidden Input Field -->
                        <input type="hidden" name="recommendation" x-model="selectedValue">

                        <div class="flex justify-between rounded-full border border-zinc-700 bg-bg-transparent items-center w-50 px-3 py-2 cursor-pointer"
                            @click="open = !open">
                            <span x-text="selectedOption || '{{ __('Recomendation') }}'"></span>
                            <flux:icon name="chevron-down" class="w-5 h-5 transition-transform duration-200"
                                x-bind:class="open ? 'rotate-180' : ''" />
                        </div>

                        <div class="absolute top-[110%] left-0 w-50 rounded bg-bg-primary border border-zinc-700 z-20 overflow-hidden origin-top"
                            x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 scale-y-0"
                            x-transition:enter-end="opacity-100 scale-y-100"
                            x-transition:leave="transition ease-in duration-200 transform"
                            x-transition:leave-start="opacity-100 scale-y-100"
                            x-transition:leave-end="opacity-0 scale-y-0" @click.stop>
                            <div class="px-5 py-5">
                                <ol class="list space-y-2">
                                    <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                        @click="selectedOption = '{{ __('Platform') }}'; selectedValue = ''; $wire.selectedPlatform = ''; open = false;">
                                        {{ __('Platform') }}
                                    </li>
                                    <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                        @click="selectedOption = 'Device 1'; selectedValue = 'device1'; $wire.selectedPlatform = 'device1'; open = false; ">
                                        Device 1
                                    </li>
                                    <li class="py-3 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150"
                                        @click="selectedOption = 'Device 2'; selectedValue = 'device2'; $wire.selectedPlatform = 'device2'; open = false; ">
                                        Device 2
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Products Grid Section -->
            <div class="relative min-h-[40vh]">
                <!-- Skeleton Loading -->
                <x-loading-animation :target="'search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters'" />
                <!-- Actual Product Cards -->
                <div wire:loading.class="opacity-0"
                    wire:target="search, tagSelected, selectedDevice, selectedAccountType,  selectedPrice, selectedDeliveryTime , resetAllFilters"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 w-full">

                    @forelse ($datas as $item)
                        <x-ui.shop-card :gameSlug="$gameSlug" :categorySlug="$categorySlug" :data="$item" :game="$game" />
                    @empty
                        <div class="col-span-full ">
                            <x-ui.empty-card />
                        </div>
                    @endforelse

                </div>
            </div>


            <x-frontend.pagination-ui :pagination="$pagination" />

        </div>
    </div>
</section>
