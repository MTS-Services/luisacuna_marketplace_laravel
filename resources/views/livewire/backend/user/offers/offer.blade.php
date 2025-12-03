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
    <div class="bg-bg-secondary w-full mx-auto p-10 md:p-20 rounded-2xl">


        {{-- Step 1: Category Selection --}}
        @if ($step === 1)
            <h1 class="text-40px font-semibold text-center text-text-white mb-3">{{ __('Start selling') }}</h1>
            <h2 class="text-2xl text-center text-text-white/60 mb-10">{{ __('Choose category') }}</h2>

            <div class="space-y-10">
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                        class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
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

            <div class="p-10 bg-bg-info rounded-2xl">
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
            <form wire:submit.prevent="submitOffer">
                <div class="bg-bg-optional rounded-2xl mb-10 p-20">
                    <h2 class="text-text-white font-semibold text-40px mb-10">{{ __('Your item') }}</h2>
                    <div class="bg-bg-info flex gap-4 items-center p-10 rounded-2xl">
                        <div>
                            <div class="w-28 h-28">
                                <img src="{{ asset('assets/images/Rectangle 24589.png') }}" alt=""
                                    class="w-full h-full rounded-lg">
                            </div>
                        </div>
                        <h2 class="text-2xl text-text-white font-semibold">{{ __('Your item') }}</h2>
                    </div>
                </div>

                <div class="p-20 bg-bg-optional rounded-2xl">
                    <h2 class="text-2xl font-semibold text-text-white mb-7">
                        {{ __('Specific Attributes') }}
                    </h2>


                    <div class="grid grid-cols-2 gap-3 justify-center mx-auto">
                        @foreach ($gameConfigs as $config)
                            <div
                                class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">

                                {{-- Dropdown --}}
                                @if (in_array($config->filter_type, ['filter_by_select', 'select_dropdown']))
                                    <div>
                                        <x-ui.label :for="'config_' . $config->slug" :value="$config->field_name" />
                                        <x-ui.select :id="'config_' . $config->slug" class="mt-1 block w-full"
                                            wire:model="configValues.{{ $config->slug }}">
                                            <option value="">{{ __('Select') }} {{ $config->field_name }}
                                            </option>

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
                                    <x-ui.label :for="'config_' . $config->slug" :value="$config->field_name" />
                                    <x-ui.input id="name" type="number"
                                        class="bg-transparent! dark:text-zinc-100! text-zinc-900! mt-1 block w-full"
                                        wire:model="configValues.{{ $config->slug }}"
                                        placeholder="{{ $config->field_name }}" />

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
                <div class="p-20 bg-bg-optional rounded-2xl mt-10">
                    <!-- Quantity Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="w-full">
                            <x-ui.label for="price" :value="__('Price')" required />
                            <x-ui.input id="price" type="number" class="mt-1 block w-full" wire:model="price"
                                placeholder="Price" />
                        </div>
                        <div>
                            <x-ui.label for="stock_quantity" :value="__('Stock Quantity')" required />
                            <x-ui.input id="stock_quantity" type="number" class="mt-1 block w-full"
                                wire:model="stock_quantity" placeholder="stock_quantity" />
                        </div>
                        <div>
                            <x-ui.label for="platform" :value="__('Platform')" required />
                            <x-ui.select class="mt-1 block w-full" wire:model="Platform">
                                <option value="">{{ __('Choose') }}</option>
                                <option value="">{{ __('1 Days') }}</option>
                                <option value="">{{ __('2 Days') }}</option>
                                <option value="">{{ __('3 Days') }}</option>
                            </x-ui.select>
                        </div>
                    </div>
                    <div class="mt-20">
                        <h2 class="text-3xl font-semibold text-text-white">{{ __('Description') }} <span
                                class="text-text-white text-xl font-normal">{{ __('(optional)') }}</span></h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="">
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                            <x-ui.textarea wire:model="description" placeholder="Type here......"
                                class="w-full bg-bg-optional" rows="5"></x-ui.textarea>
                            <p class="text-text-white text-xl font-normal mt-5">
                                {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                                <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>





                <div class="bg-bg-optional p-10 xl:p-20 rounded-2xl mt-10">
                    <h2 class="text-text-white font-semibold text-3xl">{{ __('Delivery method') }}</h2>
                    <div class="border-t border-zinc-500 mb-12 mt-2"></div>

                    <div>
                        <h3 class="text-text-white text-lg font-medium mb-6">{{ __('Select delivery method') }}</h3>

                        <div class="space-y-4">

                            <div class="space-y-4">
                                @foreach ($deliveryMethods as $value => $label)
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="delivery_method"
                                            wire:model="selectedDeliveryMethod" value="{{ $value }}"
                                            class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                                        <span class="ml-3 text-text-white text-base transition-colors">
                                            {{ $label }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Place Offer Button -->
                <div class="mt-10">
                    <x-ui.button type="submit" class="w-auto! py-2!">
                        {{ __('Place Offer') }}
                    </x-ui.button>
                </div>
            </form>
        @endif

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="mt-4 p-4 bg-green-600/20 border border-green-600 rounded-lg text-center text-text-white">
                {{ session('message') }}
            </div>
        @endif

    </div>
</div>
