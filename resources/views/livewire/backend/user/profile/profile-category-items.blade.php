<main class="mx-auto bg-bg-primary">
    @if ($activeTab == 'giftcards' || $activeTab == 'topups')
        {{-- main --}}
        <section class="container">
            <div class="w-full sm:w-sm md:w-md lg:w-md mt-6">
                <x-ui.custom-select wire:model="game_id" id="game_id"
                    class="border-zinc-500! bg-transparent! rounded-lg">
                    <option value="">{{ __('All Game') }}</option>
                    @foreach ($games as $game)
                        <x-ui.custom-option value="{{ $game->id }}" label="{{ $game->name }}" />
                    @endforeach
                </x-ui.custom-select>
            </div>

            <div class="md:flex gap-6 h-auto mt-10">

                <div class="w-full  grid grid-cols-1 xxxs:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$40.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$50.20</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$60.20</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="flex items-center justify-between ">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="">
                                <a href="" class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl">
                                    <x-phosphor name="fire" variant="regular"
                                        class="inline-block fill-white" />{{ __('Popular') }}
                                </a>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$80.20</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$90.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$95.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$100.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$110.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$120.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$130.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$140.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$150.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$160.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$170.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$180.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$190.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$200.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$210.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$220.16</span>
                    </div>
                    <div
                        class="bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks.png') }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-base font-semibold text-text-white mt-4">1000</h3>
                        <p class="text-xs text-text-white mt-2">{{ __('V-Bucks') }}</p>
                        <span class="text-base font-semibold text-pink-500 mt-4">$230.16</span>
                    </div>
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
        </section>
    @endif

    {{-- select game --}}
    <div class="w-full sm:w-sm md:w-md lg:w-md mt-6">
        <x-ui.custom-select wire:model="game_id" id="game_id" class="border-zinc-500! bg-transparent! rounded-lg">
            <option value="">{{ __('All Game') }}</option>
            @foreach ($games as $game)
                <x-ui.custom-option value="{{ $game->id }}" label="{{ $game->name }}" />
            @endforeach
        </x-ui.custom-select>
    </div>

    {{-- games --}}

    @if ($list_type == 'list_grid')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">


            @foreach ($products as $product)
                <x-ui.shop-card :gameSlug="$product->games->slug" :categorySlug="$activeTab" :data="$product" :game="$product->games" />
            @endforeach
        </div>
    @else
        <div class="md:flex gap-6 h-auto mt-10">

            <div class="w-full  grid grid-cols-1 xxxs:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">


                @foreach ($products as $product)
                    <div
                        class="bg-bg-primary dark:bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300 cursor-pointer">

                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6">
                                <img src="{{ storage_url($product->games->logo) }}"
                                    alt="{{ $product->games->name }}" class="w-full h-full object-cover">
                            </div>

                            <div>
                                <a href="#"
                                    class="bg-zinc-500 text-text-white py-1 px-2 rounded-2xl inline-block text-xs">
                                    <x-phosphor name="fire" variant="regular" class="inline-block fill-white" />
                                    {{ $product->games->tags->random()->name ?? '' }}
                                </a>
                            </div>
                        </div>

                        <h3 class="text-base font-semibold text-text-white mt-4">

                            {{ $product->quantity }}
                        </h3>

                        <p class="text-xs text-text-white mt-2">
                            {{ Str::limit($product->name, 20) }}
                        </p>

                        <span class="block text-base font-semibold text-pink-500 mt-4">
                            ${{ number_format($product->quantity * $product->price, 2) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    @endif

    <div class="flex justify-end items-center space-x-3  p-4 m-10">

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
</main>
