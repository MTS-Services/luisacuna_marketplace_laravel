<div class="bg-page py-10">
    <div class="container mx-auto px-4 py-12 max-w-7xl bg-black/30 rounded-2xl shadow-lg backdrop-blur-sm">

        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
            Finalizing Order: <span class="text-primary"> #{{ $order->order_id }}</span>
        </h1>

        @if (session('error'))
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <!-- 1. Order Summary & Payment Details (Right Column - 2/3) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Order Summary Card -->
                <div class="card bg-gray-50 border border-gray-200 rounded-2xl shadow-inner p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3">1. Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-lg">
                            <span>Product:</span>
                            <span class="font-semibold">{{ $order->source?->name ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-medium pt-2 border-t border-gray-300">
                            <span>Total Due:</span>
                            <span class="text-primary font-extrabold text-2xl">
                                ${{ number_format($order->grand_total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <p class="text-center text-sm text-white mt-6">
                    All payments are processed securely. By completing this purchase, you agree to our
                    <a href="#" class="text-primary hover:underline font-medium">Terms of Service</a>.
                </p>
            </div>

            <!-- 2. Payment Gateways (Left Column - 1/3) -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4 border-b pb-3">2. Choose Method</h2>

                <form class="flex flex-col gap-3" wire:submit.prevent="processPayment">
                    @forelse ($gateways as $gatewayItem)
                        <label
                            class="gateway-label flex items-center p-4 rounded-xl transition-all duration-300 shadow-md border-2 cursor-pointer
                                {{ $gatewayItem->slug === $gateway ? 'border-primary ring-2 ring-primary/50 bg-base-200' : 'border-gray-200 hover:bg-base-100' }}">

                            <input type="radio" class="radio radio-primary radio-sm" value="{{ $gatewayItem->slug }}"
                                wire:model.live="gateway" name="gateway"
                                {{ $gatewayItem->slug === $gateway ? 'checked' : '' }} />

                            <div class="ml-4 flex-1">
                                <span class="text-lg font-medium text-gray-700">{{ $gatewayItem->name }}</span>

                                @if ($gatewayItem->slug === 'wallet' && $walletBalance !== null)
                                    <div class="text-sm mt-1">
                                        <span class="text-gray-600">Balance: </span>
                                        <span
                                            class="font-semibold {{ $walletBalance >= $order->grand_total ? 'text-green-600' : 'text-red-600' }}">
                                            ${{ number_format($walletBalance, 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </label>
                    @empty
                        <div class="alert alert-warning shadow-lg rounded-xl">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>No payment gateways are currently configured.</span>
                            </div>
                        </div>
                    @endforelse

                    @if ($showWalletWarning)
                        <div class="alert alert-warning shadow-lg rounded-xl mt-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="font-bold">Insufficient Balance</p>
                                    <p class="text-sm">You need
                                        ${{ number_format($order->grand_total - $walletBalance, 2) }} more to complete
                                        this purchase.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary btn-block mt-6"
                        {{ is_null($gateway) || $showWalletWarning ? 'disabled' : '' }}>
                        @if ($gateway === 'stripe')
                            Continue to Stripe
                        @elseif($gateway === 'wallet')
                            Pay with Wallet
                        @else
                            Proceed to Payment
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
