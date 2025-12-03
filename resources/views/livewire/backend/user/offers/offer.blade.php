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
    <div class="dark:bg-zinc-950 w-full mx-auto p-10 md:p-20">


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
            {{-- <div class="flex justify-center space-x-4">
                <div wire:click="back" class="flex w-full md:w-auto mt-10!">
                    <x-ui.button class="w-fit! py!">{{ __('Back') }}</x-ui.button>
                </div>

                <div wire:click="submitOffer" class="flex w-full md:w-auto mt-10!">
                    <x-ui.button class="w-fit! py!">{{ __('Next') }}</x-ui.button>
                </div>
            </div> --}}





            <div class="">
                <h1 class="text-40px font-semibold text-center text-text-white mb-3">{{ __('Sell Game Currency') }}
                </h1>
                <div class="flex gap-2 items-center justify-center">
                    <div>
                        <div class="w-10 h-10">
                            <img src="{{ asset('assets/images/Rectangle 24588.png') }}" alt=""
                                class="w-full h-full rounded-lg">
                        </div>
                    </div>
                    <h2 class="text-2xl text-center text-text-white/60">{{ __('8 Ball Pool') }}</h2>
                </div>
            </div>


            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <h2 class="text-text-white font-semibold text-40px mb-10">{{ __('Your item') }}</h2>
                <div class="bg-zinc-400/15 flex gap-4 items-center p-10 rounded-2xl">
                    <div>
                        <div class="w-28 h-28">
                            <img src="{{ asset('assets/images/Rectangle 24589.png') }}" alt=""
                                class="w-full h-full rounded-lg">
                        </div>
                    </div>
                    <h2 class="text-2xl text-text-white font-semibold">{{ __('Your item') }}</h2>
                </div>
            </div>


            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <h2 class="text-3xl font-semibold text-text-white">{{ __('Description') }} <span
                        class="text-text-white text-xl font-normal">{{ __('(optional)') }}</span></h2>
                <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                <p class="text-text-white text-base font-normal text-end mt-2">{{ __('Step 1/3') }}</p>
                <div class="mt-10">
                    <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                    <x-ui.textarea wire:model="description" placeholder="Type here......" class="w-full bg-zinc-400/15"
                        rows="5"></x-ui.textarea>
                    <p class="text-text-white text-xl font-normal mt-5">
                        {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                        <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                    </p>
                </div>
            </div>


            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <h2 class="text-text-white font-semibold text-3xl mb-10">{{ __('Delivery') }}</h2>
                <div>
                    <x-ui.label for="name" class="text-2xl! font-semibold! text-text-white! mb-4!"
                        :value="__('Guaranteed Delivery Time:')" />
                    <x-ui.select class="mt-1 block w-full" wire:model="selectedGame">
                        <option value="">{{ __('Choose') }}</option>
                        <option value="">{{ __('1 Days') }}</option>
                        <option value="">{{ __('2 Days') }}</option>
                        <option value="">{{ __('3 Days') }}</option>
                    </x-ui.select>
                </div>
                <p class="text-text-white text-xl font-normal mt-5">
                    {{ __('Faster delivery time improves your offer\'s ranking in the offer list.') }}
                </p>
            </div>


            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <h2 class="text-text-white font-semibold text-3xl ">{{ __('Delivery method') }}</h2>
                <div class="border-t border-zinc-500 mb-12 mt-2"></div>
                <div>
                    <h3 class="text-text-white text-lg font-medium mb-6">{{ __('Chose delivery method') }}</h3>

                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="auction_house" checked
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Auction House') }}</span>
                        </label>

                        <!-- Game Pass -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="game_pass"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Game Pass') }}</span>
                        </label>

                        <!-- In-game trade -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="ingame_trade"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('In-game trade') }}</span>
                        </label>

                        <!-- Mail Trade -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="mail_trade"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Mail Trade') }}</span>
                        </label>

                        <!-- Island Delivery -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="island_delivery"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Island Delivery') }}</span>
                        </label>

                        <!-- Epic Gifting -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="epic_gifting"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Epic Gifting') }}</span>
                        </label>

                        <!-- Login Method -->
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="delivery_method" value="login_method"
                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                            <span
                                class="ml-3 text-text-white text-base transition-colors">{{ __('Login Method') }}</span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <!-- Quantity Section -->
                <div>
                    <h2 class="text-text-white font-semibold text-3xl">
                        {{ __('Quantity') }}</h2>
                    <div class="border-t border-zinc-500 mt-2 mb-10 flex items-center gap-3"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Quantity Available -->
                        <div>
                            <label
                                class="text-text-white text-2xl font-semibold mb-4 block">{{ __('Total Quantity available:') }}</label>
                            <input type="text" value="1B" readonly
                                class="w-full bg-zinc-800/50 text-text-white text-center px-4 py-3 rounded-lg border border-zinc-700/50 focus:outline-none">
                        </div>

                        <!-- Minimum Offer Quantity -->
                        <div>
                            <label
                                class="text-text-white text-2xl font-semibold mb-4 block">{{ __('Minimum Offer quantity:') }}</label>
                            <input type="text" value="100k" readonly
                                class="w-full bg-zinc-800/50 text-text-white text-center px-4 py-3 rounded-lg border border-zinc-700/50 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Price Section -->
                <div>
                    <h2 class="text-text-white font-semibold text-3xl mt-10">{{ __('Price') }}</h2>
                    <div class="border-t border-zinc-500 mt-2 mb-10 flex items-center gap-3"></div>
                    <div>
                        <label
                            class="text-text-white text-2xl font-semibold mb-4 block">{{ __('Price per 100k:') }}</label>
                        <div class="flex gap-3">
                            <div class="w-full">
                                <x-ui.input id="name" type="text" class="mt-1 block w-full"
                                    wire:model="name" placeholder="Price" />
                            </div>
                            <div>
                                <x-ui.button class="w-auto! py-2!">{{ __('USD') }}</x-ui.button>
                            </div>
                        </div>
                    </div>
                    <p class="text-text-white text-xl font-normal mt-5">
                        {{ __('Competitive prices improve your offer\'s ranking in the offer list.') }}</p>
                </div>
            </div>



            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <div>
                    <h2 class="text-text-white font-semibold text-3xl">
                        {{ __('Volume discount') }}</h2>
                    <div class="border-t border-zinc-500 mt-2 mb-10 flex items-center gap-3"></div>
                    <div class="flex items-center gap-6">
                        <div class="w-full">
                            <label
                                class="text-text-white text-base font-normal mb-4 block">{{ __('Minimum quantity for discount') }}</label>
                            <input type="text" value="1B" readonly
                                class="w-full bg-zinc-800/50 text-text-white text-center px-4 py-3 rounded-lg border border-zinc-700/50 focus:outline-none">
                        </div>
                        <div class="w-full">
                            <label
                                class="text-text-white text-base font-normal mb-4 block">{{ __('Discount percentage') }}</label>
                            <input type="text" value="100k" readonly
                                class="w-full bg-zinc-800/50 text-text-white text-center px-4 py-3 rounded-lg border border-zinc-700/50 focus:outline-none">
                        </div>
                        <div>
                            <x-ui.button class="w-auto! py-2! m-0!"><x-phosphor-trash-simple
                                    class="w-5 h-5 fill-text-text-white group-hover:fill-accent" /></x-ui.button>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <x-ui.button class="w-auto! py-2!">
                        <x-phosphor-plus class="w-5 h-5 fill-text-text-white group-hover:fill-accent" />
                        {{ __('Add raw') }}
                    </x-ui.button>
                </div>
            </div>

            <div class="bg-zinc-900 p-10 xl:p-20 rounded-2xl mt-10">
                <div>
                    <h2 class="text-text-white font-semibold text-3xl">
                        {{ __('Fee structure') }}</h2>
                    <div class="border-t border-zinc-500 mt-2 mb-10 flex items-center gap-3"></div>
                    <div class="flex items-center gap-6">
                        <h2 class="text-text-white text-2xl font-semibold inline">
                            <p class="text-text-white font-normal text-xl inline">
                                {{ __('Flat fee (per purchase): ') }}</p> {{ __('$0.00 USD') }}
                        </h2>
                    </div>
                    <div class="flex items-center gap-6">
                        <h2 class="text-text-white text-2xl font-semibold inline">
                            <p class="text-text-white font-normal text-xl inline">
                                {{ __('Percentage fee (per purchase): ') }}</p> {{ __('5 % of Price') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="space-y-6 mt-8">
                <!-- Terms Checkboxes -->
                <div class="space-y-3">
                    <!-- Terms of Service -->
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="terms_of_service" required
                            class="w-4 h-4 bg-transparent border-2 border-zinc-700 rounded cursor-pointer">
                        <span class="ml-3 text-text-white text-sm">
                            {{ __('I have read and agree to the') }}
                            <a href="#"
                                class="text-pink-500 hover:text-pink-400 transition-colors">{{ __('Terms of Service.') }}</a>
                        </span>
                    </label>

                    <!-- Seller Rules -->
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="seller_rules" required
                            class="w-4 h-4 bg-transparent border-2 border-zinc-700 rounded cursor-pointer">
                        <span class="ml-3 text-text-white text-sm">
                            {{ __('I have read and agree to the') }}
                            <a href="#"
                                class="text-pink-500 hover:text-pink-400 transition-colors">{{ __('Seller Rules.') }}</a>
                        </span>
                    </label>
                </div>

                <!-- Place Offer Button -->
                <div class="mt-10">
                    <x-ui.button class="w-auto! py-2!">
                        {{ __('Place Offer') }}
                    </x-ui.button>
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
