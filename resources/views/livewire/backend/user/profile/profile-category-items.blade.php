<main class="mx-auto">


    {{-- select game --}}
    <div class="w-full sm:w-sm md:w-md lg:w-md mt-6">
        <x-ui.custom-select wire-model="game_id" :wire-live="true" id="game_id"
            class="border-zinc-500! bg-transparent! rounded-lg">
            <option value="">{{ __('All Game') }}</option>
            @foreach ($games as $game)
                <x-ui.custom-option value="{{ $game->id }}" label="{{ $game->name }}" />
            @endforeach
        </x-ui.custom-select>
    </div>

    @if ($list_type == 'list_grid')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-10">

            @forelse ($products as $product)
                <x-ui.shop-card :gameSlug="$product->games->slug" :categorySlug="$activeTab" :data="$product" :game="$product->games" />
            @empty
                <div class="flex justify-center items-center mt-10 col-span-4">
                <img src="{{ storage_url('nothing_found_kqlrqq', ['width'=>1926, 'height'=> '926']) }}" alt="No products found" class="w-full" />

                </div>
            @endforelse
        </div>
    @else
        <div class="md:flex gap-6 h-auto mt-10">

            <div class="w-full  grid grid-cols-1 xxxs:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 2xl:grid-cols-4">


                @forelse ($products as $product)
                    <div
                        class="bg-bg-primary shadow-sm dark:bg-bg-secondary rounded-2xl p-3 border border-transparent hover:border-pink-500 transition-all duration-300 cursor-pointer">

                        <div class="flex items-center justify-between">
                            <div class="w-6 h-6">
                                <img src="{{ storage_url($product->games->logo) }}" alt="{{ $product->games->name }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <div>
                                @if ($product?->games?->tags?->isNotEmpty())
                                    <a href="#"
                                        class="bg-zinc-500 text-white py-1 px-2 rounded-2xl inline-block text-xs">
                                        <x-phosphor name="fire" variant="regular" class="inline-block fill-white" />
                                        {{ $product->games->tags->random()->name }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <h3 class="text-base font-semibold text-text-white mt-4">

                            {{ $product->quantity }}
                        </h3>

                        <p class="text-xs text-text-white mt-2">
                            {{ Str::limit($product->name, 20) }}
                        </p>

                        <span class="block text-base font-semibold text-pink-500 mt-4">
                            {{ currency_symbol() . currency_exchange($product->price) }}
                        </span>
                    </div>
                @empty
                    <div class="flex justify-center items-center mt-10 col-span-4">
                        <img src="{{ storage_url('nothing_found_kqlrqq', ['width'=>1926, 'height'=> '926']) }}" alt="No products found" class="w-full" />
                    </div>
                @endforelse
            </div>
        </div>

    @endif

    <div class="flex justify-end items-center space-x-3  p-4 m-10">

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>
</main>
