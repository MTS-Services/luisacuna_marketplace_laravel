<div>
    <section class="container mt-2">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />

        <div class="flex items-center gap-2 mt-8 text-lg font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-text-primary">
                {{ ucwords(str_replace('-', ' ', $gameSlug)) . '/ ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
            </h1>
            <span class="text-text-primary">></span>
            <span class="text-text-primary">{{ __('Shop') }}</span>
        </div>

       <div class="mt-8">
    <div class="flex items-center justify-between">
        <div>
            <span class="text-base font-semibold">{{ __('Select Filter') }}</span>
        </div>

        <div class="block md:hidden relative z-10" x-data="{ open: false }">
            <div @click="open = !open" class="cursor-pointer inline-block">
                <x-phosphor name="sort-ascending" variant="bold" class="fill-white w-6 h-6" />
            </div>

            <div x-show="open" @click.outside="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 p-2 bg-bg-primary rounded-2xl shadow-lg origin-top-right"
                style="display: none;">
                <a href="#" 
                    @click.prevent="$wire.set('sortDirection', 'asc'); open = false"
                    class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                    {{ __('Lowest To Highest') }}
                </a>
                <a href="#" 
                    @click.prevent="$wire.set('sortDirection', 'desc'); open = false"
                    class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                    {{ __('Highest to Lowest') }}
                </a>
            </div>
        </div>
    </div>
</div>

        <div class="mt-3 mb-6 flex items-center justify-between">
           

            <x-ui.custom-select wire-model="serach" :wire-live="true" class="w-full sm:w-70 rounded-full! bg-transparent! border! border-zinc-700!" label="Filter" >
                
                <x-ui.custom-option label="All" value="all" />

                @foreach($tags as $tag)
                     <x-ui.custom-option label="{{ $tag }}" value="{{ $tag }}" />

                @endforeach

            </x-ui.custom-select>


            <div class="w-auto! sm:w-70!   hidden md:flex ">
                <x-ui.custom-select wire-model="sortDirection" :wire-live="true"  class="pl-5! rounded-full! bg-transparent! border! border-zinc-700!" label="Sort By" >
            
                <x-ui.custom-option label="{{ __('Lowest to Highest') }}" value="{{ __('asc') }}" />

                <x-ui.custom-option label="{{ __('Highest to Lowest') }}" value="{{ __('desc') }}" />

            </x-ui.custom-select>
            </div>
        </div>

        <div class="mb-10">
            <span class="text-base font-semibold text-text-white">{{ __('About 21 results') }}</span>
        </div>
    </section>

    {{-- Main content --}}
    <section class="container">
        <div class="md:flex gap-6 h-auto" x-data={data:{}}>
            <div class="relative min-h-auto md:min-h-[40vh] ">
                <x-loading-animation :target="'selectedSort, selectedRegion, resetAllFilters'" :style="'list'" />
            </div>

            <div class="w-full md:w-[65%]">
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4 content-start">
                    @forelse ($datas as $data)
                        <div wire:loading.class="opacity-0" wire:target="selectedSort, selectedRegion, resetAllFilters"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" wire:click="selectItem('{{ encrypt($data->id) }}')"
                            @click="data = { 
                                name: {{ Js::from(substr($data->name, 0, 20)) }},
                                quantity: {{ $data->quantity }},
                                price: {{ $data->quantity * $data->price }},
                                logo: {{ Js::from(storage_url($game->logo)) }},
                                delivery_timeline: {{ Js::from($data?->delivery_timeline ?? 'N/A') }}
                            }"
                            class="bg-bg-primary dark:bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300 cursor-pointer">

                            <div class="flex items-center justify-between">
                                <div class="w-6 h-6">
                                    <img src="{{ storage_url($game?->logo) }}" alt="{{ $game->name }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    @if($game?->tags && $game->tags->isNotEmpty())
                                        <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl inline-block text-xs">
                                            <x-phosphor name="fire" variant="regular" class="inline-block fill-white" />
                                            {{ $game->tags->random()->name }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <h3 class="text-base font-semibold text-text-white mt-4">{{ $data->quantity }}</h3>
                            <p class="text-xs text-text-white mt-2">{{ Str::limit($data->name, 20) }}</p>
                            <span class="block text-base font-semibold text-pink-500 mt-4">
                                ${{ number_format($data->quantity * $data->price, 2) }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <h2 class="text-text-white">No Data Found</h2>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5">
                    <x-frontend.pagination-ui :pagination="$pagination" />
                </div>
            </div>

            <div class="w-full md:w-[35%] mt-4 md:mt-0">
                <div class="bg-bg-primary dark:bg-bg-secondary rounded-2xl py-7 px-6">
                    <div class="flex items-center gap-1 mb-8">
                        <div class="w-8 h-8">
                            <img :src="data.logo" alt="" class="w-full h-full object-cover">
                        </div>
                        <p x-text="data.name"></p>
                    </div>
                    <div class="flex items-center justify-between py-3 border-t border-b  border-zinc-500 w-full">
                        <p class="text-base text-text-white"> {{ __('Delivery Timeline') }}</p>
                        <p class="text-base text-text-white font-semibold" x-text="data.delivery_timeline"></p>
                    </div>
                    <span class="w-full inline-block"></span>
                    <div class="mt-4">
                        @auth('web')
                            <form action="" wire:submit="submit">
                                <x-ui.button wire:click="submit" class="py-2!">
                                    <span class="text-white group-hover:text-zinc-500">PEN</span>
                                    <span x-text="data.price" class="text-white group-hover:text-zinc-500"></span>
                                    {{ ' Buy Now' }}</x-ui.button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" wire:navigate
                                class="bg-zinc-500 px-4 md:px-6 py-2! md:py-4 text-text-btn-primary hover:text-text-btn-secondary hover:bg-zinc-50 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500 font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 transition duration-150 ease-in-out group text-nowrap cursor-pointer">
                                <span class="text-white group-hover:text-zinc-500">PEN</span>
                                <span x-text="data.price" class="text-white group-hover:text-zinc-500"></span>
                                {{ ' Buy Now' }}
                            </a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-2 mt-8">
                        <flux:icon name="shield-check" class="w-6 h-6" />
                        <p class="text-text-white text-base font-semibold">{{ __('Money-back Guarantee') }}</p>
                        <span class="text-xs text-text-primary dark:text-zinc-200/60">{{ __('Protected by TradeShield') }}</span>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <flux:icon name="bolt" class="w-6 h-6" />
                        <p class="text-text-white text-base font-semibold">{{ __('Fast Checkout Options') }}</p>
                        <div class="flex items-center gap-2 w-11 h-7">
                            <img src="{{ asset('assets/images/gift_cards/google.png') }}" alt=""
                                class="w-full h-full">
                            <img src="{{ asset('assets/images/gift_cards/apple.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-6 h-6">
                            <rect fill="none" />
                            <path d="M224,200v8a32,32,0,0,1-32,32H136" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <path
                                d="M224,128H192a16,16,0,0,0-16,16v40a16,16,0,0,0,16,16h32V128a96,96,0,1,0-192,0v56a16,16,0,0,0,16,16H64a16,16,0,0,0,16-16V144a16,16,0,0,0-16-16H32"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <p class="text-text-white text-base font-semibold">{{ __('24/7 Live Support') }}</p>
                        <span class="text-xs text-text-primary dark:text-zinc-200/60">{{ __('We\'re always here to help') }}</span>
                    </div>
                </div>

                <div class="mt-6 bg-bg-primary dark:bg-bg-secondary rounded-2xl py-7 px-6">
                    <h3 class="text-text-white text-base font-semibold mb-2">{{ __('Delivery instructions') }}</h3>
                    <div class="flex gap-2">
                        <span class="text-sm text-text-white">{{ __('Welcome') }}</span>
                        <span class="inline-block w-px h-3 bg-zinc-500"></span>
                        <span class="text-sm text-text-white">{{ __('Why choose us') }}</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-text-white">{{ __('1. V-BUCKS are safe to hold and guaranteed!') }}</p>
                        <p class="text-sm text-text-white mt-2 mb-4">{{ __('2. Fast replies and delivery.') }}</p>
                        <a href="#" class="text-base font-semibold text-pink-500">{{ __('See all') }}</a>
                    </div>
                    <span class="border-t-2 border-zinc-500 w-full inline-block mt-8"></span>

                    <div class="flex gap-4 items-center mt-4">
                        <div class="w-14 h-14">
                            <img src="{{ asset('assets/images/gift_cards/profile.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div>
                            <h2 class="text-text-white font-semibold text-base">{{ __('Devon Lane') }}</h2>
                            <div class="flex items-center gap-2">
                                <x-phosphor name="thumbs-up" variant="solid" class="fill-zinc-600" />
                                <span class="text-xs text-text-white">99.3%</span>
                                <span class="w-px h-4 bg-zinc-200"></span>
                                <span class="text-xs text-text-white">{{ __('2434 reviews') }}</span>
                                <span class="w-px h-4 bg-zinc-200"></span>
                                <span class="text-xs text-text-white">{{ __('1642 Sold') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Seller list section --}}
    <section class="container mt-32">
        <div class="mb-10">
            <h2 class="text-text-white font-semibold text-40px">{{ __('Other sellers (84)') }}</h2>
        </div>
        <div class="mt-10 mb-6 flex items-center justify-between">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                <option value="">{{ __('Recommended') }}</option>
                <option value="completed">{{ __('Completed') }}</option>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="processing">{{ __('Processing') }}</option>
            </x-ui.select>
            <button
                class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green hover:text-white transition">
                {{ __('● Online Seller') }}
            </button>
        </div>

        <div class="min-w-full text-left border-collapse">
            <div class="flex justify-between text-text-white text-sm">
                <div class="px-4 py-3">{{ __('All Sellers (8)') }}</div>
                <div class="px-4 py-3 hidden md:block">{{ __('Delivery Time') }}</div>
                <div class="px-4 py-3 hidden md:block">{{ __('Delivery Method') }}</div>
                <div class="px-4 py-3 hidden md:block">{{ __('Stock') }}</div>
                <div class="px-4 py-3 hidden md:block">{{ __('Price') }}</div>
            </div>

            <div class="py-7 space-y-7">
                @forelse ($lists=[1,2,3,4,5,6] as $item)
                    <div
                        class="flex justify-between items-center bg-bg-primary dark:bg-bg-secondary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3 flex items-center gap-4">
                            <div class="w-10 h-10">
                                <img src="{{ asset('assets/images/gift_cards/seller.png') }}" alt=""
                                    class="w-full h-full rounded-full">
                            </div>
                            <div>
                                <h3 class="text-text-white text-base font-semibold">{{ __('Devon Lane') }}</h3>
                                <div class="flex items-center gap-1">
                                    <x-phosphor name="thumbs-up" variant="solid"
                                        class="fill-zinc-600 inline-block" />
                                    <span class="text-xs text-text-white">99.3%</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>
                @empty
                    <h2>No Data found</h2>
                @endforelse
            </div>
        </div>
    </section>
</div>
