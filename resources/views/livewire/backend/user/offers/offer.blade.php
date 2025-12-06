<div class="container pb-75">

    <livewire:frontend.partials.breadcrumb :gameSlug="'currency'" :categorySlug="'sell currency'" />

    <div class="bg-bg-secondary w-full mx-auto p-4 sm:p-10 md:p-20 rounded-2xl ">


        {{-- Step 1: Category Selection --}}
        @if ($step === 1)
            <h1 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-2">{{ __('Start selling') }}</h1>
            <h2 class="text-base sm:text-2xl text-center text-text-white mb-4 sm:mb-10">{{ __('Choose category') }}</h2>

            <div class="space-y-4 sm:space-y-10">
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                        class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 sm:w-16 sm:h-16">
                                @if($category->image)
                                <img src="{{ storage_url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                                @else
                                 <img src="{{ storage_url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                                @endif
                            </div>
                            <span
                                class="text-2xl sm:text-3xl font-semibold text-text-white">{{ $category->name }}</span>
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
            <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">

                {{ __('Sell') }} {{ $categoryName }}

            </h2>
            <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 1/2') }}</h2>

            <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                <h2 class="text-2xl font-semibold text-center text-text-white mb-2 sm:mb-7">
                    {{ __('Choose Game') }}
                </h2>

                <x-ui.custom-select :rounded="'rounded'" :label="__('Select a game')" :options="$games" :wireModel="'gameId'"/>

                @error('gameId')
                    <p class="text-red-500 text-center mt-2">{{ $message }}</p>
                @enderror

            </div>
            <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                <div class="flex md:w-auto! ">
                    <x-ui.button class="w-fit! py-2! px-4!">{{ __('Back') }}</x-ui.button>
                </div>
                @if (count($games) > 0)
                    <div wire:click="selectGame" class="flex md:w-auto! ">
                        <x-ui.button class="w-fit! py-2! px-4!">{{ __('Next') }}</x-ui.button>
                    </div>
                @endif
            </div>
            <div class="text-center mt-5">
                <p class="inline-block text-center text-text-white text-xs sm:text-base font-normal">{{ __('Can\'t find the game you want to sell? Contact our ' ) }}<p class="inline-block text-pink-500 text-xs sm:text-base font-normal ml-1">
                    {{ __(' customer support') }}</p> <p class="inline-block text-text-white text-xs sm:text-base font-normal">{{ __('  to suggest a game.') }}</p> </p>
            </div>
        @endif

        {{-- Step 3: Additional Details (Dynamic from game_configs) --}}
        @if ($step === 3)
            <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Sell Game ') . ucfirst($categoryName) }}
            </h2>
            <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 2/2') }}</h2>

            <form wire:submit.prevent="submitOffer">

                <div class="bg-bg-optional rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <h2 class="text-text-white font-semibold text-2xl sm:text-40px mb-4 sm:mb-10">{{ __('Your item') }}</h2>
                    <div class="bg-bg-info flex gap-4 items-center p-4 md-p-10 rounded-2xl">
                        <div>
                            <div class="w-10 h-10 sm:w-28 sm:h-28">
                                @if($game->logo)
                                 <img src="{{ storage_url($game->logo) }}" alt="{{ $game->logo}}"
                                    class="w-full h-full rounded-lg">
                                @else
                                <img src="{{ asset('assets/images/Rectangle 24589.png') }}" alt=""
                                    class="w-full h-full rounded-lg">
                                @endif
                            </div>
                        </div>
                        <h2 class="text-base sm:text-2xl text-text-white font-semibold">{{  $game->name }}</h2>
                    </div>
                </div>

                <div class="bg-bg-optional rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <h2 class="text-2xl font-semibold text-text-white mb-2 sm:mb-7">
                        {{ __('Specific Attributes') }}
                    </h2>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 justify-center mx-auto">
                        @foreach ($gameConfigs as $config)

                        
                            <div
                                class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">

                                {{-- Dropdown --}}
                                @if (in_array($config->filter_type, ['filter_by_select', 'select_dropdown']))
                                    <div>
                                    <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2"> </x-ui.label>
                                
                                    <x-ui.custom-select 
                                        :label="$config->field_name" 
                                        :options="json_decode($config->dropdown_values, true)" 
                                        :wireModel="'config_' . str_replace('-', '_', $config->slug)" 
                                        mdWidth="md:w-full" 
                                        rounded="rounded" 
                                        mdLeft="md:left-0" />

                                    <x-ui.input-error 
                                        :messages="$errors->get('config_' . str_replace('-', '_', $config->slug))" 
                                        class="mt-2" />
                                </div>

                                    {{-- Textarea --}}
                                @elseif (in_array($config->filter_type, ['textarea', 'filter_by_textarea']))
                                   <textarea 
                                    wire:model="config_{{ str_replace('-', '_', $config->slug) }}" 
                                    placeholder="{{ $config->field_name }}" 
                                    rows="4"
                                    class="w-full bg-zinc-700/50 text-text-white border-none focus:border-0 focus:ring-0 rounded-lg px-4 py-3">
                                </textarea>

                                    {{-- Number input --}}
                                @elseif (in_array($config->filter_type, ['filter_by_range', 'number']))
                                    <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2"/>
                                    <x-ui.input 
                                        id="name" 
                                        type="text"
                                        class="bg-bg-primary! text-text-primary! dark:text-text-primary! placeholder:text-text-primary! border border-zinc-700 focus:border-0! focus:ring-0! rounded-lg px-3 py-2"
                                        wire:model="config_{{ str_replace('-', '_', $config->slug) }}"
                                        placeholder="{{ $config->field_name }}" />

                                    {{-- Default text input --}}
                                @else
                                    <input 
                                        type="text" 
                                        wire:model="config_{{ str_replace('-', '_', $config->slug) }}"
                                        placeholder="{{ $config->field_name }}"
                                        class="w-full bg-zinc-700/50 text-text-white focus:border-0 focus:ring-0 rounded-lg px-4 py-3 border">
                                @endif

                                {{-- Validation errors (for non-dropdown fields) --}}
                                @if (!in_array($config->filter_type, ['filter_by_select', 'select_dropdown']))
                                    @error('config_' . str_replace('-', '_', $config->slug))
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($errors->any())
                        <div class="text-red-500 text-start mt-4 py-2 px-3 bg-bg-optional rounded">
                            @foreach ($errors->all() as $error)
                                <p class="text-sm badge badge-danger text-red-600">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="bg-bg-optional rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <!-- Quantity Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="w-full">
                            <x-ui.label for="price" :value="__('Price')" required />
                            <x-ui.input id="price" type="text"  wire:model="price"
                                placeholder="Price"  class="mt-2 block w-full text-text-primary placeholder:text-text-primary border border-zinc-700 focus:border-0 focus:ring-0 bg-bg-primary!" />
                            <x-ui.input-error :messages="$errors->get('price')" />
                        </div>
                        <div>
                            <x-ui.label for="stock_quantity" :value="__('Stock Quantity')" required />
                            <x-ui.input id="stock_quantity" type="text" class="mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border focus:border-0 focus:ring-0 bg-bg-primary!"
                                wire:model="stock_quantity" placeholder="stock_quantity" />
                            <x-ui.input-error :messages="$errors->get('stock_quantity')" />

                        </div>
                        <div>
                            <x-ui.label for="platform" :value="__('Platform')" required class="mb-2" />
                           <x-ui.custom-select :label="'Platform'" :options="$platforms" :wireModel="'platform'" mdWidth="md:w-full" rounded="rounded" mdLeft="md:left-0"  />
                            <x-ui.input-error :messages="$errors->get('platform')" />
                           
                        </div>
                    </div>
                    <div class="mt-20">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Description') }} <span
                                class="text-text-white text-base sm:text-xl font-normal">{{ __('(optional)') }}</span></h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="">
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                            <x-ui.textarea wire:model="description" placeholder="Type here......"
                                class="w-full bg-bg-primary! border-zinc-700 placeholder:text-text-primary " rows="5"></x-ui.textarea>
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                                <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>





                {{-- <div class="bg-bg-optional rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <h2 class="text-text-white font-semibold text-2xl sm:text-3xl">{{ __('Delivery method') }}</h2>
                    <div class="border-t border-zinc-500 mb-4 sm:mb-10 mt-2"></div>

                    <div>
                        <h3 class="text-text-white text-lg sm:text-xl font-medium mb-6">{{ __('Select delivery method') }}</h3>

                        <div class="space-y-4">

                            <div class="space-y-4">
                                @foreach ($deliveryMethods as $method)

                            
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="delivery_method"
                                            wire:model="deliveryMethod" value="{{ $method['value'] }}"
                                            class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                                        <span class="ml-3 text-text-white text-base transition-colors">
                                            {{ $method['label'] }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div> --}}
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
