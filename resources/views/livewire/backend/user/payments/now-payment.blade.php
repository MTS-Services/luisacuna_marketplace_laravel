<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Create Crypto Payment</h2>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(!$paymentDetails)
            <form wire:submit.prevent="createPayment">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Price Amount</label>
                    <input type="number" step="0.01" wire:model.live="priceAmount" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('priceAmount') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Price Currency</label>
                    <select wire:model.live="priceCurrency" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="usd">USD</option>
                        <option value="eur">EUR</option>
                        <option value="gbp">GBP</option>
                    </select>
                    @error('priceCurrency') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Pay with Cryptocurrency</label>
                    <select wire:model.live="payCurrency" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <option value="">Select Currency</option>
                        @foreach($availableCurrencies['currencies'] ?? [] as $currency)
                            <option value="{{ strtolower($currency) }}">{{ strtoupper($currency) }}</option>
                        @endforeach
                    </select>
                    @error('payCurrency') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Order Description (Optional)</label>
                    <input type="text" wire:model="orderDescription" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., Package Purchase">
                </div>

                @if($estimatedAmount)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-600">Estimated Amount:</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($estimatedAmount, 8) }} {{ strtoupper($payCurrency) }}
                        </p>
                        @if($minimumAmount)
                            <p class="text-xs text-gray-500 mt-1">
                                Minimum: {{ number_format($minimumAmount, 8) }} {{ strtoupper($payCurrency) }}
                            </p>
                        @endif
                        
                        @if($estimatedAmount < $minimumAmount)
                            <p class="text-xs text-red-600 mt-2 font-semibold">
                                ⚠️ Amount is below minimum requirement
                            </p>
                        @endif
                    </div>
                @endif

                <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                    wire:target="createPayment"
                    @if($estimatedAmount && $minimumAmount && $estimatedAmount < $minimumAmount) disabled @endif>
                    <span wire:loading.remove wire:target="createPayment">Create Payment</span>
                    <span wire:loading wire:target="createPayment">Processing...</span>
                </button>
            </form>
        @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <h3 class="text-xl font-bold text-green-800 mb-4">✓ Payment Created Successfully!</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Payment ID:</p>
                        <p class="font-mono text-sm bg-white p-2 rounded border">{{ $paymentDetails['payment_id'] ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Send to Address:</p>
                        <div class="bg-white p-2 rounded border">
                            <p class="font-mono text-sm break-all">{{ $paymentDetails['pay_address'] ?? 'N/A' }}</p>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentDetails['pay_address'] ?? '' }}')" 
                                class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                📋 Copy Address
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Amount to Pay:</p>
                        <p class="text-2xl font-bold text-green-700">
                            {{ number_format($paymentDetails['pay_amount'] ?? 0, 8) }} {{ strtoupper($paymentDetails['pay_currency'] ?? '') }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Status:</p>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if(($paymentDetails['payment_status'] ?? '') === 'waiting') bg-yellow-200 text-yellow-800
                            @elseif(($paymentDetails['payment_status'] ?? '') === 'confirming') bg-blue-200 text-blue-800
                            @elseif(($paymentDetails['payment_status'] ?? '') === 'finished') bg-green-200 text-green-800
                            @else bg-gray-200 text-gray-800
                            @endif">
                            {{ ucfirst($paymentDetails['payment_status'] ?? 'Unknown') }}
                        </span>
                    </div>

                    @if(isset($paymentDetails['order_id']))
                        <div>
                            <p class="text-sm text-gray-600">Order ID:</p>
                            <p class="font-mono text-sm">{{ $paymentDetails['order_id'] }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-2">
                    <a href="{{ $paymentDetails['invoice_url'] ?? '#' }}" 
                        target="_blank"
                        class="block w-full text-center bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700">
                        View Invoice
                    </a>
                    
                    <button wire:click="resetPayment" 
                        class="w-full bg-gray-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-700">
                        Create Another Payment
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>