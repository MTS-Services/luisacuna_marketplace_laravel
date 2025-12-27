<div class="lg:col-span-1">

    <!-- PURCHASE FORM -->
    <form
        x-data="{
            quantity: @entangle('quantity').live,
            price: {{ $product->price }},
            stock: {{ $product->quantity }}
        }"
        wire:submit.prevent="submit"
        class="bg-bg-primary dark:bg-bg-secondary rounded-lg p-6 mb-6"
    >

        <!-- Product Name -->
        <div class="pt-4 mb-6">
            <div class="flex justify-between items-center">
                <p class="text-text-primary text-xl">{{ $product->name }}</p>
            </div>
        </div>

        <!-- Quantity Controls -->
        <div class="py-4 rounded-lg max-w-xl mx-auto">
            <div class="flex items-center justify-between gap-2">
                <x-ui.button
                    type="button"
                    class="w-auto! py-1.5! px-2.5! rounded!"
                    x-on:click.prevent="quantity = Math.max(1, quantity - 1)"
                >
                    <flux:icon name="minus"
                        class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                </x-ui.button>

                <x-ui.input
                    type="number"
                    x-model.number="quantity"
                    min="1"
                    :max="$product->quantity"
                    class="text-center w-22 py-1! px-3! border-zinc-500"
                />

                <x-ui.button
                    type="button"
                    class="w-auto! py-1.5! px-2.5! rounded!"
                    x-on:click.prevent="quantity = Math.min(stock, quantity + 1)"
                >
                    <flux:icon name="plus"
                        class="w-5 h-5 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                </x-ui.button>
            </div>

            <!-- Product Configs -->
            <div class="pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-text-secondary">{{ __('Delivery time') }}</span>
                    <span class="text-xs text-text-secondary">{{ $product->delivery_timeline }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-text-secondary">{{ __('Platform') }}</span>
                    <span class="text-xs text-text-secondary">{{ $product->platform->name }}</span>
                </div>

                @foreach ($product->product_configs as $config)
                    @if (!$config->game_configs->field_name) @continue @endif
                    <div class="flex justify-between mt-2 text-xs text-text-secondary">
                        <span>{{ $config->game_configs->field_name }}</span>
                        <span>{{ $config->value }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Buy Button -->
        <div class="mt-6">
            @auth('web')
                <x-ui.button class="w-full py-2!" type="submit">
                    PEN
                    <span x-text="(quantity * price).toFixed(2)"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    {{ __('| Buy Now') }}
                </x-ui-button>
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="bg-zinc-500 px-4 py-2 w-full rounded-full flex justify-center items-center gap-2">
                    PEN
                    <span x-text="(quantity * price).toFixed(2)"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary"></span>
                    {{ __('| Buy Now') }}
                </a>
            @endauth
        </div>
    </form>

    <!-- SELLER DESCRIPTION (OUTSIDE FORM) -->
    <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg mt-6 px-4 py-4">
        <h3 class="font-bold m-4">{{ __('Seller Description') }}</h3>

        <div x-data="{ expanded: false }" class="m-4">
            <p class="text-text-secondary text-sm">
                <span x-show="!expanded">
                    {{ \Illuminate\Support\Str::words(strip_tags($product->user->description), 50, '...') }}
                </span>

                <span x-show="expanded" x-cloak>
                    {!! $product->user->description !!}
                </span>
            </p>

            @if($product->user->description && str_word_count(strip_tags($product->user->description)) > 50)
                <button
                    type="button"
                    @click="expanded = !expanded"
                    class="flex items-center justify-center mx-auto mt-2  font-semibold"
                >
                    <span x-text="expanded ? 'View Less' : 'View More'" class="text-pink-500"></span>
                    <svg
                        class="w-5 h-5 ml-1 transition-transform duration-200"
                        :class="expanded ? 'rotate-180' : ''"
                        fill="#ff2e91"
                        viewBox="0 0 20 20"
                    >
                        <path fill-rule="evenodd"
                            d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- RECENT FEEDBACK (OUTSIDE FORM) -->
    <div class="bg-bg-primary dark:bg-bg-secondary rounded-lg mt-6 px-4 py-4">
        <button class="text-3xl mt-5 mb-4 font-semibold">{{ __('Recent feedback') }}</button>
        @foreach ([1, 2] as $item)
            <div class="bg-bg-optional dark:bg-bg-info text-white p-5 max-w-md mb-1">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="#853EFF" viewBox="0 0 20 20">
                            <path
                                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        <h3 class="text-base font-medium">Items <span class="text-text-secondary font-normal">| Yeg***</span></h3>
                    </div>
                    <span class="text-text-secondary text-sm whitespace-nowrap">24.10.25</span>
                </div>
                <p class="text-text-secondary text-sm">Yeg***</p>
            </div>
        @endforeach

        <div class="mt-5">
            <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{ __('All feedback') }}</x-ui-button>
        </div>
    </div>
</div>
