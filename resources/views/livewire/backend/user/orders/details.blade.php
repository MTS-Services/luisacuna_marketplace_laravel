<div class="bg-bg-primary">
    <div class="container">
        <div class="flex gap-4 items-center pt-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <a wire:navigate  href="{{ url()->previous() }}" class="text-text-white text-base">
                {{ __('Back') }}
            </a>
        </div>
        <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-lg mt-10">
            <div class="flex mt-7">
                <div class="flex gap-2">
                    <div>
                        <div class="w-10 h-10 md:w-16 md:h-16">
                            <img src="{{ storage_url($data?->source?->game?->logo) }}" alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}"
                                class="rounded" />
                        </div>
                    </div>
                    <p class="text-text-white text-3xl font-semibold">{{ $data?->source?->game?->translatedName(app()->getLocale()) }}</p>
                </div>
            </div>
            <div class="bg-bg-info p-7 rounded-lg mt-10">
                <div class="flex gap-5">
                    <div>
                        <div class="w-10 h-10">
                            <img src="{{storage_url( $data?->source?->game?->logo) }}"  alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}"
                                class="rounded" />
                        </div>
                    </div>
                    <div>
                        <h2 class="text-text-white text-base sm:text-2xl font-semibold line-clamp-1 ">
                            {{ $data?->source?->translatedName(app()->getLocale()) }}
                        </h2>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Username') }}</p>
                        <p class="text-text-white text-base font-normal">{{ $data?->user?->username }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Device') }}</p>
                        <p class="text-text-white text-base font-normal">{{ $data?->source?->platform?->name }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Quantity') }}</p>
                        <p class="text-text-white text-base font-normal">{{ $data?->quantity }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Guaranteed delivery time') }}
                        </p>
                        <p class="text-text-white text-base font-normal">{{ $data?->source?->translatedDeliveryTimeline(app()->getLocale()) }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Delivery method') }}</p>
                        <p class="text-text-white text-base font-normal">{{ $data?->source?->translatedDeliveryMethod(app()->getLocale()) }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <div class="w-auto h-auto sm:w-[400px] sm:h-[400px]">
                    <img src="{{ storage_url( $data?->source?->game?->logo) }}" alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}" class="rounded w-full h-full" />
                </div>
            </div>
            <div x-data="{
                isExpanded: false,
                isOverflow: false
            }" x-init="$nextTick(() => {
                const el = $refs.desc;
                isOverflow = el.scrollHeight > el.clientHeight;
            })" class="mt-10">
                <h1 class="text-text-white text-2xl font-bold mb-6">
                    {{ __('Description') }}
                </h1>

                <div x-show="!isExpanded">
                    <p x-ref="desc" class="line-clamp-2">
                        {{ $data?->source?->translatedDescription(app()->getLocale()) }}
                    </p>

                    <div x-show="isOverflow" class="flex w-fit mt-3">
                        <x-ui.button @click="isExpanded = true" class="w-fit! py-3!">
                            {{ __('Read more') }}
                        </x-ui.button>
                    </div>
                </div>

                <div x-show="isExpanded" x-transition>
                    <p>
                        {{ $data?->source?->translatedDescription(app()->getLocale()) }}
                    </p>

                    <div class="flex w-fit mt-3">
                        <x-ui.button @click="isExpanded = false" class="w-fit! py-3!">
                            {{ __('Read less') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>

        </div>
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-20">
            <h2 class="text-text-white text-2xl font-semibold">{{ __('Seller') }}</h2>
            <div class="mt-3">
                @if ($isVisitSeller)
                    <div class="pt-4 mt-4 flex items-center gap-5">
                        <div class="w-14 h-14">
                            <img src="{{ auth_storage_url( $data?->user?->avatar) }}" 
                                alt="{{ $data?->user?->full_name }}" class="rounded" />
                        </div>
                        <div>
                            <a href="{{ route('profile', $data?->user?->username) }}" target="_blank" class="font-semibold ">{{ $data?->user?->full_name }}</a>
                        </div>
                    </div>
                @else
                    <div class="pt-4 mt-4 flex items-center gap-5">
                        <div class="w-14 h-14">
                            <img src="{{ auth_storage_url($data?->source?->user?->avatar) }}" 
                                alt="{{ $data?->source?->user?->full_name }}" class="rounded" />
                        </div>
                        <div>
                            <a href="{{ route('profile', $data?->source?->user?->username) }}" target="_blank" class="font-semibold ">{{ $data?->source?->user?->full_name }}</a>
                            <p class="text-sm text-text-white "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                 {{ feedback_calculate($positiveFeedbacksCount, $negativeFeedbacksCount) }} % {{ __(' | ')}}  {{ $data?->feedback?->count() ?? 0 }} {{ __(' reviews | ') }} {{ $data?->count() ?? 0 }} {{ __('Sold') }} </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-20">
            <h2 class="text-text-white text-2xl font-semibold">{{ __('Payment') }}</h2>
            <div class="flex justify-between mt-3">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Total price') }}</p>
                <p class="text-text-white text-base font-normal">
                    {{ currency_symbol() }}{{ currency_exchange($data?->total_amount) }}
                </p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Payment fee') }}</p>
                <p class="text-text-white text-base font-normal">
                    {{ currency_symbol() }}{{ currency_exchange($data?->tax_amount) }}
                </p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Quantity') }}</p>
                <p class="text-text-white text-base font-normal">{{ $data?->quantity }}</p>
            </div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-base font-semibold mb-2">{{ __('Guaranteed delivery time') }}
                </p>
                <p class="text-text-white text-base font-normal">{{ $data?->source?->translatedDeliveryTimeline(app()->getLocale()) }}</p>
            </div>
            <div class="border-t border-zinc-500 pt-4 mt-4 flex items-center gap-3"></div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-2xl font-semibold mb-2">{{ __('Total:') }}</p>
                <p class="text-text-white text-base font-normal">
                    {{ currency_symbol() }}
                    {{ currency_exchange($data?->grand_total) }}
                </p>

            </div>
        </div>
    </div>
    <div class="pb-10"></div>
</div>
