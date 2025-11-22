<div class="container px-24 bg-zinc-900/90">
    <div class="w-full mx-auto p-20">

        {{-- Step 1: Category Selection --}}
        @if ($step === 1)
            <h1 class="text-40px font-semibold text-center text-white mb-3">{{ __('Start selling') }}</h1>
            <h2 class="text-2xl text-center text-white/60 mb-10">{{ __('Choose category') }}</h2>

            <div class="space-y-10">
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                        class="w-full flex items-center justify-between p-4 bg-zinc-700/15 hover:bg-zinc-700/30 transition rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16">
                                <img src="{{ storage_url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-full rounded-xl object-cover">
                            </div>
                            <span class="text-3xl font-semibold text-white">{{ $category->name }}</span>
                        </div>
                        <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                            <path
                                d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                            </path>
                        </svg>
                    </button>
                @endforeach
            </div>
        @endif
        @if ($step === 2)
            <h2 class="text-40px font-semibold text-center text-white mb-3">
                {{ __('Sell') }} {{ $selectedCategory }}
            </h2>
            <h2 class="text-2xl text-center text-white/60 mb-10">{{ __('Step 1/3') }}</h2>

            <div class="p-20 bg-zinc-400/15 rounded-2xl">
                <h2 class="text-2xl font-semibold text-center text-white mb-7">
                    {{ __('Select Game') }}
                </h2>

                <div class="w-md flex justify-center mx-auto">
                    @if (count($categoryGames) > 0)
                        <select wire:model="selectedGame"
                            class="w-full bg-zinc-700/50 text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">
                            <option value="">{{ __('Select a game') }}</option>
                            @foreach ($categoryGames as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <div class="text-center text-white/60 py-8">
                            <p class="text-xl mb-2">{{ __('No games found in this category') }}</p>
                            <p class="text-sm">{{ __('Please try another category') }}</p>
                        </div>
                    @endif
                </div>

                @error('selectedGame')
                    <p class="text-red-500 text-center mt-2">{{ $message }}</p>
                @enderror

                <div class="flex justify-center space-x-4 pt-10">
                    <button wire:click="back"
                        class="px-8 py-2 bg-zinc-700 hover:bg-zinc-600 text-white rounded-lg transition">
                        {{ __('Back') }}
                    </button>
                    @if (count($categoryGames) > 0)
                        <button wire:click="selectGame"
                            class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                            {{ __('Next') }}
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- Step 3: Additional Details --}}
        @if ($step === 3)
            <h2 class="text-40px font-semibold text-center text-white mb-3">
                {{ __('Sell Game ') . ucfirst($selectedCategory) }}
            </h2>
            <h2 class="text-2xl text-center text-white/60 mb-10">{{ __('Step 2/3') }}</h2>

            <div class="p-20 bg-zinc-400/15 rounded-2xl">
                <h2 class="text-2xl font-semibold text-center text-white mb-7">
                    {{ __('Additional Details') }}
                </h2>

                <div class="w-md grid grid-cols-2 gap-3 justify-center mx-auto">
                    {{-- Server Selection --}}
                    @if (count($servers) > 0)
                        <select wire:model="selectedServer"
                            class="bg-zinc-700/50 text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">
                            <option value="">{{ __('Select Server') }}</option>
                            @foreach ($servers as $server)
                                <option value="{{ $server->id }}">{{ $server->name }}</option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Faction Selection --}}
                    @if (count($factions) > 0)
                        <select wire:model="selectedFaction"
                            class="bg-zinc-700/50 text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">
                            <option value="">{{ __('Select Faction') }}</option>
                            @foreach ($factions as $faction)
                                <option value="{{ $faction->id }}">{{ $faction->name }}</option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Delivery Method --}}
                    @if (count($deliveryMethods) > 0)
                        <select wire:model="selectedDeliveryMethod"
                            class="bg-zinc-700/50 text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3 col-span-2">
                            <option value="">{{ __('Delivery Method') }}</option>
                            @foreach ($deliveryMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-center mt-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-center space-x-4 pt-10">
                    <button wire:click="back"
                        class="px-8 py-2 bg-zinc-700 hover:bg-zinc-600 text-white rounded-lg transition">
                        {{ __('Back') }}
                    </button>
                    <button wire:click="submitOffer"
                        class="px-8 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        {{ __('Submit Offer') }}
                    </button>
                </div>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="mt-4 p-4 bg-green-600/20 border border-green-600 rounded-lg text-center text-white">
                {{ session('message') }}
            </div>
        @endif

    </div>
</div>
