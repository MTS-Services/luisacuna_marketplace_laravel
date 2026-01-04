<section class="mx-auto bg-bg-primary">
    <div class="container mx-auto">
        {{-- breadcrumb --}}
        <div class="flex gap-4 items-center py-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            <h2 class="text-text-white text-base">
                {{ __('All Orders') }}

            </h2>
        </div>
        <div class="flex justify-between">
            <div class="flex gap-5">
                <div>
                    <div class="w-10 h-10 md:w-16 md:h-16">
                        <x-cloudinary::image public-id="{{ $order?->source?->game?->logo }}" width="50"
                            height="50" crop="scale" sizes="100vw" alt="{{ $order?->source?->game?->name }}"
                            class="rounded" />
                    </div>
                </div>
                <div>
                    <h2 class="text-text-white text-2xl font-semibold line-clamp-1">
                        {{ $order?->source?->name }}
                    </h2>
                    <p class="text-text-white font-normal text-base line-clamp-1">
                        {{ __('Order ID:') }} {{ $order->order_id }}
                    </p>
                </div>
            </div>
            <div>
                @if ($isVisitSeller)
                    <x-ui.button wire:click="cancelOrder"
                        class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
                        {{ __('Cancel') }}
                    </x-ui.button>
                @else
                    <x-ui.button wire:click="cancelOrder"
                        class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
                        {{ __('Dispute') }}
                    </x-ui.button>
                @endif

            </div>
        </div>
        <div class="block lg:flex gap-6 justify-between items-start">
            <div class="w-full lg:w-2/3">
                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-[20px]">
                    <div class="flex gap-4 items-center">
                        <div class="bg-bg-info rounded-full p-3">
                            <x-phosphor name="check" variant="regular" class="w-9 h-9 text-zinc-400" />
                        </div>
                        <div>
                            <h3 class="text-text-white text-base sm:text-2xl font-semibold">
                                {{ $order->status->label() }}
                            </h3>
                            <p class="text-text-white text-xs font-normal mt-2">{{ dateTimeFormat($order->created_at) }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-7">
                        <p class="text-text-white text-base font-normal mb-2">
                            {{ $order->notes ?? __('No notes') }}</p>
                    </div>
                </div>

                <div class=" bg-bg-secondary p-4 sm:p-10 rounded-[20px] mt-6">
                    <div class="flex gap-4 items-center">
                        <div>
                            <h3 class="text-text-white text-base sm:text-2xl font-semibold">{{ __('Buyer feedback') }}
                            </h3>
                        </div>
                    </div>
                    <div class="bg-bg-info flex items-center gap-2 rounded-lg py-3 px-6 mt-7">
                        <x-phosphor name="thumbs-up" variant="solid" class="w-5 h-5 fill-zinc-700" />
                        <p class="text-text-white text-base font-normal">
                            {{ __('GGWP!') }}</p>
                    </div>
                </div>

                <div class="bg-bg-info rounded-lg mt-10">
                    <!-- User Header -->
                    <livewire:backend.user.chat.message :key="'message-' . $conversationId" />
                </div>
            </div>
            <div class="w-full lg:w-1/3">
                <div class="bg-bg-secondary rounded-[20px] p-7 mb-6 mt-6 md:mt-0">
                    <p class="text-2xl font-semibold mb-6">{{ __('Delivery time') }}</p>

                    {{-- <div class="flex items-center justify-between text-center">
                        <!-- Hours -->
                        <div class="flex-1">
                            <p class="text-3xl text-text-white font-semibold">7</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Hours') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Minutes -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">59</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Minutes') }}</p>
                        </div>

                        <!-- Divider -->
                        <div class="w-px h-16 bg-zinc-700"></div>

                        <!-- Seconds -->
                        <div class="flex-1">
                            <p class="text-3xl font-semibold">52</p>
                            <p class="text-xl text-text-white font-normal mt-1">{{ __('Seconds') }}</p>
                        </div>
                    </div> --}}
                    <div class="flex items-center justify-between text-center">
                        <div class="flex-1">
                            {{ $order?->source?->delivery_timeline }}
                        </div>
                    </div>
                </div>

                <div class="bg-bg-secondary p-4 sm:p-7 mt-10 lg:mt-0 rounded-[20px]">
                    <div class="flex gap-4 items-center">
                        <h3 class="text-text-white text-2xl font-semibold">{{ __('Order Details') }}</h3>
                    </div>
                    <div class="">
                        <div class="flex justify-between mt-7">
                            <p class="text-text-white text-base font-semibold">{{ __('Game') }}</p>
                            <div class="flex gap-2 items-center">
                                <div>
                                    <div class="w-6 h-6">
                                        <x-cloudinary::image public-id="{{ $order?->source?->game?->logo }}"
                                            width="50" height="50"
                                            class="w-full h-full object-cover rounded-full" />

                                    </div>
                                </div>
                                <p class="text-text-white text-base font-normal">{{ $order?->source?->game?->name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold">{{ __('Username') }}</p>
                            <a href="{{ route('profile', $order?->user?->username) }}"
                                class="text-text-white text-base font-normal">
                                {{ $order?->user->username }}</a>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold">{{ __('Device') }}</p>
                            <p class="text-text-white text-base font-normal">{{ $order?->source?->platform?->name }}
                            </p>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-text-white text-base font-semibold">{{ __('Seller') }}</p>
                            <p class="flex items-center gap-2 text-base font-normal">
                                <a href="{{ route('profile', $order?->source?->user?->username) }}"
                                    class="text-pink-500 inline-block">{{ $order?->source?->user?->username }}</a>
                                <span class="text-text-white">|</span>
                                <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                <span class="text-text-white">{{ __('Online') }}</span>
                            </p>

                        </div>
                    </div>
                    <div class="flex w-full md:w-auto justify-center items-center mt-10!">

                        <x-ui.button class="w-fit! py-3! px-6!"
                            href="{{ route('user.order.detail', ['orderId' => $order->order_id]) }}">
                            {{ __('View full description') }}
                            <x-phosphor-arrow-right-light
                                class="w-5 h-5 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" /></x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-10"></div>
</section>
