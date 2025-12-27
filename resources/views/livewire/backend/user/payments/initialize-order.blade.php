<div class="lg:col-span-1 ">

    <form x-data="{
        quantity: @entangle('quantity').live,
        price: {{ $product->price }},
        stock: {{ $product->quantity }}
    }" wire:submit="submit">
        <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg p-6 mb-6">


            <div class="pt-4 mb-6">
                <div class="flex justify-between items-center ">
                    <p class="text-text-primary text-xl">{{ $product->name }}
                    </p>
                </div>
            </div>

            {{-- order incriment decriment --}}
            <div class="py-4 rounded-lg max-w-xl mx-auto">
                <div class="flex items-center justify-between gap-2">
                    <x-ui.button class="w-auto! py-1.5! px-2.5! rounded!"
                        x-on:click.prevent="quantity = Math.max(1, quantity - 1)">
                        <flux:icon name="minus"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>

                    <x-ui.input type="number" x-model.number="quantity" min="1" :max="$product->quantity"
                        class="text-center w-22 py-1! px-3! border-zinc-500" />

                    <x-ui.button class="w-auto! py-1.5! px-2.5! rounded!"
                        x-on:click.prevent="quantity = Math.min(stock, quantity + 1)">
                        <flux:icon name="plus"
                            class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>
                </div>

                <div>
                    <div class="pt-4">
                        <div class="flex justify-between items-center ">
                            <span class="text-xs text-text-secondary">{{ __('Delivery time') }}
                            </span>
                            <span class="text-xs text-text-secondary">
                                {{ $product->delivery_timeline }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-2 ">
                            <span class="text-xs text-text-secondary">{{ __('Platform') }}
                            </span>
                            <span class="text-xs text-text-secondary">
                                {{ $product->platform->name }}
                            </span>
                        </div>
                    </div>
                    @foreach ($product->product_configs as $config)
                        @if (!$config->game_configs->field_name)
                            @continue
                        @endif
                        <div class="flex justify-between mt-2 text-xs text-text-secondary">
                            <span>{{ $config->game_configs->field_name }}</span>
                            <span>{{ $config->value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>





        <!-- Delivery Instructions -->
        <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg   px-4 py-4 ">

            {{-- <div class="pt-4 mb-8">
                <div class="flex justify-between items-center border-b border-zinc-500/60 pb-4">
                    <span class="text-text-primary text-base">{{ __('Price') }}
                    </span>
                    <span class="text-gray-100 sm:text-sm px-3 py-1 ">
                        <span>PEN </span>
                        <span x-text="(quantity * price).toFixed(2)"
                            class="text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    </span>
                </div>
            </div> --}}
            <!-- Buy Button -->
            @auth('web')
                <x-ui.button class="w-full  py-2!" type="submit">
                    PEN<span x-text="(quantity * price).toFixed(2)"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary "></span>
                    {{ __('| Buy Now') }}
                </x-ui.button>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="bg-zinc-500 px-4  py-2!  text-text-btn-primary hover:text-text-btn-secondary hover:bg-zinc-50 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500 font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 transition duration-150 ease-in-out group text-nowrap cursor-pointer w-full mb-6">
                    PEN<span x-text="(quantity * price).toFixed(2)"
                        class=" text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    {{ __('| Buy Now') }}
                </a>
            @endauth
            <!-- Guarantees -->
            {{-- <div class="space-y-4">
                <!-- Money-back -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-sm">{{ __('Money-back Guarantee') }}</p>
                        <p class="text-xs text-gray-400">{{ __('Protected by TradeShield') }}</p>
                    </div>
                </div>

                <!-- Fast Checkout -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                        </path>
                    </svg>
                    <div class="flex">
                        <p class="font-semibold text-sm">{{ __('Fast Checkout Options') }}</p>
                        <div class="flex gap-0 ">
                            <span class="text-xs   px-2 rounded">
                                <img src="{{ asset('assets/images/GooglePay-Light 1.svg') }}" alt="">
                            </span>
                            <span class="text-xs   px-2  rounded"> <img
                                    src="{{ asset('assets/images/ApplePay-Light 1.svg') }}" alt="">
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                        </path>
                    </svg>
                    <div>
                        <p class="font-semibold text-sm">{{ __('24/7 Live Support') }}</p>
                        <p class="text-xs text-gray-400">{{ __('We\'re always here to help') }}</p>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Delivery Instructions -->
        <!-- Delivery Instructions -->
        <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg   mt-6 px-4 py-4 ">




            <div class="  mt-2 pt-3 flex items-center justify-between gap-2">

                <div class="w-18 h-14 relative">
                    <img src="{{ auth_storage_url($product->user->avatar) }}"
                        class="w-14 h-14 rounded-full border-2 border-white" alt="profile" />
                    <span class="absolute bottom-0 right-0 w-5 h-5 bg-green border-2 border-white rounded-full"></span>

                </div>

                <div class="w-full">
                    <p class="text-text-white font-medium flex items-center gap-2">
                        <span> {{ $product->user->full_name }}</span>
                        @if ($product->user->seller?->seller_verified_at)
                            <x-phosphor name="seal-check" variant="solid" class="fill-zinc-700 w-5 h-5" />
                        @endif
                    </p>

                    <div class="flex items-center space-x-2 mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 fill-zinc-500">
                            <path
                                d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                        </svg>
                        <p class="text-text-secondary text-xs">99.3% </p>
                    </div>
                </div>
            </div>

            <h3 class="font-bold m-4">{{ __('Seller Description') }}</h3>
            <div x-data="{
                expanded: false,
                limit: 50,
                fullText: `{!! addslashes($product->user->description ?? '') !!}`,
                get words() {
                    // Remove HTML tags and split into words
                    return this.fullText.replace(/(<([^>]+)>)/gi, '').trim().split(/\s+/);
                },
                get shortText() {
                    return this.words.slice(0, this.limit).join(' ');
                },
                get hasMore() {
                    return this.words.length > this.limit;
                }
            }" class="m-4">

                <!-- Description -->
                <p class="text-text-secondary text-sm">
                    <span x-show="!expanded">
                        <span x-text="shortText"></span>
                        <span x-show="hasMore">...</span>
                    </span>

                    <span x-show="expanded" x-html="fullText" x-cloak></span>
                </p>

                <!-- Toggle Button -->
                <button type="button" x-show="hasMore" @click="expanded = !expanded"
                    class="flex items-center justify-center mx-auto mt-2 text-pink-500 font-semibold gap-1">
                    <span x-text="expanded ? 'View Less' : 'View More'"></span>
                    <svg class="w-6 h-6 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"
                        fill="#ff2e91" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

            </div>

        </div>
          <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg   mt-6 px-4 py-4 ">
        


            <button class=" text-3xl mt-5 mb-4 font-semibold">{{ __('Recent feedback') }}</button>
            <!-- Seller Card -->
            @foreach ([1, 2] as $item)
                <div class="bg-bg-optional dark:bg-bg-info text-white p-5  max-w-md mb-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="#853EFF" viewBox="0 0 20 20">
                                <path
                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                            <h3 class="text-base font-medium">
                                Items <span class="text-text-secondary font-normal">| Yeg***</span>
                            </h3>
                        </div>
                        <span class="text-text-secondary text-sm whitespace-nowrap">24.10.25</span>
                    </div>
                    <p class="text-text-secondary text-sm">Yeg***</p>
                </div>
            @endforeach
            <div class="mt-5">
                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{ __('All feedback') }}</x-ui.button>
            </div>
          </div>

    </form>

</div>
