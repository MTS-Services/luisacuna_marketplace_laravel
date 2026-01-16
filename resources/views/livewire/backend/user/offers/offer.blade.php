<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="'currency'" :categorySlug="'sell currency'" />
        <div class="w-full mx-auto rounded-2xl ">
            {{-- Step 1: Category Selection --}}
            @if ($step === 1)
                <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-2xl ">
                    <h1 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-2">
                        {{ __('Start selling') }}
                    </h1>
                    <h2 class="text-base sm:text-2xl text-center text-text-white mb-4 sm:mb-10">
                        {{ __('Choose category') }}
                    </h2>

                    <div class="space-y-4 sm:space-y-10">
                        @foreach ($categories as $category)
                            <button wire:click="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                                class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 sm:w-16 sm:h-16">
                                        @if ($category->icon)
                                            <img src="{{ storage_url($category->icon) }}"
                                                class="w-full h-full rounded-lg sm:rounded-xl object-cover"
                                                crop="scale" alt="{{ $category->name }}" />
                                        @else
                                            <img src="{{ storage_url('') }}" alt="{{ $category->name }}"
                                                class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                                        @endif
                                    </div>
                                    <span
                                        class="text-2xl sm:text-3xl font-semibold text-text-white">{{ $category->translatedName(app()->getLocale()) }}</span>
                                </div>

                                <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                                    <path
                                        d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                    </path>
                                </svg>
                            </button>
                        @endforeach
                        <a href="{{ route('user.bulk-upload.category') }}"
                            class="w-full flex items-center justify-between p-4 bg-bg-info hover:bg-zinc-700/30 transition rounded-xl">

                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 sm:w-16 sm:h-16">
                                    <img src="{{ asset('assets/images/bulk-upload.png') }}" alt="Category Name"
                                        class="w-full h-full rounded-lg sm:rounded-xl object-cover">
                                </div>

                                <span
                                    class="text-2xl sm:text-3xl font-semibold text-text-white">{{ __('Bulk Upload') }}</span>
                            </div>

                            <svg class="w-6 h-6 fill-white" viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128, 90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Step 2: Game Selection --}}
            @if ($step === 2)
                <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-2xl">
                    <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">

                        {{ __('Sell') }} {{ $categoryName }}

                    </h2>
                    <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 1/2') }}</h2>

                    <div class="p-5 sm:p-10 bg-bg-info rounded-2xl">
                        <h2 class="text-2xl font-semibold text-center text-text-white mb-2 sm:mb-7">
                            {{ __('Choose Game') }}
                        </h2>

                        <div class="mx-auto w-full sm:w-1/2">
                            <x-ui.custom-select :wireModel="'gameId'" :dropDownClass="'border-0!'"
                                class="rounded-md! border-0! bg-bg-info!" label="Select Game">

                                @foreach ($games as $item)
                                    <x-ui.custom-option :value="$item->id" :label="$item->name" />
                                @endforeach
                            </x-ui.custom-select>
                        </div>
                        @error('gameId')
                            <p class="text-pink-500 text-center mt-2">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="flex gap-4 justify-center mt-5! sm:mt-10!">
                        <div class="flex md:w-auto! ">
                            <x-ui.button class="w-fit! py-2! px-4! text-white">{{ __('Back') }}</x-ui.button>
                        </div>
                        @if (count($games) > 0)
                            <div wire:click="selectGame" class="flex md:w-auto! ">
                                <x-ui.button class="w-fit! py-2! px-4!">{{ __('Next') }}</x-ui.button>
                            </div>
                        @endif
                    </div>
                    <div class="text-center mt-5">
                        <p class="inline-block text-center text-text-white text-xs sm:text-base font-normal">
                            {{ __('Can\'t find the game you want to sell? Contact our ') }}
                        <p class="inline-block text-pink-500 text-xs sm:text-base font-normal ml-1">
                            {{ __(' customer support') }}</p>
                        <p class="inline-block text-text-white text-xs sm:text-base font-normal">
                            {{ __('  to suggest a game.') }}</p>
                        </p>
                    </div>
                </div>
            @endif

            {{-- Step 3: Additional Details (Dynamic from game_configs) --}}
            @if ($step === 3)
                <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                    {{ __('Sell Game ') . ucfirst($categoryName) }}
                </h2>
                {{-- <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 2/2') }}</h2> --}}
                {{-- Selected Game Info --}}
                @if ($gameId && $games->firstWhere('id', $gameId))
                    @php
                        $selectedGame = $games->firstWhere('id', $gameId);
                    @endphp
                    <div class="flex items-center justify-center gap-3 mb-5">
                        @if ($selectedGame->logo)
                            <img src="{{ storage_url($selectedGame->logo) }}" alt="{{ $selectedGame->name }}"
                                class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover" crop="scale" />
                        @endif
                        <span class="text-lg sm:text-xl font-semibold text-text-white">
                            {{ $selectedGame->name }}
                        </span>
                    </div>
                @endif

                <form wire:submit.prevent="submitOffer" class="mt-10">
                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <div class="mt-8">
                            <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Offer Title') }}</h2>
                            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                            <div class="">
                                <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/200') }}</p>
                                <x-ui.textarea wire:model="name" placeholder="{{ __('Type here......') }}"
                                    class="w-full bg-bg-info! placeholder:text-text-primary border-0!"
                                    rows="5"></x-ui.textarea>
                                <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                    {{ __('Provide a descriptive title for your product. Consider the keywords buyers might use to find it. Place the most searchable words at the beginning of your title. The title must not exceed 160 characters.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <div class="mt-8">
                            <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Description') }}
                                <span
                                    class="text-text-white text-base sm:text-xl font-normal">{{ __('(optional)') }}</span>
                            </h2>
                            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                            <div class="">
                                <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                                <x-ui.textarea wire:model="description" placeholder="{{ __('Type here......') }}"
                                    class="w-full bg-bg-info! border-zinc-700 placeholder:text-text-primary border-0"
                                    rows="5"></x-ui.textarea>
                                <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                    {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                                    <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <h2 class="text-text-white font-semibold text-2xl sm:text-3xl">
                            {{ __('Delivery') }}
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>

                        <div class="space-y-4">
                            @foreach ($gameConfigs as $config)
                                @if ($config->delivery_methods != null)
                                    @foreach ($config->delivery_methods as $delivery_method)
                                        <label class="flex items-center cursor-pointer group">
                                            <input type="radio" value="{{ $delivery_method }}"
                                                wire:model.live="deliveryMethod"
                                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                                            <span class="ml-3 text-text-white text-base transition-colors">
                                                {{ $delivery_method == 'instant' ? 'Instant Delivery' : 'Manual' }}
                                            </span>
                                        </label>
                                    @endforeach
                                @endif
                            @endforeach
                            <x-ui.input-error :messages="$errors->get('deliveryMethod')" />
                        </div>
                        <h3 class="text-text-white text-lg sm:text-xl font-medium mb-6 mt-4">
                            {{ __('Guaranteed Delivery Time:') }}
                        </h3>
                        <div class="space-y-4">
                            @if (!empty($timelineOptions))
                                <x-ui.custom-select :wireModel="'delivery_timeline'" :dropDownClass="'border-0!'"
                                    class="rounded-md! border-0 bg-bg-info!" :label="$timelineOptions[$delivery_timeline] ?? ($delivery_timeline ?? 'Choose')">
                                    @foreach ($timelineOptions as $key => $timelineOption)
                                        <x-ui.custom-option :value="$key" :label="$timelineOption" />
                                    @endforeach
                                </x-ui.custom-select>
                                <x-ui.input-error :messages="$errors->get('delivery_timeline')" class="mt-2" />
                            @else
                                <p class="text-text-primary">{{ __('Please select a delivery method first') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <div class="mt-8">
                            <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Quantity') }}</h2>
                            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="w-full">
                                    <x-ui.label for="price" :value="__('Price')" required />
                                    <x-ui.input id="price" type="number" wire:model="price" placeholder="Price"
                                        class="bg-bg-info! mt-2 border-zinc-700 text-text-primary  placeholder:text-text-primary border-0! focus:ring-0" />
                                    <x-ui.input-error :messages="$errors->get('price')" />
                                </div>
                                <div>
                                    <x-ui.label for="quantity" :value="__('Stock Quantity')" required />
                                    <x-ui.input id="quantity" type="number"
                                        class="bg-bg-info! mt-2 border-zinc-700 text-text-info placeholder:text-text-primary border-0! focus:ring-0"
                                        wire:model="quantity" placeholder="quantity" />
                                    <x-ui.input-error :messages="$errors->get('quantity')" />

                                </div>
                                <div>
                                    <x-ui.label for="platform" :value="__('Platform')" required class="mb-2" />
                                    <x-ui.custom-select :wireModel="'platform_id'" :dropDownClass="'border-0!'" label="Select Platform"
                                        class="rounded-md! border-0! bg-bg-info!">
                                        <x-ui.custom-option :value="null" :label="__('Delivery Timeline')" />
                                        @foreach ($platforms as $platform)
                                            <x-ui.custom-option :value="$platform->id" :label="$platform->name" />
                                        @endforeach
                                    </x-ui.custom-select>
                                    <x-ui.input-error :messages="$errors->get('platform_id')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($gameConfigs->isNotEmpty() && $gameConfigs->whereNotNull('input_type')->isNotEmpty())
                        <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                            <h2 class="text-2xl font-semibold text-text-white mb-2 sm:mb-7">
                                {{ __('Specific Attributes') }}
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 justify-center mx-auto">
                                @foreach ($gameConfigs as $config)
                                    {{-- Dropdown --}}
                                    @if ($config->input_type == App\Enums\GameConfigInputType::SELECT_DROPDOWN)
                                        <div
                                            class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                            <div>
                                                <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2">
                                                </x-ui.label>

                                                @php
                                                    $options = is_array($config->dropdown_values)
                                                        ? $config->dropdown_values
                                                        : json_decode($config->dropdown_values, true);
                                                    $wireModel = 'fields.' . $config->id . '.value';
                                                @endphp
                                                
                                                <x-ui.custom-select :wireModel="$wireModel" :wireLive="true"
                                                    class="rounded-md! border-0! bg-bg-info!" mdWidth="md:w-full"
                                                    rounded="rounded" mdLeft="md:left-0" :label="'Select ' . $config->field_name">
                                                    @foreach ($options as $key => $option)
                                                        <x-ui.custom-option :value="is_array($option) ? $option['label'] : $option" :label="is_array($option) ? $option['label'] : $option" />
                                                    @endforeach
                                                </x-ui.custom-select>

                                                {{-- <select class="w-full bg-bg-info! text-text-white border-none rounded-lg px-4 py-3" wire:model="{{ $wireModel }}">
                                                    <option value="null">Select {{ $config->field_name }}</option>
                                                    @foreach ($options as $key => $option)
                                                        <option value="{{ is_array($option) ? $option['label'] : $option }}">{{ is_array($option) ? $option['label'] : $option }}</option>
                                                    @endforeach
                                                </select> --}}

                                                <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                            </div>
                                        </div>
                                        {{-- Textarea --}}
                                    @elseif (in_array($config->input_type, ['textarea']))
                                        <div
                                            class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                            <textarea wire:model="config_{{ str_replace('-', '_', $config->slug) }}" placeholder="{{ $config->field_name }}"
                                                rows="4" class="w-full bg-bg-info! text-text-white border-none rounded-lg px-4 py-3">
                                </textarea>
                                        </div>

                                        {{-- Number input --}}
                                    @elseif ($config->input_type == App\Enums\GameConfigInputType::NUMBER)
                                        <div
                                            class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                            <x-ui.label :for="'fields.{{ $config->id }}.value'" :value="$config->field_name" class="mb-2" />
                                            <x-ui.input id="name" type="number"
                                                class="bg-bg-info! text-text-primary! dark:text-text-primary! placeholder:text-text-primary! border-0! border-zinc-700 rounded-lg px-3 py-2"
                                                wire:model="fields.{{ $config->id }}.value"
                                                placeholder="{{ $config->field_name }}" />
                                        </div>
                                        {{-- Default text input --}}
                                    @else
                                        @if ($config->delivery_methods == null)
                                            <div
                                                class="{{ in_array($config->filter_type, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                                <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2" />

                                                <x-ui.input type="text" placeholder="{{ $config->field_name }}"
                                                    wire:model="fields.{{ $config->id }}.value"
                                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border-0! bg-bg-primary!"
                                                    x-model="fields.{{ $config->id }}.value" />

                                                <x-ui.input-error :messages="$errors->get('fields.{{ $config->id }}.value')" class="mt-2" />
                                            </div>
                                        @endif
                                    @endif

                                    {{-- Validation errors (for non-dropdown fields) --}}

                                    @error("fields.{{ $config->id }}.value")
                                        <p class="text-pink-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                @endforeach
                            </div>

                            @if ($errors->any())
                                <div class="text-pink-500 text-start mt-4 py-2 px-3 bg-bg-primary rounded">
                                    @foreach ($errors->all() as $error)
                                        <p class="text-sm badge badge-danger text-pink-600">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <div>
                            <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Fee structure') }}
                            </h2>
                            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                            <div>
                                <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                    {{ __('Flat fee (per purchase): ') }} <span
                                        class="text-2xl font-semibold">{{ __('$0.00 USD') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
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
</div>
