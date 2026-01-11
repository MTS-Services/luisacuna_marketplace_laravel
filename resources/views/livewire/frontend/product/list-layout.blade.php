<div>
    <section class="container mt-2">
        <livewire:frontend.partials.page-inner-header :gameSlug="$gameSlug" :categorySlug="$categorySlug" :game="$game" />

        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 mt-8 text-lg font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-text-primary">
                {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' / ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
            </h1>
            <span class="text-text-primary">></span>
            <span class="text-text-primary">{{ __('Shop') }}</span>
        </div>

        {{-- Filters & Sort --}}
        <div class="mt-8">
            <div class="flex items-center justify-between">
                <span class="text-base font-semibold">{{ __('Select Filter') }}</span>

                <div class="block md:hidden relative z-10" x-data="{ open: false }">
                    <div @click="open = !open" class="cursor-pointer inline-block">
                        <x-phosphor name="sort-ascending" variant="bold" class="fill-white w-6 h-6" />
                    </div>
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 p-2 bg-bg-primary rounded-2xl shadow-lg origin-top-right">
                        <button wire:click="$set('sortDirection', 'asc')" @click="open = false"
                            class="w-full text-left text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg">
                            {{ __('Lowest To Highest') }}
                        </button>
                        <button wire:click="$set('sortDirection', 'desc')" @click="open = false"
                            class="w-full text-left text-text-white block px-3 py-2 text-sm hover:bg-zinc-700 rounded-lg">
                            {{ __('Highest to Lowest') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 mb-6 flex items-center justify-between gap-4">
            <x-ui.custom-select wire:model.live="serach"
                class="w-full sm:w-70 rounded-full! bg-transparent! border! border-zinc-700!" label="Filter">
                <x-ui.custom-option label="All" value="" />
                @foreach ($tags as $tag)
                    <x-ui.custom-option label="{{ $tag }}" value="{{ $tag }}" />
                @endforeach
            </x-ui.custom-select>

            <div class="hidden md:flex w-70">
                <x-ui.custom-select wire:model.live="sortDirection"
                    class="w-full rounded-full! bg-transparent! border! border-zinc-700!" label="Sort By">
                    <x-ui.custom-option label="{{ __('Lowest to Highest') }}" value="asc" />
                    <x-ui.custom-option label="{{ __('Highest to Lowest') }}" value="desc" />
                </x-ui.custom-select>
            </div>
        </div>

        <div class="mb-10">
            <span class="text-base font-semibold text-text-white">{{ $datas->total() }}
                {{ __('results found') }}</span>
        </div>
    </section>

    {{-- Main content --}}
    <section class="container" x-data="{ selectedId: @entangle('product.id') }">
        <div class="md:flex gap-6 items-start">

            {{-- Product Grid --}}
            <div class="w-full md:w-[65%] flex flex-col">
                <div class="relative">
                    <x-loading-animation target="serach, sortDirection, selectItem" style="list" />

                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4 content-start"
                        wire:loading.class="opacity-50">
                        @forelse ($datas as $item)
                            <div wire:key="prod-{{ $item->id }}" wire:click="selectItem({{ $item->id }})"
                                @click="selectedId = {{ $item->id }}"
                                :class="selectedId == {{ $item->id }} ? 'border-pink-500 ring-1 ring-pink-500' :
                                    'border-transparent'"
                                class="bg-bg-primary dark:bg-bg-secondary rounded-2xl p-3 border transition-all duration-300 cursor-pointer hover:border-pink-500/50">

                                <div class="flex items-center justify-between">
                                    <img src="{{ storage_url($game?->logo) }}" class="w-6 h-6 object-cover">
                                    @if ($game->tags->isNotEmpty())
                                        <span
                                            class="bg-zinc-500 text-white py-1 px-2 rounded-2xl text-[10px] flex items-center gap-1">
                                            <x-phosphor name="fire" variant="regular" class="w-3 h-3 fill-white" />
                                            {{ $game->tags->first()->name }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-base font-semibold text-text-white mt-4">{{ $item->quantity }} Units
                                </h3>
                                <p class="text-xs text-text-white mt-2 opacity-70">{{ Str::limit($item->name, 22) }}
                                </p>
                                <span class="block text-base font-semibold text-pink-500 mt-4">
                                    {{ currency_symbol() . currency_exchange($item->price) }}
                                </span>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <x-ui.empty-card />
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-8">
                    <x-frontend.pagination-ui :pagination="$pagination" class="justify-center!" />
                </div>
            </div>

            {{-- Checkout Sidebar --}}
            <aside class="w-full md:w-[35%] mt-4 md:mt-0 sticky top-4">
                <div class="bg-bg-primary dark:bg-bg-secondary rounded-2xl py-7 px-6 border border-zinc-800 shadow-xl">
                    <div class="animate-in fade-in slide-in-from-right-4 duration-300">
                        @if ($product)
                            <div class="flex items-center gap-1 mb-8">
                                <div class="w-8 h-8">
                                    <img src="{{ storage_url($product->game->logo) }}" alt=""
                                        class="w-full h-full object-cover">
                                </div>
                                <p></p>
                            </div>
                        @else
                            <p>{{ __('No Product Selected') }}</p>
                        @endif
                        <div class="flex items-center justify-between py-3 border-t border-b  border-zinc-500 w-full">
                            <p class="text-base text-text-white"> {{ __('Delivery Timeline') }}</p>
                            @if ($product)
                                <p class="text-base text-text-white font-semibold">{{ $product->delivery_timeline }}
                                </p>
                            @else
                                <p class="text-base text-text-white font-semibold">N/A</p>
                            @endif
                        </div>

                        <div class="space-y-4 mt-8">
                            @auth('web')
                                <x-ui.button wire:click="submit" wire:loading.attr="disabled" class="w-full py-2!">
                                    <span wire:loading.remove wire:target="submit"
                                        class="text-text-white group-hover:text-zinc-500">
                                        {{ currency_code() }} {{ currency_exchange($product->price ?? 00) }}
                                        {{ __(' Buy Now') }}
                                    </span>
                                    <span wire:loading wire:target="submit"
                                        class="text-text-white group-hover:text-zinc-500">{{ __('Processing...') }}</span>
                                </x-ui.button>
                            @else
                                <a href="{{ route('login') }}" wire:navigate
                                    class="bg-zinc-500 px-4 md:px-6 py-2! md:py-4 text-text-text-btn-primary hover:text-text-btn-secondary hover:bg-zinc-50 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500 font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 transition duration-150 ease-in-out group text-nowrap cursor-pointer">
                                    <span class="text-text-white group-hover:text-zinc-500">{{ currency_code() }}</span>
                                    <span
                                        class="text-text-white group-hover:text-zinc-500">{{ currency_exchange($product->price ?? 00) }}</span>
                                    {{ ' Buy Now' }}
                                </a>
                            @endauth
                        </div>

                        {{-- Trust Badges --}}
                        <div class="mt-8 space-y-4 opacity-80">
                            <div class="flex items-center gap-3">
                                <flux:icon name="shield-check" class="w-5 h-5 text-green-500" />
                                <p class="text-xs text-text-white font-medium">{{ __('Protected by TradeShield') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <flux:icon name="bolt" class="w-5 h-5 text-yellow-500" />
                                <p class="text-xs text-text-white font-medium">
                                    {{ __('Instant Delivery Available') }}</p>
                            </div>
                        </div>

                        {{-- Seller Profile Card --}}
                        @if ($product)
                            <div class="mt-8 pt-6 border-t border-zinc-700">
                                <div class="flex items-center gap-4">
                                    <img src="{{ auth_storage_url($product->user?->avatar) }}"
                                        class="w-12 h-12 rounded-full border border-zinc-700">
                                    <div class="flex-1">
                                        <h4 class="text-white font-semibold text-sm">
                                            {{ $product->user?->full_name }}
                                        </h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <x-phosphor name="thumbs-up" variant="solid"
                                                class="w-3 h-3 fill-green-500" />
                                            <span class="text-[10px] text-zinc-300">
                                                {{ feedback_calculate($product->user->pos_count ?? 0, $product->user->neg_count ?? 0) }}%
                                                Positive
                                            </span>
                                            <span class="w-px h-2 bg-zinc-600"></span>
                                            <span
                                                class="text-[10px] text-zinc-300">{{ $product->user->orders_count ?? 0 }}
                                                Sold</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- Other Sellers Table --}}
    <section class="container mt-32 mb-20">
        <div class="mb-10">
            <h2 class="text-text-white font-semibold text-3xl">{{ __('Other Sellers') }}</h2>
        </div>

        <div class="mt-10 mb-6 flex items-center justify-between gap-4">
            <x-ui.select id="status-select" wire:model.live="sellerFilter"
                class="py-0.5! w-full sm:w-70 rounded-full!">
                <option value="recommended">{{ __('Recommended') }}</option>
                <option value="positive_reviews">{{ __('Positive Reviews') }}</option>
                <option value="top_sold">{{ __('Top Sold') }}</option>
                <option value="lowest_price">{{ __('Lowest Price') }}</option>
                <option value="in_stock">{{ __('In Stock') }}</option>
            </x-ui.select>

            <button
                class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green hover:text-white transition whitespace-nowrap">
                {{ __('● Online Seller') }}
            </button>
        </div>


        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-zinc-500 text-md tracking-wider">
                        <th class="px-6 py-3 font-medium">{{ __('All Sellers') }}</th>
                        <th class="px-6 py-3 font-medium hidden md:table-cell">{{ __('Delivery Time') }}</th>
                        <th class="px-6 py-3 font-medium hidden md:table-cell">{{ __('Delivery Method') }}</th>
                        <th class="px-6 py-3 font-medium hidden md:table-cell text-center">{{ __('Stock') }}</th>
                        <th class="px-6 py-3 font-medium text-right">{{ __('Price') }}</th>
                    </tr>
                </thead>
                <tbody class="space-y-4">
                    @forelse ($sellerProducts as $sellerProduct)
                        <tr wire:key="row-{{ $sellerProduct->id }}"
                            wire:click="selectItem({{ $sellerProduct->id }})"
                            class="bg-bg-secondary hover:bg-zinc-800 transition-colors cursor-pointer group">

                            <td class="px-6 py-4 rounded-l-2xl">
                                <div class="flex items-center gap-3">
                                    <img src="{{ auth_storage_url($sellerProduct->user?->avatar) }}"
                                        class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="text-white font-medium text-sm">
                                            {{ $sellerProduct->user?->full_name }}</p>
                                        <div class="flex items-center gap-1 opacity-60">
                                            <x-phosphor name="thumbs-up" variant="solid"
                                                class="w-3 h-3 fill-zinc-400" />
                                            <span
                                                class="text-[10px] text-white">{{ feedback_calculate($sellerProduct->positive_count ?? 0, 0) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell text-sm text-zinc-300">
                                {{ $sellerProduct->delivery_timeline ?? '--' }}
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell text-sm text-zinc-300">
                                {{ $sellerProduct->delivery_method ?? '--' }}
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell text-center text-sm text-zinc-300">
                                {{ $sellerProduct->quantity ?? '00' }}
                            </td>

                            <td class="px-6 py-4 rounded-r-2xl text-right">
                                <span class="text-pink-500 font-bold">
                                    {{ currency_symbol() }}{{ currency_exchange($sellerProduct->price) ?? '00' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-zinc-500">
                                {{ __('No other sellers available') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
