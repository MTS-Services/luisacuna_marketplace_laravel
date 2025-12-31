<div x-data="{ transactionDetailModalShow: @entangle('transactionDetailModalShow').live }"
    @order-detail-modal-open.window="transactionDetailModalShow = true; console.log('open order detail');"
    x-show="transactionDetailModalShow"
    class="fixed inset-0 bg-black/5 backdrop-blur-md z-20 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

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
                <p class="text-text-white font-semibold tracking-wide">
                    Loading order details
                </p>
                <p class="text-text-muted text-sm animate-pulse">
                    Please wait a moment…
                </p>
            </div>
        </div>
    @else
        @if ($transaction)
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-2xl p-4 sm:p-6 lg:p-8 max-w-7xl w-full shadow-2xl border border-slate-700/50 max-h-[90vh] overflow-y-auto">
    
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-700/50">
        <div>
            <h2 class="text-white text-2xl md:text-3xl font-bold tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                Transaction Details
            </h2>
            <p class="text-slate-400 text-sm mt-2">Comprehensive overview of transaction #{{ $transaction->transaction_id }}</p>
        </div>
        <button wire:click="closeModal" @click="transactionDetailModalShow = false" class="text-slate-400 hover:text-white hover:bg-slate-700/50 p-2 rounded-lg transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="space-y-6">
        
        <!-- Status Banner -->
        <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 rounded-xl p-6 border border-slate-700/50">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    @if ($transaction->status === 'SUCCESS')
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <span class="inline-flex px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-sm font-semibold">Success</span>
                            <p class="text-slate-400 text-sm mt-1">Transaction completed successfully</p>
                        </div>
                    @elseif($transaction->status === 'PENDING')
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="inline-flex px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-sm font-semibold">Pending</span>
                            <p class="text-slate-400 text-sm mt-1">Transaction is being processed</p>
                        </div>
                    @elseif($transaction->status === 'FAILED')
                        <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <span class="inline-flex px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-sm font-semibold">Failed</span>
                            <p class="text-slate-400 text-sm mt-1">Transaction could not be completed</p>
                        </div>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-slate-400 text-xs">Transaction Date</p>
                    <p class="text-white font-semibold">{{ $transaction->created_at->format('F j, Y') }}</p>
                    <p class="text-slate-400 text-sm">{{ $transaction->created_at->format('g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-indigo-500/10 to-indigo-600/5 rounded-xl p-6 border border-indigo-500/20">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-indigo-300 text-sm font-medium">Amount</p>
                    <div class="w-8 h-8 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-white text-2xl font-bold">{{ number_format($transaction->amount, 2) }}</p>
                <p class="text-slate-400 text-xs mt-1">{{ $transaction->currency }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 rounded-xl p-6 border border-purple-500/20">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-purple-300 text-sm font-medium">Fee Amount</p>
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-white text-2xl font-bold">{{ number_format($transaction->fee_amount, 2) }}</p>
                <p class="text-slate-400 text-xs mt-1">{{ $transaction->currency }}</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 rounded-xl p-6 border border-emerald-500/20">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-emerald-300 text-sm font-medium">Net Amount</p>
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-white text-2xl font-bold">{{ number_format($transaction->net_amount, 2) }}</p>
                <p class="text-slate-400 text-xs mt-1">{{ $transaction->currency }}</p>
            </div>
        </div>

        <!-- Transaction Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Transaction Details -->
            <div class="bg-slate-800/40 rounded-xl p-6 border border-slate-700/50">
                <h3 class="text-white text-lg font-semibold mb-5 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                    Transaction Information
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Transaction ID</span>
                        <span class="text-white font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Correlation ID</span>
                        <span class="text-white font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction->correlation_id ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Order ID</span>
                        <span class="text-white font-mono text-sm">{{ $transaction->order_id ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Type</span>
                        <span class="text-white font-medium text-sm">{{ $transaction->type }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-400 text-sm">Calculation Type</span>
                        <span class="text-white font-medium text-sm">{{ $transaction->calculation_type ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-slate-800/40 rounded-xl p-6 border border-slate-700/50">
                <h3 class="text-white text-lg font-semibold mb-5 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                    Payment Information
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Payment Gateway</span>
                        <span class="text-white font-medium text-sm capitalize">{{ $transaction->payment_gateway ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">Gateway Transaction ID</span>
                        <span class="text-white font-mono text-sm text-right break-all max-w-[60%]">{{ $transaction->gateway_transaction_id ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-3 border-b border-slate-700/50">
                        <span class="text-slate-400 text-sm">User</span>
                        <span class="text-white font-medium text-sm">{{ $transaction->user->full_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-400 text-sm">Balance Snapshot</span>
                        <span class="text-white font-medium text-sm">{{ number_format($transaction->balance_snapshot, 2) }} {{ $transaction->currency }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($transaction->notes || $transaction->failure_reason || $transaction->metadata)
        <div class="bg-slate-800/40 rounded-xl p-6 border border-slate-700/50">
            <h3 class="text-white text-lg font-semibold mb-5 flex items-center gap-2">
                <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                Additional Information
            </h3>
            
            @if($transaction->notes)
            <div class="mb-5">
                <p class="text-slate-400 text-sm font-medium mb-2">Notes</p>
                <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700/30">
                    <p class="text-slate-300 text-sm">{{ $transaction->notes }}</p>
                </div>
            </div>
            @endif

            @if($transaction->failure_reason)
            <div class="mb-5">
                <p class="text-slate-400 text-sm font-medium mb-2">Failure Reason</p>
                <div class="bg-red-500/10 rounded-lg p-4 border border-red-500/20">
                    <p class="text-red-300 text-sm">{{ $transaction->failure_reason }}</p>
                </div>
            </div>
            @endif

            @if($transaction->metadata)
            <div>
                <p class="text-slate-400 text-sm font-medium mb-2">Metadata</p>
                <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700/30 overflow-x-auto">
                    <pre class="text-xs text-slate-300 font-mono">{{ json_encode($transaction->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="" class="px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

    </div>
</div>
        @else
            <div class="text-center text-text-muted text-sm">
                {{ __('No order found.') }}
            </div>
        @endif
    @endif

</div>
