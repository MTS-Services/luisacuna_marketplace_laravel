<x-frontend::app>
    <div class="bg-page min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-2xl w-full">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Success Icon Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white rounded-full p-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Payment Successful!</h1>
                    <p class="text-green-100 text-lg">Your order has been confirmed</p>
                </div>

                <!-- Order Details -->
                <div class="p-8">
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Order Details
                        </h2>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Order ID:</span>
                                <span class="font-semibold text-gray-900">#{{ $order->order_id }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Product:</span>
                                <span class="font-semibold text-gray-900">{{ $order->source?->name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-semibold text-gray-900">{{ $order->payment_method ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                    {{ $order->status->label() }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-3 bg-green-50 rounded-lg px-4 mt-4">
                                <span class="text-gray-700 font-semibold text-lg">Total Paid:</span>
                                <span
                                    class="font-bold text-2xl text-green-600">{{ currency_symbol() }}{{ currency_exchange($order->grand_total) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    @if ($order->latestPayment)
                        <div class="bg-blue-50 rounded-xl p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                Payment Information
                            </h3>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment ID:</span>
                                    <span class="font-mono text-gray-900">{{ $order->latestPayment->payment_id }}</span>
                                </div>

                                @if ($order->latestPayment->transaction_id)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Transaction ID:</span>
                                        <span
                                            class="font-mono text-gray-900 text-xs">{{ $order->latestPayment->transaction_id }}</span>
                                    </div>
                                @endif

                                @if ($order->latestPayment->card_brand && $order->latestPayment->card_last4)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Card:</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ ucfirst($order->latestPayment->card_brand) }} ••••
                                            {{ $order->latestPayment->card_last4 }}
                                        </span>
                                    </div>
                                @endif

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Date:</span>
                                    <span
                                        class="text-gray-900">{{ $order->latestPayment->paid_at?->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('profile', user()->username) }}"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold text-center hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Go to Dashboard
                        </a>

                        <a href="{{ route('home') }}"
                            class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold text-center hover:bg-gray-300 transition-all duration-200">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Email Confirmation Notice -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Order confirmation sent!</p>
                                <p>We've sent a confirmation email to <span
                                        class="font-semibold">{{ $order->user->email }}</span> with your order details
                                    and receipt.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Help -->
            <div class="mt-6 text-center text-gray-600 text-sm">
                <p>Need help? <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Contact
                        Support</a></p>
            </div>
        </div>
    </div>
</x-frontend::app>
