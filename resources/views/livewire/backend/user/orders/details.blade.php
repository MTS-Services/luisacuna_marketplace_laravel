<div class="bg-bg-primary">
    <div class="container">
        <div class="flex gap-4 items-center pt-10">
            <x-phosphor name="less-than" variant="regular" class="w-4 h-4 text-zinc-400" />
            @php
                $previous = url()->previous();
                $current = url()->current();
                $backUrl =
                    $previous === $current ? route('user.order.complete', ['orderId' => $data->order_id]) : $previous;
            @endphp

            <a wire:navigate href="{{ $backUrl }}" class="text-text-white text-base">
                {{ __('Back') }}
            </a>
        </div>

        {{-- Status Banner --}}
        <div class="bg-bg-secondary rounded-2xl p-4 sm:p-6 mt-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $data->status->color() }}">
                        {{ $data->status->label() }}
                    </span>
                    <span class="text-text-muted text-sm">
                        {{ __('Order') }} #{{ $data->order_id }}
                    </span>
                </div>

                @if ($autoCompletesIn)
                    <div class="flex items-center gap-2 text-sm">
                        <flux:icon name="clock" class="w-4 h-4 text-yellow-400" />
                        <span class="text-yellow-400 font-medium">
                            {{ __('Auto-completes :time', ['time' => $autoCompletesIn]) }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons Panel --}}
        {{-- @if (count($availableActions) > 0)
            <div class="bg-bg-secondary rounded-2xl p-4 sm:p-6 mt-4">
                <h3 class="text-text-white text-sm font-semibold mb-4 uppercase tracking-wider">
                    {{ __('Available Actions') }}
                </h3>
                <div class="flex flex-wrap gap-3">
                    @if (in_array('cancel_order', $availableActions))
                        <x-ui.button wire:click="cancelOrder" wire:confirm="{{ __('Are you sure you want to request cancellation?') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="x-circle" class="w-4 h-4" />
                            {{ __('Cancel Order') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('mark_delivered', $availableActions))
                        <x-ui.button wire:click="markDelivered" wire:confirm="{{ __('Confirm that you have delivered this order?') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="check-circle" class="w-4 h-4" />
                            {{ __('Mark as Delivered') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('confirm_delivery', $availableActions))
                        <x-ui.button wire:click="confirmDelivery" wire:confirm="{{ __('Confirm that you received the delivery? Funds will be released to seller.') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="check-badge" class="w-4 h-4" />
                            {{ __('Confirm Delivery') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('open_dispute', $availableActions))
                        <x-ui.button wire:click="openDispute" wire:confirm="{{ __('Open a dispute for this order? The auto-completion timer will be paused.') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="exclamation-triangle" class="w-4 h-4" />
                            {{ __('Open Dispute') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('escalate_to_support', $availableActions))
                        <x-ui.button wire:click="escalateToSupport" wire:confirm="{{ __('Escalate this to admin support? Chat will be locked.') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="shield-exclamation" class="w-4 h-4" />
                            {{ __('Escalate to Support') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('cancel_dispute', $availableActions))
                        <x-ui.button wire:click="cancelDispute" wire:confirm="{{ __('Cancel your dispute? The order will return to its previous state.') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="arrow-uturn-left" class="w-4 h-4" />
                            {{ __('Cancel Dispute') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('accept_cancel', $availableActions))
                        <x-ui.button wire:click="acceptCancel" wire:confirm="{{ __('Accept the cancellation? Buyer will be refunded.') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="check" class="w-4 h-4" />
                            {{ __('Accept Cancel') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('reject_cancel', $availableActions))
                        <x-ui.button wire:click="rejectCancel" wire:confirm="{{ __('Reject the cancellation request?') }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="x-mark" class="w-4 h-4" />
                            {{ __('Reject Cancel') }}
                        </x-ui.button>
                    @endif

                    @if (in_array('leave_review', $availableActions))
                        <x-ui.button href="{{ route('user.order.detail', $data->order_id) }}" class="w-auto! py-2! px-4!">
                            <flux:icon name="star" class="w-4 h-4" />
                            {{ __('Leave Review') }}
                        </x-ui.button>
                    @endif
                </div>
            </div>
        @endif --}}

        {{-- Escalated / Chat Locked Notice --}}
        @if ($data->status->isEscalated() || $data->is_escalated)
            <div class="bg-red-900/20 border border-red-700/40 rounded-2xl p-4 sm:p-6 mt-4">
                <div class="flex items-center gap-3">
                    <flux:icon name="lock-closed" class="w-5 h-5 text-red-400" />
                    <p class="text-red-300 text-sm font-medium">
                        @if ($data->status === \App\Enums\OrderStatus::ESCALATED)
                            {{ __('This order has been escalated to admin support. Chat is locked. Please wait for a resolution.') }}
                        @else
                            {{ __('This order is :status. No further actions are available.', ['status' => $data->status->label()]) }}
                        @endif
                    </p>
                </div>
            </div>
        @endif

        {{-- Product Details --}}
        <div class="bg-bg-secondary p-4 sm:p-10 md:p-20 rounded-lg mt-6">
            <div class="flex mt-7">
                <div class="flex gap-2">
                    <div>
                        <div class="w-10 h-10 md:w-16 md:h-16">
                            <img src="{{ storage_url($data?->source?->game?->logo) }}"
                                alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}"
                                class="rounded" />
                        </div>
                    </div>
                    <p class="text-text-white text-3xl font-semibold">
                        {{ $data?->source?->game?->translatedName(app()->getLocale()) }}</p>
                </div>
            </div>
            <div class="bg-bg-info p-7 rounded-lg mt-10">
                <div class="flex gap-5">
                    <div>
                        <div class="w-10 h-10">
                            <img src="{{ storage_url($data?->source?->game?->logo) }}"
                                alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}"
                                class="rounded" />
                        </div>
                    </div>
                    <div>
                        <h2 class="text-text-white text-base sm:text-2xl font-semibold line-clamp-1">
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
                        <p class="text-text-white text-base font-normal">
                            {{ $data?->source?->translatedDeliveryTimeline(app()->getLocale()) }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-white text-base font-semibold mb-2">{{ __('Delivery method') }}</p>
                        <p class="text-text-white text-base font-normal">
                            {{ $data?->source?->translatedDeliveryMethod(app()->getLocale()) }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <div class="w-auto h-auto sm:w-[400px] sm:h-[400px]">
                    <img src="{{ storage_url($data?->source?->game?->logo) }}"
                        alt="{{ $data?->source?->game?->translatedName(app()->getLocale()) }}"
                        class="rounded w-full h-full" />
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

        {{-- Seller Info --}}
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-10">
            <h2 class="text-text-white text-2xl font-semibold">{{ $isSeller ? __('Buyer') : __('Seller') }}</h2>
            <div class="mt-3">
                @php
                    $otherParty = $isSeller ? $data?->user : $data?->source?->user;
                @endphp
                <div class="pt-4 mt-4 flex items-center gap-5">
                    <div class="w-14 h-14">
                        <img src="{{ auth_storage_url($otherParty?->avatar) }}" alt="{{ $otherParty?->full_name }}"
                            class="rounded" />
                    </div>
                    <div>
                        <a href="{{ route('profile', $otherParty?->username) }}" target="_blank"
                            class="font-semibold">{{ $otherParty?->full_name }}</a>
                        <p class="text-sm text-text-white">
                            <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}"
                                alt="">
                            {{ feedback_calculate($positiveFeedbacksCount, $negativeFeedbacksCount) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="bg-bg-info px-4 sm:px-10 md:px-20 py-4 sm:py-10 rounded-2xl mt-10">
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
            <div class="border-t border-zinc-500 pt-4 mt-4"></div>
            <div class="flex justify-between mt-2">
                <p class="text-text-white text-2xl font-semibold mb-2">{{ __('Total:') }}</p>
                <p class="text-text-white text-base font-normal">
                    {{ currency_symbol() }}{{ currency_exchange($data?->grand_total) }}
                </p>
            </div>

            {{-- Resolution info --}}
            @if ($data->resolution_type)
                <div class="border-t border-zinc-500 pt-4 mt-4">
                    <h3 class="text-text-white text-lg font-semibold mb-2">{{ __('Resolution') }}</h3>
                    <div class="flex justify-between mt-2">
                        <p class="text-text-muted text-sm">{{ __('Type') }}</p>
                        <span
                            class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold {{ $data->resolution_type->color() }}">
                            {{ $data->resolution_type->label() }}
                        </span>
                    </div>
                    @if ($data->resolution_buyer_amount)
                        <div class="flex justify-between mt-2">
                            <p class="text-text-muted text-sm">{{ __('Refund to Buyer') }}</p>
                            <p class="text-green-400 text-sm font-medium">
                                ${{ number_format($data->resolution_buyer_amount, 2) }}</p>
                        </div>
                    @endif
                    @if ($data->resolution_seller_amount)
                        <div class="flex justify-between mt-2">
                            <p class="text-text-muted text-sm">{{ __('Payment to Seller') }}</p>
                            <p class="text-green-400 text-sm font-medium">
                                ${{ number_format($data->resolution_seller_amount, 2) }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="pb-10"></div>
</div>
