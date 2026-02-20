<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="$gameSlug" :categorySlug="$categoryName" />
        <div class="w-full mx-auto rounded-2xl">
            <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Sell Game ') . ucfirst($categoryName) }}
            </h2>

            {{-- Selected Game Info --}}
            <div class="flex items-center justify-center gap-3 mb-5">
                @if ($gameLogo)
                    <img src="{{ storage_url($gameLogo) }}" alt="{{ $gameName }}"
                        class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover" />
                @endif
                <span class="text-lg sm:text-xl font-semibold text-text-white">
                    {{ $gameName }}
                </span>
            </div>

            <form wire:submit.prevent="submitOffer" class="mt-10">
                {{-- Offer Title --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Offer Title') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div>
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/200') }}</p>
                            <x-ui.textarea wire:model="name" placeholder="{{ __('Type here......') }}"
                                class="w-full bg-bg-info! placeholder:text-text-primary border-0!"
                                rows="5"></x-ui.textarea>
                            <x-ui.input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('Provide a descriptive title for your product. Consider the keywords buyers might use to find it. Place the most searchable words at the beginning of your title. The title must not exceed 160 characters.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Description') }}
                            <span class="text-text-white text-base sm:text-xl font-normal">{{ __('(optional)') }}</span>
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div>
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                            <x-ui.textarea wire:model="description" placeholder="{{ __('Type here......') }}"
                                class="w-full bg-bg-info! border-zinc-700 placeholder:text-text-primary border-0"
                                rows="5"></x-ui.textarea>
                            <x-ui.input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                                <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Delivery (only if game has delivery options) --}}
                @if ($hasDelivery)
                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <h2 class="text-text-white font-semibold text-2xl sm:text-3xl">
                            {{ __('Delivery') }}
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>

                        <div class="space-y-4">
                            @foreach ($availableDeliveryMethods as $method)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" value="{{ $method }}" wire:model.live="deliveryMethod"
                                        class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer"
                                        @if (count($availableDeliveryMethods) === 1) checked @endif>
                                    <span class="ml-3 text-text-white text-base transition-colors">
                                        {{ delivery_methods()[$method] ?? ucfirst($method) }}
                                    </span>
                                </label>
                            @endforeach
                            <x-ui.input-error :messages="$errors->get('deliveryMethod')" />
                        </div>

                        <h3 class="text-text-white text-lg sm:text-xl font-medium mb-6 mt-4">
                            {{ __('Guaranteed Delivery Time:') }}
                        </h3>
                        <div class="space-y-4" wire:loading.remove wire:target="deliveryMethod">
                            @if (!empty($timelineOptions))
                                <x-ui.custom-select :wireModel="'delivery_timeline'" :dropDownClass="'border-0!'"
                                    class="rounded-md! border-0 bg-bg-info!" :label="$timelineOptions[$delivery_timeline] ?? ($delivery_timeline ?? 'Choose')">
                                    @foreach ($timelineOptions as $key => $timelineOption)
                                        <x-ui.custom-option :value="$key" :label="$timelineOption" />
                                    @endforeach
                                </x-ui.custom-select>
                                <x-ui.input-error :messages="$errors->get('delivery_timeline')" class="mt-2" />
                            @else
                                <p class="text-text-primary bg-bg-info! p-2 rounded-md w-full mt-2 text-center">
                                    {{ __('Please select a delivery method first') }}</p>
                            @endif
                        </div>
                        <p wire:loading wire:target="deliveryMethod"
                            class="text-text-primary bg-bg-info! p-2 rounded-md w-full mt-2 text-center">
                            {{ __('Retrieving data...') }}
                        </p>
                    </div>
                @endif

                {{-- Quantity / Price / Platform --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Quantity') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="w-full">
                                <x-ui.label for="price" :value="__('Price')" required />
                                <x-ui.input id="price" type="number" wire:model="price" placeholder="Price"
                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border-0! focus:ring-0" />
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
                                    @foreach ($platforms as $platform)
                                        <x-ui.custom-option :value="$platform->id" :label="$platform->name" />
                                    @endforeach
                                </x-ui.custom-select>
                                <x-ui.input-error :messages="$errors->get('platform_id')" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Specific Attributes (game configs excluding delivery) --}}
                @if ($gameConfigs->isNotEmpty())
                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <h2 class="text-2xl font-semibold text-text-white mb-2 sm:mb-7">
                            {{ __('Specific Attributes') }}
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 justify-center mx-auto">
                            @foreach ($gameConfigs as $config)
                                @if ($config->input_type === App\Enums\GameConfigInputType::SELECT_DROPDOWN)
                                    <div
                                        class="{{ in_array($config->filter_type?->value, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                        <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2" />
                                        @php
                                            $options = is_array($config->dropdown_values)
                                                ? $config->dropdown_values
                                                : json_decode($config->dropdown_values, true);
                                            $wireModel = 'fields.' . $config->id . '.value';
                                        @endphp
                                        <x-ui.custom-select :wireModel="$wireModel" :wireLive="true"
                                            class="rounded-md! border-0! bg-bg-info!" mdWidth="md:w-full"
                                            rounded="rounded" mdLeft="md:left-0" :label="'Select ' . $config->field_name">
                                            @foreach ($options as $option)
                                                <x-ui.custom-option :value="is_array($option) ? $option['label'] : $option" :label="is_array($option) ? $option['label'] : $option" />
                                            @endforeach
                                        </x-ui.custom-select>
                                        {{-- ✅ Now outside the select component --}}
                                        <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                    </div>
                                @elseif ($config->input_type === App\Enums\GameConfigInputType::NUMBER)
                                    <div
                                        class="{{ in_array($config->filter_type?->value, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                        <x-ui.label :for="'fields.' . $config->id . '.value'" :value="$config->field_name" class="mb-2" />
                                        <x-ui.input type="number"
                                            class="bg-bg-info! text-text-primary! dark:text-text-primary! placeholder:text-text-primary! border-0! border-zinc-700 rounded-lg px-3 py-2"
                                            wire:model="fields.{{ $config->id }}.value"
                                            placeholder="{{ $config->field_name }}" />
                                        <x-ui.input-error :messages="$errors->get('fields.' . $config->id . '.value')" class="mt-2" />
                                    </div>
                                @else
                                    <div
                                        class="{{ in_array($config->filter_type?->value, ['textarea', 'filter_by_textarea']) ? 'col-span-2' : '' }}">
                                        <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2" />
                                        <x-ui.input type="text" placeholder="{{ $config->field_name }}"
                                            wire:model="fields.{{ $config->id }}.value"
                                            class="bg-bg-info! mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border-0! bg-bg-primary!" />
                                        <x-ui.input-error :messages="$errors->get('fields.' . $config->id . '.value')" class="mt-2" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Fee structure --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div>
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Fee structure') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div>
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('Flat fee (per purchase): ') }}
                                <span
                                    class="text-2xl font-semibold">{{ currency_symbol() . $flatFee . '  ' . currency_code() }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-10 flex gap-4">
                    <a href="{{ route('user.offers.create.games', $categorySlug) }}">
                        <x-ui.button type="button" class="w-auto! py-2!">{{ __('Back') }}</x-ui.button>
                    </a>
                    <x-ui.button type="submit" class="w-auto! py-2!">
                        {{ __('Place Offer') }}
                    </x-ui.button>
                </div>
            </form>

            @if (session()->has('message'))
                <div class="mt-4 p-4 bg-green-600/20 border border-green-600 rounded-lg text-center text-text-white">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</div>
