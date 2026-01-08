<style>
    :root {
        --color-primary-500: #853eff;
        --color-primary-600: #7c3aed;
        --color-primary-700: #6d28d9;
        --color-primary-800: #351966;
        --color-primary-900: #1b0c33;
        --color-primary-950: #0d061a;
        --color-secondary-500: #ff2e91;
        --color-secondary-600: #db2777;
        --color-bg-primary-light: #ffffff;
        --color-bg-secondary-light: rgba(0, 0, 0, 0.04);
        --color-text-primary-light: #1b1b1b;
        --color-text-secondary-light: #4a4a4a;
    }

    body {
        font-family: 'Lato', sans-serif;
        background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 50%, #fdf2f8 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Open Sans', sans-serif;
    }

    .glass-card {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .gradient-bg {
        background: linear-gradient(135deg, var(--color-primary-500) 0%, var(--color-secondary-500) 100%);
    }

    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">My Wallet</h1>
        <p class="text-gray-600">Manage your balance and withdrawal methods</p>
    </div>

    <!-- Wallet Balance Card -->
    <div class="glass-card rounded-2xl p-6 md:p-8 mb-8 gradient-bg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-white/80 text-sm mb-1">Available Balance</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-white">$2,450.00</h2>
                </div>
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <i data-lucide="wallet" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">Pending</p>
                    <p class="text-xl font-semibold text-white">$150.00</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">Total Withdrawn</p>
                    <p class="text-xl font-semibold text-white">$8,320.00</p>
                </div>
            </div>

            <button
                class="mt-6 w-full bg-white text-purple-600 font-semibold py-3 px-6 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2">
                <i data-lucide="arrow-down-to-line" class="w-5 h-5"></i>
                Request Withdrawal
            </button>
        </div>
    </div>

    <!-- Withdrawal Methods Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Withdrawal Methods</h2>
        <p class="text-gray-600">Choose your preferred withdrawal method</p>
    </div>

    <!-- Withdrawal Methods Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Payoneer Card -->
        @foreach ($methods as $method)
            <div
                class="glass-card rounded-xl p-6 hover-scale cursor-pointer border-2 border-transparent hover:border-purple-500 transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 p-3 rounded-xl">
                        <i data-lucide="credit-card" class="w-6 h-6 text-purple-600"></i>
                    </div>
                    <span>
                        <span
                            class="badge {{ $method->status->color() }} text-white">{{ $method->status->label() }}</span>
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $method->name }}</h3>
                <p class="text-sm text-gray-600 mb-4">Withdraw funds using <span
                        class="font-semibold text-gray-600">{{ $method->name }}</span> account</p>

                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Min Amount:</span>
                        <span class="font-semibold text-gray-900">${{ $method->min_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Max Amount:</span>
                        <span class="font-semibold text-gray-900">${{ $method->max_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Fee:</span>
                        <span class="font-semibold text-purple-600">${{ $method->fee_amount }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span class="text-gray-500">1-3 business days</span>
                </div>
                {{-- @if ($method->status->value === App\Enums\ActiveInactiveEnum::ACTIVE->value)
                    <x-ui.button class="w-full py-2! px-6!">
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Request Withdrawal') }}</span>
                    </x-ui.button>
                @elseif ($method->status->value === App\Enums\ActiveInactiveEnum::INACTIVE->value)
                    <x-ui.button class="w-full py-2! px-6!" disabled>
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Verify Pending') }}</span>
                    </x-ui.button>
                @else
                    <x-ui.button class="w-full py-2! px-6!">
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Add Method') }}</span>
                    </x-ui.button>
                     @endif --}}
                <x-ui.button href="{{ route('user.wallet.withdrawal-form', encrypt($method->id)) }}" class="w-full py-2! px-6!">
                    <span
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Add Method') }}</span>
                </x-ui.button>

            </div>
        @endforeach
    </div>

    <!-- Recent Transactions -->
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Recent Transactions</h2>
                <p class="text-gray-600">Your latest withdrawal history</p>
            </div>
            <button
                class="text-purple-600 font-semibold hover:text-purple-700 transition-colors duration-200 flex items-center gap-2">
                View All
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="glass-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-purple-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Method</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Fee</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Jan 05, 2026</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Payoneer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$500.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">$10.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Jan 03, 2026</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Bank Transfer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$1,200.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">$5.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Processing
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dec 28, 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Payoneer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$750.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">$15.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
