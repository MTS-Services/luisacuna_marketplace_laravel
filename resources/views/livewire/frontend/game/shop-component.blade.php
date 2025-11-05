<main class="mx-auto">
    @if ($categorySlug == 'gift-cards' || $categorySlug == 'top-ups')
        <section class="container mt-2">
            <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" />

            <div class="flex items-center gap-2 mt-8 text-lg font-semibold">
                <div class="w-4 h-4">
                    <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
                </div>
                <h1 class="text-blue-100 text-text-primary">
                    {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
                </h1>
                <span class="text-text-primary">></span>
                <span class="text-text-primary">{{ __('Shop') }}</span>
            </div>

            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-base font-semibold">{{ __('Select region') }}</span>
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
                                class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                                {{ __('Lowest To Highest') }}
                            </a>
                            <a href="#"
                                class="text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg transition-colors duration-150">
                                {{ __('Highest To Lowest') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 mb-6 flex items-center justify-between">
                <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                    <option value="">{{ __('Global') }}</option>
                    <option value="completed">{{ __('Completed') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="processing">{{ __('Processing') }}</option>
                </x-ui.select>

                <x-ui.select id="status-select" class="py-0.5! w-auto! pl-5! hidden md:flex rounded-full!">
                    <option value="">{{ __('Sort by') }}</option>
                    <option value="">{{ __('Lowest To Highest') }}</option>
                    <option value="">{{ __('Highest To Lowest') }}</option>
                </x-ui.select>
            </div>

            <div class="mb-10">
                <span class="text-base font-semibold text-text-white">
                    {{ __('About 21 results') }}
                </span>
            </div>
        </section>

        {{-- main --}}
        <section class="container">
            <div class="md:flex gap-6 h-auto">
                <div class="w-full md:w-[65%] grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">
                    {{-- Example item --}}
                    <div
                        class="bg-bg-primary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <a href="" class="bg-zinc-500 text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular" class="inline-block fill-white" />
                                    {{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$40.16</span>
                    </div>
                    {{-- Repeat similar blocks --}}
                </div>

                {{-- Sidebar --}}
                <div class="w-full md:w-[35%] mt-4 md:mt-0">
                    <div class="bg-bg-primary rounded-2xl py-7 px-6">
                        <div class="flex items-center gap-1 mb-8">
                            <div class="w-8 h-8">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks1.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <p>{{ __('IOOOV-Bucks') }}</p>
                        </div>

                        <span class="border-t-2 border-zinc-500 w-full inline-block"></span>

                        <div class="flex items-center justify-between py-3">
                            <p class="text-base text-text-white">{{ __('IOOOV-Bucks') }}</p>
                            <p class="text-base text-text-white font-semibold">{{ __('15 min') }}</p>
                        </div>

                        <span class="border-t-2 border-zinc-500 w-full inline-block"></span>

                        <div class="mt-4">
                            <a href="{{ route('game.checkout', ['orderId' => 12345]) }}">
                                <x-ui.button class="">$76.28 | {{ __('Buy now') }}</x-ui.button>
                            </a>
                        </div>

                        <div class="flex items-center gap-2 mt-8">
                            <flux:icon name="shield-check" class="w-6 h-6 50" />
                            <p class="text-text-white text-base font-semibold">{{ __('Money-back Guarantee') }}</p>
                            <span class="text-xs text-zinc-200/60">{{ __('Protected by TradeShield') }}</span>
                        </div>

                        <div class="flex items-center gap-2 mt-4">
                            <flux:icon name="bolt" class="w-6 h-6 50" />
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
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="16" />
                            </svg>
                            <p class="text-text-white text-base font-semibold">{{ __('24/7 Live Support') }}</p>
                            <span class="text-xs text-zinc-200/60">{{ __('We\'re always here to help') }}</span>
                        </div>
                    </div>

                    {{-- Delivery instructions --}}
                    <div class="mt-6 bg-bg-primary rounded-2xl py-7 px-6">
                        <h3 class="text-text-white text-base font-semibold mb-2">{{ __('Delivery instructions') }}
                        </h3>
                        <div class="flex gap-2">
                            <span class="text-sm text-text-white">{{ __('Welcome') }}</span>
                            <span class="inline-block w-px h-3 bg-zinc-500"></span>
                            <span class="text-sm text-text-white">{{ __('Why choose us') }}</span>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-text-white">1. {{ __('V-BUCKS are safe to hold and guaranteed!') }}
                            </p>
                            <p class="text-sm text-text-white mt-2 mb-4">2. {{ __('Fast replies and delivery.') }}</p>
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

        {{-- seller list section --}}
        <section class="container mt-32">
            <div class="mb-10">
                <h2 class="text-text-white font-semibold trxt-40px">{{ __('Other sellers (84)') }}</h2>
            </div>
            <div class="mt-10 mb-6 flex items-center justify-between">
                <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70 rounded-full!">
                    <option value="">{{ __('Recommended') }}</option>
                    <option value="completed">{{ __('Completed') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="processing">{{ __('Processing') }}</option>
                </x-ui.select>
                <button
                    class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">
                    ● {{ __('Online Seller') }}
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

                {{-- Repeat sellers --}}
                <div class="py-7 space-y-7">
                    <div
                        class="flex justify-between items-center bg-bg-primary py-2.5 px-6 rounded-2xl hover:bg-zinc-800 transition-all duration-300">
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-4">
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
                        </div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">{{ __('Instants') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">
                            {{ __('Login Top UP') }}</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold hidden md:block">$77.07</div>
                        <div class="px-4 py-3 text-text-white text-base font-semibold">$77.07</div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section>
            <div class="container">
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
                        <span class="text-text-primary">></span>
                        <span class="text-text-primary">{{ __('Shop') }}</span>
                    </div>

                    <!-- Filters Section -->
                    <div class="mb-8 space-y-4">
                        <div class="flex gap-4 flex-wrap">
                            <div class="flex-1 min-w-64">
                                <div class="relative">
                                    <input type="text" placeholder="{{ __('Search') }}"
                                        class="w-full bg-bg-primary border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                                    <span class="absolute left-3 top-2.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Device') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Account type') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Price') }}</option>
                            </x-ui.select>
                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('Select Delivery Time') }}</option>
                            </x-ui.select>
                            <button
                                class="text-text-primary hover:text-white transition">{{ __('Clear all') }}</button>
                        </div>

                        <!-- Game Tags -->
                        <div class="flex gap-2 flex-wrap">
                            @foreach (['Robux', 'Steel A Brainrot', 'Grow A Garden', 'Hunty Zombie', '99 Nights In The Forest', 'Prospecting', 'All Star Tower Defense X', 'Ink Game', 'Garden Tower Defense', 'Bubble Gum Simulator', 'Dead Rails', 'TYPE./ ISOUL', 'Hypershot', 'Build A Zoo', 'Gems', 'Rivals', 'MM2', 'Blox Fruit', 'Pet Simulator 99', 'Spin', 'Adopt Me'] as $tag)
                                <span
                                    class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">
                                    {{ __($tag) }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Right Filters -->
                        <div class="flex gap-3 justify-end">
                            <button
                                class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">
                                ● {{ __('Online Seller') }}
                            </button>

                            <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                                <option value="">{{ __('All statuses') }}</option>
                                <option value="completed">{{ __('Completed') }}</option>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="processing">{{ __('Processing') }}</option>
                            </x-ui.select>
                        </div>
                    </div>

                    <!-- Product Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ([['name' => 'Victoria'], ['name' => 'Colleen'], ['name' => 'Esther'], ['name' => 'Shane'], ['name' => 'Arthur'], ['name' => 'Kristin'], ['name' => 'Angel'], ['name' => 'Marjorie'], ['name' => 'Soham']] as $seller)
                            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                                wire:navigate>
                                <div
                                    class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                                    <h3 class="text-lg font-medium mb-3">
                                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                                    </h3>
                                    <div class="flex gap-2 text-sm text-text-secondary py-2">
                                        <span
                                            class="flex items-center gap-1 px-0 py-1 bg-slate-800/60 rounded-full text-sm text-white">
                                            <img src="{{ asset('assets/images/light.png') }}" alt="">
                                            {{ __('Pc') }}
                                        </span>
                                        <span
                                            class="flex items-center gap-1 px-0 py-1 bg-slate-800/60 rounded-full text-sm text-white">
                                            {{ __('Pickaxes: 0-10') }}
                                        </span>
                                        <span
                                            class="flex items-center gap-1 px-0 py-1 bg-slate-800/60 rounded-full text-sm text-white">
                                            {{ __('Outfits: None') }}
                                        </span>
                                    </div>
                                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
                                        <span
                                            class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                                        <span
                                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">
                                            <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                            {{ __('Instants') }}
                                        </span>
                                    </div>
                                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                                        <img src="{{ asset('assets/images/' . $seller['name'] . '.png') }}"
                                            alt="{{ $seller['name'] }}" class="w-10 h-10 rounded-full">
                                        <div>
                                            <p class="font-semibold text-text-white">{{ __($seller['name']) }}</p>
                                            <p class="text-sm text-text-secondary">
                                                <img class="inline mr-2"
                                                    src="{{ asset('assets/images/thumb up filled.png') }}"
                                                    alt="">
                                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-end items-center space-x-3 p-4 m-10">
                        <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Previous') }}</button>

                        <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">2</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">3</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">4</button>
                        <button class="text-text-primary text-sm hover:text-purple-500">5</button>

                        <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Next') }}</button>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
