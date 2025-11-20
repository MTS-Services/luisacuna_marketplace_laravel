<frontend::app>
    <div class="max-w-6xl mx-auto my-12 p-4 md:p-8 bg-white rounded-3xl shadow-2xl border border-gray-100">

        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
            Finalizing Order: <span class="text-primary"> #{{ $order->order_id }}</span>
        </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('process.payment') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->order_id }}" />

            <!-- 1. Payment Gateways (Left Column - 1/3) -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-2xl font-bold text-gray-700 mb-4 border-b pb-3">1. Choose Method</h2>

                <div class="flex flex-col gap-3">
                    @forelse ($gateways as $gateway)
                        <label
                            class="gateway-label flex items-center p-4 rounded-xl transition-all duration-300 shadow-md border-2 
                        {{ $gateway->slug === $gateway ? 'border-primary ring-2 ring-primary/50 bg-base-200' : 'border-gray-200 hover:bg-base-100' }}">

                            <input type="radio" class="radio radio-primary radio-sm" value="{{ $gateway->slug }}"
                                wire:model.live="gateway" name="gateway"
                                {{ $gateway->slug === $gateway ? 'checked' : '' }} />

                            <span class="ml-4 text-lg font-medium text-gray-700">{{ $gateway->name }}</span>
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
                        {{-- Assuming $item->price exists and format is handled --}}
                        <div class="flex justify-between text-xl font-medium pt-2 border-t border-gray-300">
                            <span>Total Due:</span>
                            <span
                                class="text-primary font-extrabold text-2xl">${{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Credit Card Form (Conditional, typically wrapped in Livewire logic) -->
                {{-- NOTE: Livewire should conditionally render this block based on the selected $gateway --}}
                <div x-data="{
                    // Logic to automatically format the card number
                    formatCardNumber(event) {
                            let input = event.target;
                            let value = input.value.replace(/\D/g, ''); // Remove all non-digits
                            // Insert space every 4 digits, ensuring max 16 digits (+ 3 spaces = 19 chars)
                            value = value.match(/.{1,4}/g)?.join(' ') || value;
                            input.value = value.substring(0, 19);
                        },
                        // Logic to automatically format the expiry date (MM/YY)
                        formatExpiry(event) {
                            let input = event.target;
                            let value = input.value.replace(/\D/g, ''); // Remove all non-digits
                
                            // Enforce MM/YY format and handle month logic
                            if (value.length >= 2) {
                                let month = parseInt(value.substring(0, 2), 10);
                                if (month === 0) value = '01' + value.substring(2); // 00 -> 01
                                else if (month > 12) value = '12' + value.substring(2); // >12 -> 12
                            }
                
                            if (value.length > 2) {
                                value = value.substring(0, 2) + '/' + value.substring(2); // Insert slash
                            }
                            input.value = value.substring(0, 5); // Limit to MM/YY
                        }
                }"
                    class="space-y-6 card p-6 bg-white border border-gray-200 rounded-2xl shadow-lg">

                    <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">3. Card Details</h2>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-gray-700">Cardholder
                                    Name</span></label>
                            <input type="text" placeholder="John Doe" name="cardName"
                                class="input input-bordered w-full rounded-lg" required autocomplete="cc-name" />
                            <p class="text-error text-sm mt-1">
                                @error('cardName')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-gray-700">Card
                                    Number</span></label>
                            <input type="text" placeholder="XXXX XXXX XXXX XXXX" name="cardNumber"
                                class="input input-bordered w-full rounded-lg" required x-on:input="formatCardNumber"
                                maxlength="19" autocomplete="cc-number" />
                            <p class="text-error text-sm mt-1">
                                @error('cardNumber')
                                    {{ $message }}
                                @enderror
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium text-gray-700">Expiry Date
                                        (MM/YY)</span></label>
                                <input type="text" placeholder="MM/YY" name="cardExpiry"
                                    class="input input-bordered w-full rounded-lg" required x-on:input="formatExpiry"
                                    maxlength="5" autocomplete="cc-exp" />
                                <p class="text-error text-sm mt-1">
                                    @error('cardExpiry')
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <div class="form-control">
                                <label class="label"><span
                                        class="label-text font-medium text-gray-700">CVV/CVC</span></label>
                                <input type="text" placeholder="XXX" name="cardCvc"
                                    class="input input-bordered w-full rounded-lg" required maxlength="4"
                                    autocomplete="cc-csc" />
                                <p class="text-error text-sm mt-1">
                                    @error('cardCvc')
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Pay Button (Moved inside the details block for a better flow) --}}
                    <button type="submit"
                        class="btn btn-primary btn-lg w-full rounded-xl mt-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.005] focus:ring-4 focus:ring-primary/50">
                        Pay Now - ${{ number_format($order->grand_total, 2) }}
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 mt-6">
                    All payments are processed securely. By completing this purchase, you agree to our <a href="#"
                        class="text-primary hover:underline font-medium">Terms of Service</a>.
                </p>
            </div>
        </form>
    </div>

    <style>
        /* Add this custom style block for your Blade component if necessary,
       or move these classes to your global CSS/SCSS file. */
        .gateway-label:focus-within {
            outline: none;
            box-shadow: 0 0 0 3px theme('colors.primary.100');
        }
    </style>

</frontend::app>
