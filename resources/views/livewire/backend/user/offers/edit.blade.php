<div class="bg-bg-primary">
    <div class="container pb-10">
        <livewire:frontend.partials.breadcrumb :gameSlug="$offer->game->slug" :categorySlug="$offer->category->slug" />

        <div class="w-full mx-auto rounded-2xl">
            <h2 class="text-2xl sm:text-40px font-semibold text-center text-text-white mb-3">
                {{ __('Edit ') . ucfirst($offer->category->name) . __(' Offer') }}
            </h2>

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
                {{-- Offer Title Section --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Offer Title') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4"></div>
                        <div>
                            <p class="text-text-white text-base font-normal text-end mb-2">
                                {{ strlen($name ?? '') }}/200
                            </p>
                            <x-ui.textarea wire:model="name" placeholder="Type here......"
                                class="w-full bg-bg-info! placeholder:text-text-primary border-0!" rows="5"
                                maxlength="200">{{ $name }}</x-ui.textarea>
                            <x-ui.input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('Provide a descriptive title for your product. Consider the keywords buyers might use to find it. Place the most searchable words at the beginning of your title. The title must not exceed 200 characters.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">
                            {{ __('Description') }}
                            <span class="text-text-white text-base sm:text-xl font-normal">{{ __('(optional)') }}</span>
                        </h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4"></div>
                        <div>
                            <p class="text-text-white text-base font-normal text-end mb-2">
                                {{ strlen($description ?? '') }}/500
                            </p>
                            <x-ui.textarea wire:model="description" placeholder="Type here......"
                                class="w-full bg-bg-info! border-zinc-700 placeholder:text-text-primary border-0"
                                rows="5" maxlength="500">{{ $description }}</x-ui.textarea>
                            <x-ui.input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('The listing title and description must be accurate and as informative as possible (no random or lottery). Misleading description is a violation of our ') }}
                                <span class="text-pink-500">{{ __('Seller Rules.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Delivery Section --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <h2 class="text-text-white font-semibold text-2xl sm:text-3xl">
                        {{ __('Delivery') }}
                    </h2>
                    <div class="border-t border-zinc-500 pt-4 mt-4"></div>

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

                        <x-ui.input-error :messages="$errors->get('deliveryMethod')" class="mt-2" />
                    </div>

                    <h3 class="text-text-white text-lg sm:text-xl font-medium mb-6 mt-6">
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

                {{-- Quantity & Pricing Section --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div class="mt-8">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Pricing & Stock') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4"></div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="w-full">
                                <x-ui.label for="price" :value="__('Price')" required />
                                <x-ui.input id="price" type="number" step="0.01" min="1"
                                    wire:model="price" placeholder="Price"
                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border-0! focus:ring-0" />
                                <x-ui.input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-ui.label for="quantity" :value="__('Stock Quantity')" required />
                                <x-ui.input id="quantity" type="number" min="1"
                                    class="bg-bg-info! mt-2 border-zinc-700 text-text-info placeholder:text-text-primary border-0! focus:ring-0"
                                    wire:model="quantity" placeholder="Quantity" />
                                <x-ui.input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                            <div>
                                <x-ui.label for="platform" :value="__('Platform')" required class="mb-2" />
                                <x-ui.custom-select :wireModel="'platform_id'" :dropDownClass="'border-0!'"
                                    class="rounded-md! border-0! bg-bg-info!" :label="$platforms->firstWhere('id', $platform_id)?->name ?? 'Select Platform'">
                                    @foreach ($platforms as $platform)
                                        <x-ui.custom-option :value="$platform->id" :label="$platform->name" />
                                    @endforeach
                                </x-ui.custom-select>
                                <x-ui.input-error :messages="$errors->get('platform_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Specific Attributes Section --}}
                @if ($gameConfigs->isNotEmpty() && $gameConfigs->whereNotNull('input_type')->isNotEmpty())
                    <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                        <h2 class="text-2xl font-semibold text-text-white mb-2 sm:mb-7">
                            {{ __('Specific Attributes') }}
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 justify-center mx-auto">
                            @foreach ($gameConfigs as $config)
                                @if ($config->input_type == null)
                                    @continue
                                @endif
                                @php
                                    $wireModel = 'fields.' . $config->id . '.value';
                                    $colSpanClass = in_array($config->filter_type, ['textarea', 'filter_by_textarea'])
                                        ? 'col-span-2'
                                        : '';
                                    // Get current value from fields array
                                    $currentValue = $fields[$config->id]['value'] ?? '';
                                @endphp

                                {{-- Dropdown --}}
                                @if ($config->input_type == App\Enums\GameConfigInputType::SELECT_DROPDOWN)
                                    <div class="{{ $colSpanClass }}">
                                        <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2" />

                                        @php
                                            $options = is_array($config->dropdown_values)
                                                ? $config->dropdown_values
                                                : json_decode($config->dropdown_values, true);

                                            // Find the label for current value
                                            $currentLabel = 'Select ' . $config->field_name;
                                            if ($currentValue) {
                                                foreach ($options as $key => $option) {
                                                    $optionValue = is_array($option) ? $option['label'] : $option;
                                                    if ($optionValue == $currentValue) {
                                                        $currentLabel = is_array($option) ? $option['label'] : $option;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp

                                        <x-ui.custom-select :wireModel="$wireModel" class="rounded-md! border-0! bg-bg-info!"
                                            mdWidth="md:w-full" rounded="rounded" mdLeft="md:left-0" :label="$currentLabel">
                                            @foreach ($options as $key => $option)
                                                <x-ui.custom-option :value="is_array($option) ? $option['label'] : $option" :label="is_array($option) ? $option['label'] : $option" />
                                            @endforeach
                                        </x-ui.custom-select>

                                        <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                    </div>

                                    {{-- Textarea --}}
                                @elseif (in_array($config->input_type, ['textarea']))
                                    <div class="{{ $colSpanClass }}">
                                        <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" :label="$config->field_name"
                                            class="mb-2" />
                                        <textarea wire:model="{{ $wireModel }}" placeholder="{{ $config->field_name }}" rows="4"
                                            class="w-full bg-bg-info! text-text-white border-none rounded-lg px-4 py-3">{{ $currentValue }}</textarea>
                                        <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                    </div>

                                    {{-- Number input --}}
                                @elseif ($config->input_type == App\Enums\GameConfigInputType::NUMBER)
                                    <div class="{{ $colSpanClass }}">
                                        <x-ui.label :for="$wireModel" :value="$config->field_name" class="mb-2" />
                                        <x-ui.input type="number"
                                            class="bg-bg-info! text-text-primary! dark:text-text-primary! placeholder:text-text-primary! border-0! border-zinc-700 rounded-lg px-3 py-2"
                                            wire:model="{{ $wireModel }}" value="{{ $currentValue }}"
                                            placeholder="{{ $config->field_name }}" />
                                        <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                    </div>

                                    {{-- Default text input --}}
                                @else
                                    @if ($config->delivery_methods == null)
                                        <div class="{{ $colSpanClass }}">
                                            <x-ui.label :for="'config_' . str_replace('-', '_', $config->slug)" :value="$config->field_name" class="mb-2" />
                                            <x-ui.input type="text" placeholder="{{ $config->field_name }}"
                                                wire:model="{{ $wireModel }}" value="{{ $currentValue }}"
                                                class="bg-bg-info! mt-2 border-zinc-700 text-text-primary placeholder:text-text-primary border-0!" />
                                            <x-ui.input-error :messages="$errors->get($wireModel)" class="mt-2" />
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Fee Structure Section --}}
                <div class="bg-bg-secondary rounded-2xl mb-10 p-4 sm:p-10 md:p-20">
                    <div>
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Fee Structure') }}</h2>
                        <div class="border-t border-zinc-500 pt-4 mt-4"></div>
                        <div>
                            <p class="text-text-white text-base sm:text-xl font-normal mt-5">
                                {{ __('Flat fee (per purchase): ') }}
                                <span class="text-2xl font-semibold">{{ __('$0.00 USD') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-10 flex gap-4">
                    <x-ui.button type="submit" class="w-auto! py-2!">
                        {{ __('Update Offer') }}
                    </x-ui.button>
                    <a href="{{ route('user.user-offer.category', $offer->category->slug) }}"
                        class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
