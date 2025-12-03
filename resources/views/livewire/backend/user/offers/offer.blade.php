<div class="container px-24 mb-32">
    <div class="flex gap-4 items-center my-10">
        {{-- <h2 class="text-text-white text-base">
            {{ __('Home') }}
        </h2>
        <x-phosphor name="greater-than" variant="regular" class="w-4 h-4 text-zinc-400" />
        <h2 class="text-text-white text-base">
            {{ __('Select game') }}
        </h2> --}}
    </div>
    <div class="dark:bg-zinc-900 w-full mx-auto p-20">


        {{-- Step 1: Category Selection --}}
        @if ($step === 1)
            <h1 class="text-40px font-semibold text-center text-text-white mb-3">{{ __('Start selling') }}</h1>
            <h2 class="text-2xl text-center text-text-white/60 mb-10">{{ __('Choose category') }}</h2>

            <div class="space-y-10">
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                        class="w-full flex items-center justify-between p-4 bg-zinc-700/15 hover:bg-zinc-700/30 transition rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16">
                                <img src="{{ storage_url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-full rounded-xl object-cover">
                            </div>
                            <span class="text-3xl font-semibold text-text-white">{{ $category->name }}</span>
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

        {{-- Step 2: Game Selection --}}
        @if ($step === 2)
            <h2 class="text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Sell') }} {{ $selectedCategory }}
            </h2>
            <h2 class="text-2xl text-center text-text-white/60 mb-10">{{ __('Step 1/3') }}</h2>

            <div class="p-10 bg-zinc-400/15 rounded-2xl">
                <h2 class="text-2xl font-semibold text-center text-text-white mb-7">
                    {{ __('Choose Game') }}
                </h2>

                <div class="w-md flex justify-center mx-auto">
                    @if (count($categoryGames) > 0)
                        <x-ui.select class="mt-1 block w-full" wire:model="selectedGame">
                            <option value="">{{ __('Select a game') }}</option>
                            @foreach ($categoryGames as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </x-ui.select>
                    @else
                        <div class="text-center text-text-white/60 py-8">
                            <p class="text-xl mb-2">{{ __('No games found in this category') }}</p>
                            <p class="text-sm">{{ __('Please try another category') }}</p>
                        </div>
                    @endif
                </div>

                @error('selectedGame')
                    <p class="text-red-500 text-center mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-center space-x-4">
                <div class="flex w-full md:w-auto mt-10!">
                    <x-ui.button class="w-fit! py!">{{ __('Back') }}</x-ui.button>
                </div>
                @if (count($categoryGames) > 0)
                    <div wire:click="selectGame" class="flex w-full md:w-auto mt-10!">
                        <x-ui.button class="w-fit! py!">{{ __('Next') }}</x-ui.button>
                    </div>
                @endif
            </div>
        @endif

        {{-- Step 3: Additional Details (Dynamic from game_configs) --}}
        @if ($step === 3)
            <h2 class="text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Sell Game ') . ucfirst($selectedCategory) }}
            </h2>
            <h2 class="text-2xl text-center text-text-white/60 mb-10">{{ __('Step 2/3') }}</h2>

            <div class="p-20 bg-zinc-400/15 rounded-2xl">
                <h2 class="text-2xl font-semibold text-text-white mb-7">
                    {{ __('Item details') }}
                </h2>


                <div class="w-md grid grid-cols-1 gap-3 justify-center mx-auto">
                    @foreach ($gameConfigs as $config)
                        <div
                            class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">

                            {{-- Dropdown --}}
                            @if (in_array($config->filter_type, ['filter_by_select', 'select_dropdown']))
                                <div>
                                    <x-ui.label :for="'config_' . $config->slug" :value="$config->field_name" />
                                    <x-ui.select :id="'config_' . $config->slug" class="mt-1 block w-full"
                                        wire:model="configValues.{{ $config->slug }}">
                                        <option value="">{{ __('Select') }} {{ $config->field_name }}</option>

                                        @if (!empty($config->dropdown_values))
                                            @foreach (json_decode($config->dropdown_values, true) as $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </x-ui.select>
                                    <x-ui.input-error :messages="$errors->get('configValues.' . $config->slug)" class="mt-2" />
                                </div>

                                {{-- Textarea --}}
                            @elseif (in_array($config->filter_type, ['textarea', 'filter_by_textarea']))
                                <textarea wire:model="configValues.{{ $config->slug }}" placeholder="{{ $config->field_name }}" rows="4"
                                    class="w-full bg-zinc-700/50 text-text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3"></textarea>

                                {{-- Number input --}}
                            @elseif (in_array($config->filter_type, ['filter_by_range', 'number']))
                                <input type="number" wire:model="configValues.{{ $config->slug }}"
                                    placeholder="{{ $config->field_name }}"
                                    class="w-full bg-zinc-700/50 text-text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">

                                {{-- Default text input --}}
                            @else
                                <input type="text" wire:model="configValues.{{ $config->slug }}"
                                    placeholder="{{ $config->field_name }}"
                                    class="w-full bg-zinc-700/50 text-text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">
                            @endif

                            {{-- Validation errors (for non-dropdown fields) --}}
                            @if (!in_array($config->filter_type, ['filter_by_select', 'select_dropdown']))
                                @error('configValues.' . $config->slug)
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    @endforeach
                </div>


                @if ($errors->any())
                    <div class="text-red-500 text-center mt-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex justify-center space-x-4">
                <div wire:click="back" class="flex w-full md:w-auto mt-10!">
                    <x-ui.button class="w-fit! py!">{{ __('Back') }}</x-ui.button>
                </div>

                <div wire:click="submitOffer" class="flex w-full md:w-auto mt-10!">
                    <x-ui.button class="w-fit! py!">{{ __('Next') }}</x-ui.button>
                </div>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="mt-4 p-4 bg-green-600/20 border border-green-600 rounded-lg text-center text-text-white">
                {{ session('message') }}
            </div>
        @endif

    </div>
</div>
