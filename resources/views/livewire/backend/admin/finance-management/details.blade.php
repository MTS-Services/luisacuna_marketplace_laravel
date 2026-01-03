<div x-data="{ transactionDetailModalShow: @entangle('transactionDetailModalShow').live }" @order-detail-modal-open.window="transactionDetailModalShow = true;"
    x-show="transactionDetailModalShow" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" x-cloak
    class="fixed inset-0 h-screen z-30 bg-black/5 backdrop-blur-lg flex items-center justify-center">

    @if ($isLoading)
        <div class="bg-main/90 backdrop-blur-xl rounded-3xl p-10 max-w-md w-full shadow-2xl border border-white/10
               flex flex-col items-center justify-center gap-6"
            @click.away="transactionDetailModalShow = false">
            <!-- Spinner -->
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 rounded-full border-4 border-white/10"></div>

                <div
                    class="absolute inset-0 rounded-full border-4 border-t-transparent
                       border-l-transparent border-r-zinc-400 border-b-zinc-200
                       animate-spin">
                </div>
            </div>

            <!-- Text -->
            <div class="text-center space-y-1">
                <p class="text-text-text-white font-semibold tracking-wide">
                    Loading transaction details
                </p>
                <p class="text-text-muted text-sm animate-pulse">
                    Please wait a moment…
                </p>
            </div>
        </div>
    @else
        @if ($transaction)
            <div class="bg-main rounded-2xl pb-4 sm:pb-6 lg:pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">

                <!-- Header Section -->
                <div class="flex items-center justify-between pt-4 sm:pt-6 lg:pt-8 pb-6 sticky top-0 z-20  bg-main/95 backdrop-blur border-b border-white/10 mb-5">
                    <div>
                        <h2
                            class="text-text-text-white text-2xl md:text-3xl font-bold tracking-tight flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            {{ __('Transaction Details') }}
                        </h2>
                        <p class="text-text-muted text-sm mt-2">
                            {{ __('Comprehensive overview of transaction ') }}{{ $transaction?->transaction_id }}</p>
                    </div>
                    <button wire:click="closeModal" @click="transactionDetailModalShow = false"
                        class="text-text-muted hover:text-text-white hover:bg-slate-700/50 p-2 rounded-lg transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">

                    <!-- Financial Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="glass-card rounded-xl p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-text-text-white text-sm font-medium">{{ __('Amount') }}</p>
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-text-white">
                                {{ $transaction?->calculation_type?->prefix() }}
                                {{ number_format($transaction?->amount ?? 0, 2) }}
                            </p>
                            <p class="text-text-muted text-xs mt-1">{{ $transaction?->currency }}</p>
                        </div>

                        <div class="glass-card rounded-xl p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-text-text-white text-sm font-medium">{{ __('Fee Amount') }}</p>
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-text-text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-text-white">
                                {{ number_format($transaction?->fee_amount ?? 0, 2) }}
                            </p>
                            <p class="text-text-muted text-xs mt-1">{{ $transaction?->currency }}</p>
                        </div>

                        <div class="glass-card rounded-xl p-6">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-text-white text-sm font-medium">{{ __('Net Amount') }}</p>
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-text-white">
                                {{ $transaction?->calculation_type?->prefix() }}
                                {{ number_format($transaction?->net_amount ?? 0, 2) }}
                            </p>

                            <p class="text-text-muted text-xs mt-1">
                                {{ $transaction?->currency }}
                            </p>

                        </div>
                    </div>

                    <!-- Transaction Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Transaction Details -->
                        <div class="glass-card rounded-xl p-6">
                            <h3 class="text-text-white text-lg font-semibold mb-5 flex items-center gap-2">
                                {{ __('Transaction Information') }}
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('Transaction ID') }}</span>
                                    <span
                                        class="text-text-white font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction?->transaction_id }}</span>
                                </div>
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('Correlation ID') }}</span>
                                    <span
                                        class="text-text-white font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction?->correlation_id }}</span>
                                </div>
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('Transaction Type') }}</span>
                                    <span
                                        class="font-medium text-sm badge badge-soft {{ $transaction->type->color() }}">{{ $transaction?->type->label() }}</span>
                                </div>
                                <div class="flex justify-between items-start">
                                    <span class="text-text-muted text-sm">{{ __('Date') }}</span>
                                    <span class="font-medium text-sm">{{ $transaction?->created_at_formatted }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="glass-card rounded-xl p-6">
                            <h3 class="text-text-white text-lg font-semibold mb-5 flex items-center gap-2">
                                {{ __('User Information') }}
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('Name') }}</span>
                                    <span
                                        class="text-text-white font-medium text-sm capitalize">{{ $transaction?->user?->full_name }}</span>
                                </div>
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('User Name') }}</span>
                                    <a href="{{ route('profile', $transaction?->user?->username) }}" target="_blank"
                                        class="text-zinc-400 font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction?->user?->username }}</a>
                                </div>
                                <div class="flex justify-between items-start pb-3 border-b border-zinc-800">
                                    <span class="text-text-muted text-sm">{{ __('User Type') }}</span>
                                    <span
                                        class="text-text-white font-medium text-sm badge badge-soft {{ $transaction?->user?->user_type->color() }}">{{ $transaction?->user?->user_type->label() }}</span>
                                </div>
                                <div class="flex justify-between items-start">
                                    <span class="text-text-muted text-sm">{{ __('Balance Snapshot') }}</span>
                                    <span
                                        class="text-text-white font-medium text-sm">{{ number_format($transaction?->balance_snapshot, 2) }}
                                        {{ $transaction?->currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if ($transaction->notes || $transaction->failure_reason || $transaction->metadata)
                        <div class="glass-card rounded-2xl p-6 space-y-6">

                            <!-- Header -->
                            <h3 class="text-text-white text-lg font-semibold">
                                {{ __('Additional Information') }}
                            </h3>

                            <!-- Grid Wrapper -->
                            <div class="relative grid grid-cols-1 md:grid-cols-[1fr_auto_1fr] gap-6">

                                <!-- LEFT COLUMN -->
                                <div class="space-y-4">

                                    @if ($transaction?->order?->order_id)
                                        <div class="p-4 rounded-xl">
                                            <p class="text-text-white text-xs uppercase tracking-wide mb-2">
                                                {{ __('Order ID') }}
                                            </p>
                                            <p class="text-text-white text-sm">
                                                {{ $transaction->order->order_id }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($transaction->status)
                                        <div class="p-4 rounded-xl">
                                            <p class="text-text-white text-xs uppercase tracking-wide mb-2">
                                                {{ __('Note') }}
                                            </p>
                                            <p class="text-text-white text-sm">
                                                {{ $transaction->notes }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($transaction->payment_gateway)
                                        <div class="p-4 rounded-xl">
                                            <p class="text-text-white text-xs uppercase tracking-wide mb-2">
                                                {{ __('Payment Gateway') }}
                                            </p>
                                            <p class="text-text-white text-sm">
                                                {{ $transaction->payment_gateway }}
                                            </p>
                                        </div>
                                    @endif

                                </div>

                                <!-- VERTICAL DIVIDER (Only Desktop) -->
                                <div class="hidden md:block w-px bg-zinc-800 rounded-full"></div>

                                <!-- RIGHT COLUMN -->
                                <div class="space-y-4">

                                    @if ($transaction->gateway_transaction_id)
                                        <div class="p-4 rounded-xl">
                                            <p class="text-text-white text-xs uppercase tracking-wide mb-2">
                                                {{ __('Gateway Transaction ID') }}
                                            </p>
                                            <p class="text-text-white text-sm break-all">
                                                {{ $transaction->gateway_transaction_id }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($transaction->notes)
                                        <div class="p-4 rounded-xl">
                                            <p class="text-text-white text-xs uppercase tracking-wide mb-2">
                                                {{ __('Notes') }}
                                            </p>
                                            <p class="text-text-white text-sm leading-relaxed">
                                                {{ $transaction->notes }}
                                            </p>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                    @endif
                </div>
            </div>
        @else
            <div class="text-center text-text-muted text-sm">
                {{ __('No order found.') }}
            </div>
        @endif
    @endif


</div>
