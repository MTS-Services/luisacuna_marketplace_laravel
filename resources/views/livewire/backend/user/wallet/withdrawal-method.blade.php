<style>
    .gradient-bg {
        background: linear-gradient(135deg, #853eff 0%, #ff2e91 100%);
    }

    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }
    .box-shadow {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-text-white mb-2">{{ __('My Wallet') }}</h1>
        <p class="text-text-secondary">{{ __('Manage your balance and withdrawal methods') }}</p>
    </div>

    <!-- Wallet Balance Card -->
    <div class="glass-card box-shadow rounded-2xl p-6 md:p-8 mb-8 gradient-bg text-text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full -ml-24 -mb-24"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-white/80 text-sm mb-1">{{ __('Available Balance') }}</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-white">{{ __('$2,450.00') }}</h2>
                </div>
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <i data-lucide="wallet" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">{{ __('Pending') }}</p>
                    <p class="text-xl font-semibold text-white">{{ __('$2,450.00') }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">{{ __('Total Withdrawn') }}</p>
                    <p class="text-xl font-semibold text-white">{{ __('$2,450.00') }}</p>
                </div>
            </div>

            <button
                class="mt-6 w-full bg-white text-purple-600 font-semibold py-3 px-6 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2">
                <i data-lucide="arrow-down-to-line" class="w-5 h-5"></i>
                {{ __('Request Withdrawal') }}
            </button>
        </div>
    </div>

    <!-- Withdrawal Methods Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-text-white mb-2">{{ __('Withdrawal Methods') }}</h2>
        <p class="text-text-secondary">{{ __('Choose your preferred withdrawal method') }}</p>
    </div>

    <!-- Withdrawal Methods Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Payoneer Card -->
        @foreach ($methods as $method)
            <div
                class="glass-card box-shadow bg-bg-secondary rounded-xl p-6 hover-scale border-2 border-transparent dark:border-zinc-700 hover:border-purple-500 transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 p-3 rounded-xl">
                        <i data-lucide="credit-card" class="w-6 h-6 text-purple-600"></i>
                    </div>
                    @if ($method->userWithdrawalAccounts->isNotEmpty())
                        <span>
                            <span
                                class="badge bg-{{ $method->userWithdrawalAccounts?->first()->status == 'active' ? 'green' : 'red' }}-500 text-white">{{ $method->userWithdrawalAccounts?->first()->status }}</span>
                        </span>
                    @else
                        <span>
                            <span class="badge bg-green-500 text-white">{{ __('Available') }}</span>
                        </span>
                    @endif
                </div>

                <h3 class="text-xl font-bold text-text-white mb-2">{{ $method->name }}</h3>
                <p class="text-sm text-text-secondary mb-4">{{ __('Withdraw funds using ') }} <span
                        class="font-semibold text-text-secondary">{{ $method->name }}</span> {{ __('account') }}</p>

                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-secondary">{{ __('Min Amount:') }}:</span>
                        <span class="font-semibold text-text-white">${{ $method->min_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-secondary">{{ __('Max Amount:') }}:</span>
                        <span class="font-semibold text-text-white">${{ $method->max_amount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-secondary"></span>
                        <span class="font-semibold text-purple-600">${{ $method->fee_amount }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span class="text-text-secondary/80">{{ __('1-3 business days') }}</span>
                </div>
                @if ($method->userWithdrawalAccounts->isNotEmpty() && $method->userWithdrawalAccounts?->first()->status == 'active')
                    <x-ui.button class="w-full py-2! px-6!">
                        <span
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Request Withdrawal') }}</span>
                    </x-ui.button>
                @elseif (
                    $method->userWithdrawalAccounts->isNotEmpty() &&
                        $method->userWithdrawalAccounts?->first()->status == 'pending')
                    <x-ui.button class="w-full py-2! px-6! hover:bg-pink-500!" :disabled="true" variant="tertiary">
                        <span class="text-text-btn-primary">{{ __('Verify Pending') }}</span>
                    </x-ui.button>
                @elseif(!$method->userWithdrawalAccounts->isNotEmpty())
                    <x-ui.button href="{{ route('user.wallet.withdrawal-form', encrypt($method->id)) }}"
                        class="w-full py-2! px-6!" variant="secondary">
                        <span
                            class="text-text-btn-secondary group-hover:text-text-btn-primary">{{ __('Add Method') }}</span>
                    </x-ui.button>
                @endif
                {{-- <x-ui.button href="{{ route('user.wallet.withdrawal-form', encrypt($method->id)) }}" class="w-full py-2! px-6!">
                    <span
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Add Method') }}</span>
                </x-ui.button> --}}

            </div>
        @endforeach
    </div>

    <!-- Recent Transactions -->
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-text-white mb-2">{{ __('Recent Transactions') }}</h2>
                <p class="text-text-secondary">{{ __('Votre dernier historique de retrait') }}</p>
            </div>
            <button
                class="text-purple-600 font-semibold hover:text-purple-700 transition-colors duration-200 flex items-center gap-2">
                {{ __('View All') }}
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
                                {{ __('Date') }}</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Method') }}</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Amount') }}</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Fee') }}</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Jan 05, 2026</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Payoneer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text-white">$500.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">$10.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Jan 03, 2026</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Bank Transfer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text-white">$1,200.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">$5.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Processing
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Dec 28, 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-white">Payoneer</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-text-white">$750.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">$15.00</td>
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
