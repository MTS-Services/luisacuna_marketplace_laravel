<frontend::app>
    <div class="max-w-6xl mx-auto my-12 p-4 md:p-8 bg-white rounded-3xl shadow-2xl border border-gray-100">

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
            <!-- 1. Payment Gateways (Left Column - 1/3) -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4 border-b pb-3">1. Choose Method</h2>

                <div class="flex flex-col gap-3">
                    @forelse ($gateways as $gatewayItem)
                        <label
                            class="gateway-label flex items-center p-4 rounded-xl transition-all duration-300 shadow-md border-2 cursor-pointer
                        {{ $gatewayItem->slug === $gateway ? 'border-primary ring-2 ring-primary/50 bg-base-200' : 'border-gray-200 hover:bg-base-100' }}">

                            <input type="radio" class="radio radio-primary radio-sm" value="{{ $gatewayItem->slug }}"
                                wire:model.live="gateway" name="gateway"
                                {{ $gatewayItem->slug === $gateway ? 'checked' : '' }} />

                            <span class="ml-4 text-lg font-medium text-gray-700">{{ $gatewayItem->name }}</span>
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
                </div>
            </div>

            <!-- 2. Order Summary & Payment Details (Right Column - 2/3) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Order Summary Card -->
                <div class="card bg-gray-50 border border-gray-200 rounded-2xl shadow-inner p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3">2. Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-lg">
                            <span>Product:</span>
                            <span class="font-semibold">{{ $order->source?->name ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-medium pt-2 border-t border-gray-300">
                            <span>Total Due:</span>
                            <span
                                class="text-primary font-extrabold text-2xl">${{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Stripe Payment Form -->
                @if ($gateway === 'stripe')
                    <div id="stripe-payment-section"
                        class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">

                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. Card Details</h2>

                        <!-- Stripe Card Element Container -->
                        <div id="card-element" class="p-4 border border-gray-300 rounded-lg bg-gray-50"></div>

                        <!-- Error Messages -->
                        <div id="card-errors" class="text-error text-sm hidden"></div>

                        <!-- Pay Button -->
                        <button type="button" id="submit-payment"
                            class="btn btn-primary btn-lg w-full rounded-xl mt-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.005] focus:ring-4 focus:ring-primary/50">
                            <span id="button-text">Pay Now - ${{ number_format($order->grand_total, 2) }}</span>
                            <span id="button-loader" class="loading loading-spinner loading-sm hidden"></span>
                        </button>
                    </div>
                @elseif ($gateway === 'paypal')
                    <!-- PayPal Payment Section (Future) -->
                    <div class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. PayPal Payment</h2>
                        <p class="text-gray-600">PayPal integration coming soon...</p>
                    </div>
                @elseif ($gateway === 'coinbase')
                    <!-- Coinbase Payment Section (Future) -->
                    <div class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">
                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. Coinbase Payment</h2>
                        <p class="text-gray-600">Coinbase integration coming soon...</p>
                    </div>
                @endif

                <p class="text-center text-sm text-gray-500 mt-6">
                    All payments are processed securely. By completing this purchase, you agree to our <a href="#"
                        class="text-primary hover:underline font-medium">Terms of Service</a>.
                </p>
            </div>
        </div>
    </div>

    <!-- Stripe.js Integration -->
    @if ($gateway === 'stripe')
        @push('scripts')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    initializeStripePayment();
                });

                // Listen for Livewire updates (when gateway changes)
                document.addEventListener('livewire:navigated', function() {
                    if (document.getElementById('stripe-payment-section')) {
                        initializeStripePayment();
                    }
                });
                document.addEventListener('livewire:initialized', function() {
                    initializeStripePayment();
                });

                function initializeStripePayment() {
                    // Check if already initialized
                    if (window.stripeInitialized) {
                        return;
                    }

                    // Check if Stripe elements exist
                    const cardElementContainer = document.getElementById('card-element');
                    if (!cardElementContainer) {
                        return;
                    }

                    // Initialize Stripe
                    const stripe = Stripe('{{ config('services.stripe.key') }}');

                    // Create elements
                    const elements = stripe.elements();
                    const cardElement = elements.create('card', {
                        theme: 'flat',
                        style: {
                            base: {
                                fontSize: '16px',
                                color: '#424770',
                                '::placeholder': {
                                    color: '#aab7c4',
                                },
                            },
                            invalid: {
                                color:'#9e2146',
                            },
                            
                        },
                    });

                    // Mount card element
                    cardElement.mount('#card-element');

                    // Mark as initialized
                    window.stripeInitialized = true;

                    // Handle real-time validation errors
                    cardElement.on('change', function(event) {
                        const displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                            displayError.classList.remove('hidden');
                        } else {
                            displayError.textContent = '';
                            displayError.classList.add('hidden');
                        }
                    });

                    // Handle form submission
                    const submitButton = document.getElementById('submit-payment');
                    const buttonText = document.getElementById('button-text');
                    const buttonLoader = document.getElementById('button-loader');

                    submitButton.addEventListener('click', async function(event) {
                        event.preventDefault();

                        // Disable button and show loader
                        submitButton.disabled = true;
                        buttonText.classList.add('hidden');
                        buttonLoader.classList.remove('hidden');

                        try {
                            // Step 1: Initialize payment (create payment intent)
                            const initResponse = await fetch('{{ route('payment.initialize') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    order_id: '{{ $order->order_id }}',
                                    gateway: 'stripe',
                                }),
                            });

                            const initResult = await initResponse.json();

                            if (!initResult.success) {
                                throw new Error(initResult.message || 'Failed to initialize payment');
                            }

                            // Step 2: Confirm payment with Stripe.js
                            const {
                                error,
                                paymentIntent
                            } = await stripe.confirmCardPayment(
                                initResult.client_secret, {
                                    payment_method: {
                                        card: cardElement,
                                    },
                                }
                            );

                            if (error) {
                                throw new Error(error.message);
                            }

                            // Step 3: Confirm payment on backend
                            const confirmResponse = await fetch('{{ route('payment.confirm') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    payment_intent_id: paymentIntent.id,
                                    payment_method_id: paymentIntent.payment_method,
                                    gateway: 'stripe',
                                }),
                            });

                            const confirmResult = await confirmResponse.json();

                            if (confirmResult.success) {
                                // Redirect to success page
                                window.location.href = confirmResult.redirect_url;
                            } else {
                                throw new Error(confirmResult.message || 'Payment confirmation failed');
                            }

                        } catch (error) {
                            // Show error message
                            const displayError = document.getElementById('card-errors');
                            displayError.textContent = error.message;
                            displayError.classList.remove('hidden');

                            // Re-enable button
                            submitButton.disabled = false;
                            buttonText.classList.remove('hidden');
                            buttonLoader.classList.add('hidden');
                        }
                    });
                }
            </script>
        @endpush
    @endif

    <style>
        .gateway-label:focus-within {
            outline: none;
            box-shadow: 0 0 0 3px theme('colors.primary.100');
        }

        #card-element {
            min-height: 50px;
        }

        .StripeElement {
            padding: 12px;
        }

        .StripeElement--focus {
            border-color: theme('colors.primary.500');
            box-shadow: 0 0 0 3px theme('colors.primary.100');
        }

        .StripeElement--invalid {
            border-color: theme('colors.error');
        }
    </style>
</frontend::app>
