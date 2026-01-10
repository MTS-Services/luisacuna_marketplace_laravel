<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="'currency'" :categorySlug="'sell currency'" />
        <div class="w-full mx-auto rounded-2xl ">

            <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Sell Game ') . ucfirst($offer->category->name) }}
            </h2>
            {{-- <h2 class="text-xl sm:text-2xl text-center text-text-white mb-5 sm:mb-10">{{ __('Step 2/2') }}</h2> --}}
            {{-- Selected Game Info --}}

                <div class="flex items-center justify-center gap-3 mb-5">
                    @if ($offer->game->logo)
                        <img src="{{ storage_url($offer->game->logo) }}" alt="{{ $offer->game->name }}"
                            class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg object-cover">
                    @endif
                    <span class="text-lg sm:text-xl font-semibold text-text-white">
                        {{ $offer->game->name }}
                    </span>
                </div>


            <form wire:submit.prevent="submitOffer" class="mt-10">
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Offer Title') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="">
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/200') }}</p>
                            <x-ui.textarea wire:model="name" placeholder="Type here......"
                                class="w-full bg-bg-info! placeholder:text-text-primary border-0!"
                                rows="5">{{$offer->name}}</x-ui.textarea>
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('Provide a descriptive title for your product. Consider the keywords buyers might use to find it. Place the most searchable words at the beginning of your title. The title must not exceed 160 characters.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Description') }}
                            <span class="text-text-white text-base sm:text-xl font-normal">{{ __('(optional)') }}</span>
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="">
                            <p class="text-text-white text-base font-normal text-end mb-2">{{ __('0/500') }}</p>
                            <x-ui.textarea wire:model="description" placeholder="Type here......"
                                class="w-full bg-bg-info! border-zinc-700 placeholder:text-text-primary border-0"
                                rows="5">{{$offer->description}}</x-ui.textarea>
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
                            @foreach ($offer->game->gameConfig as $config)
                                @if ($config->delivery_methods != null)
                                    <label class="flex items-center cursor-pointer group">
                                            <input type="radio" 
                                                value="manual"
                                                wire:model.live="deliveryMethod"
                                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                                            <span class="ml-3 text-text-white text-base transition-colors">
                                                Manual
                                            </span>
                                    </label>
                                    
                                    <label class="flex items-center cursor-pointer group">
                                            <input type="radio" name="delivery_method"
                                                value="instant"
                                                wire:model.live="deliveryMethod"
                                                class="w-5 h-5 accent-pink-500 bg-transparent border-2 border-zinc-700 cursor-pointer">
                                            <span class="ml-3 text-text-white text-base transition-colors">
                                               Auto
                                            </span>
                                    </label>

                                    @break
                                @endif
                            @endforeach
                            <x-ui.input-error :messages="$errors->get('deliveryMethod')" />
                        </div>
                          <h3 class="text-text-white text-lg sm:text-xl font-medium mb-6 mt-3">
                            {{ __('Guaranteed Delivery Time:') }}
                        </h3>
                        <div class="space-y-4">
                            <div class="">
                                @php 
                               
                                 $isInstantDelivery = $deliveryMethod == 'instant' ? $timelineOptions['instant'] : 'Choose';
                             
                                @endphp
                                <x-ui.custom-select :wireModel="'delivery_timeline'" :dropDownClass="'border-0!'" class="rounded-md! border-0 bg-bg-info!" label="{{ $isInstantDelivery }}">
                                   

                                    @foreach ($timelineOptions as $timelineOption)
                                     
                                        {{-- @dd($timelineOption) --}}
                                        <x-ui.custom-option :value="$timelineOption" :label="$timelineOption" />
                                    @endforeach
                                </x-ui.custom-select>
                            </div>
                        </div>
                    </div>

                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Quantity') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="w-full">
                                <x-ui.label for="price" :value="__('Price')" required />
                                <x-ui.input id="price" type="text" wire:model="price" placeholder="Price" value="{{ $offer->price }}"
                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-primary  placeholder:text-text-primary border-0! focus:ring-0" />
                                <x-ui.input-error :messages="$errors->get('price')" />
                            </div>
                            <div>
                                <x-ui.label for="quantity" :value="__('Stock Quantity')" required />
                                <x-ui.input id="quantity" type="text" value="{{ $offer->quantity }}"
                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-info placeholder:text-text-primary border-0! focus:ring-0"
                                    wire:model="quantity" placeholder="quantity" />
                                <x-ui.input-error :messages="$errors->get('quantity')" />

                            </div>
                            <div>
                                <x-ui.label for="platform" :value="__('Platform')" required class="mb-2" />
                                <x-ui.custom-select :wireModel="'platform_id'" :dropDownClass="'border-0!'"
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

                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <h2 class="text-2xl font-semibold text-text-white mb-2 sm:mb-7">
                        {{ __('Specific Attributes') }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 justify-center mx-auto">
                 
                        @foreach ($offer->game->gameConfig as $config)
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

                                        <x-ui.custom-select :wireModel="$wireModel" class="rounded-md! border-0! bg-bg-info!"
                                            mdWidth="md:w-full" rounded="rounded" mdLeft="md:left-0">
                                           
                                            @foreach ($options as $key => $option)
                                                <x-ui.custom-option :value="is_array($option) ? $option['value'] : $key" :label="is_array($option) ? $option['label'] : $option" />
                                            @endforeach
                                        </x-ui.custom-select>

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

                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Fee structure') }}
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
                        <div class="">
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


            {{-- Success Message --}}
            @if (session()->has('message'))
                <div class="mt-4 p-4 bg-green-600/20 border border-green-600 rounded-lg text-center text-text-white">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</div>
