<x-frontend::app>
    <div class="max-w-2xl mx-auto my-12 p-8">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 text-center">
            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-success/10 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Payment Successful!
            </h1>

            <p class="text-gray-600 mb-8">
                Thank you for your payment. Your order has been confirmed.
            </p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-semibold text-gray-800">#{{ $order->order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Amount Paid:</span>
                        <span class="font-bold text-xl text-success">${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status:</span>
                        <span class="badge badge-success">{{ $order->status->value }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                {{-- <a href="{{ route('home') }}" class="btn btn-primary">
                    Continue Shopping
                </a> --}}
                <a href="{{ route('user.order-details', encrypt($order->id)) }}" class="btn btn-outline">
                    View My Order
                </a>


            </div>
        </div>
    </div>
</x-frontend::app>
