<x-frontend::app>
    <div class="bg-page min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-2xl w-full">
            <!-- Failed Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Failed Icon Header -->
                <div class="bg-gradient-to-r from-red-500 to-rose-600 p-8 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white rounded-full p-4">
                            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Payment Failed</h1>
                    <p class="text-red-100 text-lg">We couldn't process your payment</p>
                </div>

                <!-- Order Details -->
                <div class="p-8">
                    @if ($order)
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor"
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
                                    <span
                                        class="font-semibold text-gray-900">{{ $order->source?->name ?? 'N/A' }}</span>
                                </div>

                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                        Payment Failed
                                    </span>
                                </div>

                                <div class="flex justify-between items-center py-3 bg-gray-100 rounded-lg px-4 mt-4">
                                    <span class="text-gray-700 font-semibold text-lg">Amount:</span>
                                    <span
                                        class="font-bold text-2xl text-gray-700">${{ number_format($order->grand_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Common Reasons -->
                    <div class="bg-yellow-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Common Reasons for Payment Failure
                        </h3>

                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Insufficient funds in your account or wallet</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Incorrect card or payment information</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Card expired or declined by your bank</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Payment method not supported for this transaction</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- @if ($order)
                            <a href="{{ route('user.checkout', ['slug' => encrypt($order->source_id), 'token' => session('checkout_token')]) }}"
                                class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold text-center hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                Try Again
                            </a>
                        @endif --}}

                        <a href="{{ route('home') }}"
                            class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold text-center hover:bg-gray-300 transition-all duration-200">
                            Back to Home
                        </a>
                    </div>

                    <!-- Help Section -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Need Help?</p>
                                <p>If you continue to experience issues, please <a href="#"
                                        class="underline hover:text-blue-900">contact our support team</a>. We're here
                                    to
                                    help!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Support -->
            <div class="mt-6 text-center text-gray-600 text-sm">
                <p>Questions? <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Contact
                        Support</a> or check our <a href="#"
                        class="text-purple-600 hover:text-purple-700 font-semibold">FAQ</a></p>
            </div>
        </div>
    </div>
</x-frontend::app>
