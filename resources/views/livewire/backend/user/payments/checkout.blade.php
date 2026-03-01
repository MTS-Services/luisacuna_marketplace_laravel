<div>
    <div class="bg-page">
        <div class="container mx-auto px-4 py-10 max-w-7xl rounded-2xl">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">
                <!-- 1. Order Summary & Payment Details -->
                <div class="col-span-1 lg:col-span-8 bg-zinc-50 dark:bg-bg-secondary rounded-xl p-6 lg:p-10">

                    <!-- Product Info Card -->
                    <div class="card bg-bg-primary rounded-2xl shadow-inner p-6">
                        <h2 class="text-2xl font-semibold text-text-white mb-4 border-b border-zinc-500 pb-3">
                            {{ __('1. Product info') }}
                        </h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="block xxs:flex gap-4">
                                    <div class="w-15 h-15">
                                        <img src="{{ storage_url($order->source?->game->logo) }}" alt=""
                                            class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div>
                                        <span class="text-text-white text-xl font-semibold">
                                            {{-- {{ $order->source?->name ?? 'Unknown' }} --}}
                                            {{ $order->source?->translatedName(app()->getLocale()) ?? 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-text-white font-bold text-2xl">
                                        {{ $displaySymbol }}{{ number_format($order->unit_price, 2) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-2 pt-3 flex items-center justify-between gap-2">
                                <div class="w-18 h-14 relative">
                                    <img src="{{ auth_storage_url($order->source?->user?->avatar) }}"
                                        class="w-14 h-14 rounded-full border-2 border-white" alt="profile" />
                                    <span
                                        class="absolute bottom-0 right-0 w-5 h-5 bg-green border-2 border-white rounded-full"></span>
                                </div>

                                <div class="w-full">
                                    <p class="text-text-white font-medium flex items-center gap-2">
                                        <span> {{ $order?->source?->user?->full_name }}</span>
                                        @if ($order->user?->isVerifiedSeller())
                                            <x-phosphor name="seal-check" variant="solid"
                                                class="fill-zinc-700 w-5 h-5" />
                                        @endif
                                    </p>

                                    <div class="flex items-center space-x-2 mt-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5 fill-zinc-500">
                                            <path
                                                d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                                        </svg>
                                        <p class="text-text-secondary text-xs">
                                            {{ feedback_calculate($positiveFeedbacksCount, $negativeFeedbacksCount) }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-5">
                        <h2 class="text-2xl font-semibold text-text-white mb-4 pb-3">{{ __('2. Order Summary') }}</h2>
                        <h5 class="text-text-white text-base font-semibold">{{ __('Order details') }}</h5>
                        <div class="mt-4">
                            @if ($order->source?->delivery_timeline)
                                <div class="flex justify-between mb-2">
                                    <p class="text-text-white font-base text-xs">{{ __('Delivery time:') }}</p>
                                    <p class="text-text-white font-base text-xs">
                                        {{ $order->source?->translatedDeliveryTimeline(app()->getLocale()) }}</p>
                                </div>
                            @endif
                            @if ($order->source?->platform)
                                <div class="flex justify-between mb-2">
                                    <p class="text-text-white font-base text-xs">{{ __('Platform:') }}</p>
                                    <p class="text-text-white font-base text-xs">{{ $order->source?->platform?->name }}
                                    </p>
                                </div>
                            @endif

                            @foreach ($order->source?->product_configs ?? [] as $config)
                                @if ($config->game_configs->field_name ?? false)
                                    <div class="flex justify-between mb-2">
                                        <p class="text-text-white font-base text-xs">
                                            {{ $config->game_configs->field_name }}</p>
                                        <p class="text-text-white font-base text-xs">{{ $config->value }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <h5 class="text-text-white text-base font-semibold mt-5">{{ __('Order details') }}</h5>
                        <div class="mt-4">
                            <div class="flex justify-between mb-2">
                                <p class="text-text-white font-base text-xs">{{ __('Email:') }}</p>
                                <p class="text-text-white font-base text-xs">{{ $order?->user?->email }}</p>
                            </div>
                            <div class="flex justify-between mb-2">
                                <p class="text-text-white font-base text-xs">{{ __('Username:') }}</p>
                                <p class="text-text-white font-base text-xs">{{ $order?->user?->username }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantee -->
                    <div class="px-6 py-5 border border-zinc-500 rounded-xl mt-6">
                        <div class="flex items-center gap-2 mt-4">
                            <x-phosphor name="shield-check" variant="variant" class="fill-zinc-700 w-5 h-5" />
                            <p class="text-text-white text-2xl font-semibold flex items-center gap-2 break-all">
                                <a href="#">{{ 'SWAPY.GG' }}</a> <span>{{ ' Guarantee' }}</span>
                            </p>
                        </div>
                        <p class="text-pink-500 text-base font-semibold mt-2">{{ __('Your money is always safe') }}</p>
                        <p class="text-text-white text-base font-normal mt-4">
                            {{ __('We hold your payment until you confirm you\'ve received what you paid for. If the seller can\'t complete the delivery or any other issue arises, your money is protected and will be fully refunded to your SWAPY.GG wallet.') }}
                        </p>
                    </div>
                </div>

                <!-- 2. Payment Gateways -->
                <div class="col-span-1 lg:col-span-4">
                    <div class="bg-zinc-50 dark:bg-bg-secondary rounded-xl p-10">
                        <h2 class="text-2xl font-semibold text-text-white mb-4 border-b border-zinc-500 pb-3">
                            {{ __('3. Choose Method') }}
                        </h2>

                        <form class="flex flex-col gap-3" wire:submit.prevent="processPayment">

                            @forelse ($gateways as $gatewayItem)
                                <div wire:click="$set('gateway', '{{ $gatewayItem->slug }}')"
                                    class="gateway-label flex items-center p-4 rounded-xl transition-all duration-300 border-2 cursor-pointer
                                    {{ $gatewayItem->slug === $gateway ? 'border-zinc-500 bg-bg-secondary' : 'border-none bg-bg-primary' }}">

                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center gap-3">
                                            @if ($gatewayItem->icon)
                                                <img src="{{ storage_url($gatewayItem->icon) }}" alt="{{ $gatewayItem->name }}" class="w-5 h-5 object-contain shrink-0" />
                                            @elseif ($gatewayItem->slug === 'stripe' || $gatewayItem->slug === 'card')
                                                <svg class="w-5 h-5 text-text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <rect x="2" y="5" width="20" height="14" rx="2"
                                                        stroke-width="2" />
                                                    <path d="M2 10h20" stroke-width="2" />
                                                </svg>
                                            @elseif($gatewayItem->slug === 'crypto')
                                                <span class="text-text-white text-lg font-bold">₿</span>
                                            @elseif($gatewayItem->slug === 'wallet')
                                                <svg class="w-5 h-5 text-text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 12V7H5a2 2 0 01-2-2V4a2 2 0 012-2h14v5"
                                                        stroke-width="2" />
                                                    <path d="M3 5v14a2 2 0 002 2h16v-5" stroke-width="2" />
                                                    <circle cx="18" cy="12" r="2" />
                                                </svg>
                                            @elseif ($gatewayItem->slug === 'now-payment')
                                                <svg class="w-5 h-5 text-text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M21 12V7H5a2 2 0 01-2-2V4a2 2 0 012-2h14v5"
                                                        stroke-width="2" />
                                                    <path d="M3 5v14a2 2 0 002 2h16v-5" stroke-width="2" />
                                                    <circle cx="18" cy="12" r="2" />
                                                </svg>
                                            @else
                                                <flux:icon name="banknotes" class="w-5 h-5 text-text-white shrink-0" />
                                            @endif
                                            <span
                                                class="text-base font-normal text-text-white">{{ $gatewayItem->name }}</span>
                                        </div>

                                        @if ($gatewayItem->slug === 'wallet' && $walletBalance !== null)
                                            <span
                                                class="text-sm font-medium {{ $walletBalance >= $order->grand_total ? 'text-green-400' : 'text-red-400' }}">
                                                ({{ $displaySymbol }}{{ number_format($walletBalance, 2) }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning shadow-lg rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>{{ __('No payment gateways are currently configured.') }}</span>
                                </div>
                            @endforelse

                            <!-- Price Breakdown -->
                            <div class="mt-6">
                                <div class="flex justify-between mb-2">
                                    <p class="text-text-white font-normal text-xs">{{ __('Subtotal:') }}</p>
                                    <p class="text-text-white font-semibold text-base">
                                        {{ $displaySymbol }}{{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <div class="flex gap-1 items-center">
                                        <p class="text-text-white font-normal text-xs">{{ __('Payment Fee') }}</p>
                                        <button type="button" onclick="openPaymentFeeModal()"
                                            class="focus:outline-none">
                                            <x-phosphor name="question" variant="variant"
                                                class="fill-zinc-200 w-5 h-5 cursor-pointer hover:fill-zinc-300 transition-colors" />
                                        </button>
                                    </div>
                                    <p class="text-text-white font-semibold text-base">
                                        {{ $displaySymbol }}{{ number_format($calculatedTaxAmount, 2) }}
                                    </p>
                                </div>

                                <div class="flex justify-between mb-2">
                                    <p class="text-text-white font-normal text-xs">{{ __('Wallet Balance') }}</p>
                                    <p class="text-text-white font-semibold text-base">
                                        {{ $displaySymbol }}{{ number_format($walletBalance ?? 0, 2) }}
                                    </p>
                                </div>
                                <div class="flex justify-between mb-2 border-t border-zinc-800">
                                    <p class="text-text-white font-normal text-xs">{{ __('Points') }}</p>
                                    <p class="text-text-white font-normal text-xs">
                                        {{ $order->points ?? 0 }}
                                    </p>
                                </div>
                            </div>

                            <!-- Payment Fee Modal -->
                            <div id="paymentFeeModal"
                                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80">
                                <div class="bg-bg-secondary rounded-2xl p-6 max-w-md w-full mx-4 relative">
                                    <button type="button" onclick="closePaymentFeeModal()"
                                        class="absolute top-4 right-4 text-text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <h2 class="text-text-white font-semibold text-2xl mb-4 pr-8">
                                        {{ __('Why do I Pay Payment Fee?') }}
                                    </h2>
                                    <p class="text-text-white font-normal text-base text-justify">
                                        {{ __('Payment fee is collected to pay for service related to the product, which is a standard practice in e-commerce and other industries. In detail, it is applied to cover services rendered to the consumer as well as administrative or processing costs, such as payment processing fee and 24/7 customer support.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Pay Button -->
                            <div class="mt-5">
                                <x-ui.button type="submit" wire:loading wire:target="processPayment"
                                    class="px-4! py-2! sm:px-6! sm:py-3!">
                                    {{ __('Processing...') }}
                                </x-ui.button>
                                <x-ui.button type="submit" wire:loading.remove wire:target="processPayment"
                                    class="px-4! py-2! sm:px-6! sm:py-3!">
                                    <span wire:loading wire:target="gateway">
                                        <flux:icon name="arrow-path"
                                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary animate-spin" />
                                    </span>
                                    <span wire:loading.remove wire:target="gateway"
                                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                        {{ $displayCurrency }} {{ number_format($calculatedGrandTotal, 2) }}
                                        {{ __('| Pay Now') }}
                                    </span>
                                </x-ui.button>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <x-phosphor name="shield-check" variant="variant" class="fill-zinc-500 w-6 h-6" />
                                <p class="text-text-white text-xs font-normal flex items-center gap-2">
                                    <span>{{ __('I accept the Terms of Service, Privacy Notice and Refund Policy.') }}</span>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function openPaymentFeeModal() {
                    document.getElementById('paymentFeeModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closePaymentFeeModal() {
                    document.getElementById('paymentFeeModal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                document.getElementById('paymentFeeModal')?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePaymentFeeModal();
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closePaymentFeeModal();
                    }
                });
            </script>
        @endpush
    </div>

    <!-- Top-Up Modal (Fixed) -->
    @if ($showTopUpModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 overflow-y-auto"
            wire:click.self="closeTopUpModal">
            <div class="bg-zinc-50 dark:bg-bg-secondary rounded-2xl shadow-2xl max-w-2xl w-full my-auto relative">

                <!-- Close Button -->
                <button type="button" wire:click="closeTopUpModal"
                    class="absolute top-6 right-6 text-text-secondary hover:text-text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header Section -->
                <div
                    class="p-5 lg:p-6 bg-gradient-to-br from-pink-500/10 to-transparent border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 rounded-lg bg-pink-500/20 flex-shrink-0">
                            <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-text-white font-bold text-xl">
                                {{ __('Amount Needed') }}
                            </h3>
                            <p class="text-text-secondary text-xs mt-0.5">
                                {{ __('Your wallet balance is insufficient') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="p-5 lg:p-6 space-y-5">

                    <!-- Calculation Breakdown -->
                    <div
                        class="bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl p-4 border border-zinc-100 dark:border-zinc-800 space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">{{ __('Subtotal') }}</span>
                            <span
                                class="text-zinc-900 dark:text-zinc-100 font-semibold tabular-nums">{{ $displaySymbol }}{{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center text-sm">
                            <span class="text-emerald-500 font-medium flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ __('Wallet Balance') }}
                            </span>
                            <span class="text-emerald-500 font-bold tabular-nums">−
                                {{ $displaySymbol }}{{ number_format($walletBalance ?? 0, 2) }}</span>
                        </div>

                        <div
                            class="pt-2 border-t border-dashed border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                            <div class="flex items-center gap-1">
                                <span
                                    class="text-pink-500 text-xs font-bold uppercase tracking-wider">{{ __('+ Fee') }}</span>
                                <span
                                    class="text-[10px] bg-pink-500/10 text-pink-500 px-1.5 py-0.5 rounded font-bold">{{ __('Service') }}</span>
                            </div>
                            <span class="text-pink-500 font-bold tabular-nums text-sm">+
                                {{ $displaySymbol }}{{ number_format($calculatedTaxAmount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Final Amount Highlight -->
                    <div class="relative group">
                        <div
                            class="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl blur-sm opacity-20 group-hover:opacity-40 transition duration-1000">
                        </div>
                        <div
                            class="relative bg-white dark:bg-zinc-900 border border-pink-500/20 rounded-2xl p-5 text-center shadow-sm">
                            <p
                                class="text-zinc-500 dark:text-zinc-400 text-[11px] uppercase tracking-[0.15em] font-bold mb-1">
                                {{ __('Total Amount Needed') }}</p>
                            <h4
                                class="text-3xl sm:text-4xl font-black text-zinc-900 dark:text-white tracking-tight tabular-nums">
                                {{ $displaySymbol }}{{ number_format($requiredTopUpAmount, 2) }}
                            </h4>
                        </div>
                    </div>

                    <!-- Gateway Selection -->
                    <div>
                        <p class="text-text-white font-semibold text-xs uppercase tracking-wide mb-2">
                            {{ __('Select Payment Method') }}
                        </p>

                        <div class="flex items-center gap-2 justify-between">
                            @foreach ($topUpGateways as $gatewayItem)
                                <button type="button" wire:click="$set('topUpGateway', '{{ $gatewayItem->slug }}')"
                                    class="w-full flex items-center justify-between p-3 rounded-lg transition-all duration-300 border-2 text-sm
                                    {{ $gatewayItem->slug === $topUpGateway ? 'border-pink-500 bg-pink-500/10 ring-2 ring-pink-500/30' : 'border-zinc-300 dark:border-zinc-700 bg-bg-primary/50 hover:border-zinc-400 dark:hover:border-zinc-600' }}">

                                    <div class="flex items-center gap-2.5">
                                        @if ($gatewayItem->icon)
                                            <div
                                                class="p-1.5 rounded {{ $gatewayItem->slug === $topUpGateway ? 'bg-pink-500/20' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                                                <img src="{{ storage_url($gatewayItem->icon) }}" alt="{{ $gatewayItem->name }}" class="w-4 h-4 object-contain" />
                                            </div>
                                        @elseif ($gatewayItem->slug === 'stripe' || $gatewayItem->slug === 'card')
                                            <div
                                                class="p-1.5 rounded {{ $gatewayItem->slug === $topUpGateway ? 'bg-pink-500/20' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                                                <svg class="w-4 h-4 {{ $gatewayItem->slug === $topUpGateway ? 'text-pink-400' : 'text-text-secondary' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <rect x="2" y="5" width="20" height="14" rx="2"
                                                        stroke-width="2" />
                                                    <path d="M2 10h20" stroke-width="2" />
                                                </svg>
                                            </div>
                                        @elseif($gatewayItem->slug === 'crypto')
                                            <div
                                                class="p-1.5 rounded {{ $gatewayItem->slug === $topUpGateway ? 'bg-pink-500/20' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                                                <span
                                                    class="text-sm font-bold {{ $gatewayItem->slug === $topUpGateway ? 'text-pink-400' : 'text-text-secondary' }}">₿</span>
                                            </div>
                                        @else
                                            <div
                                                class="p-1.5 rounded {{ $gatewayItem->slug === $topUpGateway ? 'bg-pink-500/20' : 'bg-zinc-200 dark:bg-zinc-800' }}">
                                                <flux:icon name="banknotes" class="w-4 h-4 {{ $gatewayItem->slug === $topUpGateway ? 'text-pink-400' : 'text-text-secondary' }}" />
                                            </div>
                                        @endif
                                        <span class="text-text-white font-medium">{{ $gatewayItem->name }}</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-center w-5 h-5 rounded-full border-2 {{ $gatewayItem->slug === $topUpGateway ? 'border-pink-500 bg-pink-500' : 'border-zinc-400 dark:border-zinc-600' }}">
                                        @if ($gatewayItem->slug === $topUpGateway)
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" wire:click="closeTopUpModal"
                            class="flex-1 px-4 py-2 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-text-white rounded-lg transition-all font-medium text-sm">
                            {{ __('Cancel') }}
                        </button>

                        <button type="button" wire:click="processTopUpAndPayment" wire:loading.attr="disabled"
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-lg transition-all font-medium text-sm shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="processTopUpAndPayment, topUpGateway">
                                {{ __('Continue to Payment') }}
                            </span>
                            <span wire:loading wire:target="topUpGateway">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            <span wire:loading wire:target="processTopUpAndPayment">
                                <div class="flex items-center justify-center gap-1.5">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    {{ __('Processing...') }}
                                </div>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
