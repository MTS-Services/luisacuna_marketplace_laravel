<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-text-white mb-2">
            {{ __('My Wallet') }}
        </h1>
        <p class="text-text-secondary">
            {{ __('Manage your balance and withdrawal methods') }}
        </p>
    </div>

    <!-- Wallet Balance Card -->
    <div
        class="glass-card bg-bg-pink-500 rounded-2xl p-6 md:p-8 mb-8 text-text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-white/80 text-sm mb-1">
                        {{ __('Available Balance') }}
                    </p>
                    <h2 class="text-4xl md:text-5xl font-bold text-white">
                        {{ __('$2,450.00') }}
                    </h2>
                </div>

                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <i data-lucide="wallet" class="w-8 h-8"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">{{ __('Pending') }}</p>
                    <p class="text-xl font-semibold text-white">$2,450.00</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <p class="text-white/80 text-xs mb-1">{{ __('Total Withdrawn') }}</p>
                    <p class="text-xl font-semibold text-white">$2,450.00</p>
                </div>
            </div>

            <button
                class="mt-6 w-full bg-white text-purple-600 font-semibold py-3 px-6 rounded-xl
                       hover:bg-gray-50 transition-all duration-200
                       flex items-center justify-center gap-2">
                <i data-lucide="arrow-down-to-line" class="w-5 h-5"></i>
                {{ __('Request Withdrawal') }}
            </button>
        </div>
    </div>

    <!-- Withdrawal Methods -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-text-white mb-2">
            {{ __('Withdrawal Methods') }}
        </h2>
        <p class="text-text-secondary">
            {{ __('Choose your preferred withdrawal method') }}
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($methods as $method)
            <div
                class="glass-card bg-bg-secondary rounded-xl p-6 transition-all duration-200 ease-in-out hover:scale-[1.02] border-2 border-transparent dark:border-zinc-700 hover:border-purple-500">

                <div class="flex items-start justify-between mb-4">
                    <div class="bg-linear-to-br from-purple-100 to-pink-100 p-3 rounded-xl">
                        <i data-lucide="credit-card" class="w-6 h-6 text-purple-600"></i>
                    </div>

                    @if ($method->userWithdrawalAccounts->isNotEmpty())
                        <span
                            class="badge bg-{{ $method->userWithdrawalAccounts->first()->status?->value === 'active' ? 'green' : 'red' }}-500 text-white">
                            {{ $method->userWithdrawalAccounts->first()->status?->name }}
                        </span>
                    @else
                        <span class="badge bg-green-500 text-white">
                            {{ __('Available') }}
                        </span>
                    @endif
                </div>

                <h3 class="text-xl font-bold text-text-white mb-2">
                    {{ $method->name }}
                </h3>

                <p class="text-sm text-text-secondary mb-4">
                    {{ __('Withdraw funds using') }}
                    <span class="font-semibold">{{ $method->name }}</span>
                    {{ __('account') }}
                </p>

                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-text-secondary">{{ __('Min Amount:') }}</span>
                        <span class="font-semibold text-text-white">${{ $method->min_amount }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-text-secondary">{{ __('Max Amount:') }}</span>
                        <span class="font-semibold text-text-white">${{ $method->max_amount }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-text-secondary">{{ __('Fee:') }}</span>
                        <span class="font-semibold text-purple-600">${{ $method->fee_amount }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs mb-4">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                    <span class="text-text-secondary/80">1–3 business days</span>
                </div>

                {{-- Actions --}}
                @if ($method->userWithdrawalAccounts->first()?->status?->value === 'active')
                    <x-ui.button class="w-full py-2! px-6!">
                        {{ __('Request Withdrawal') }}
                    </x-ui.button>

                @elseif ($method->userWithdrawalAccounts->first()?->status?->value === 'pending')
                    <x-ui.button disabled variant="tertiary" class="w-full py-2! px-6!">
                        {{ __('Verify Pending') }}
                    </x-ui.button>

                @elseif ($method->userWithdrawalAccounts->isEmpty())
                    <x-ui.button
                        href="{{ route('user.wallet.withdrawal-form', encrypt($method->id)) }}"
                        variant="secondary"
                        class="w-full py-2! px-6!">
                        {{ __('Add Method') }}
                    </x-ui.button>

                @elseif ($method->userWithdrawalAccounts->first()?->status?->value === 'declined')
                    <div class="flex gap-3">
                        <x-ui.button
                            wire:click="openModal({{ $method->userWithdrawalAccounts->first()->id }})"
                            variant="tertiary"
                            class="py-2!">
                            {{ __('Reason') }}
                        </x-ui.button>

                        <x-ui.button
                            href="{{ route('user.wallet.withdrawal-form-update', encrypt($method->userWithdrawalAccounts->first()->id)) }}"
                            variant="secondary"
                            class="w-full py-2! px-6!">
                            {{ __('Re-Submit') }}
                        </x-ui.button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
