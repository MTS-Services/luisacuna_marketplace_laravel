<div class="max-w-[1600px] mx-auto p-4 lg:p-8 space-y-8">

    {{-- ══════════════════════════════════════════════════════
         TOP: User Identity Banner
    ══════════════════════════════════════════════════════ --}}
    <div
        class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 p-6 sm:p-8">

            {{-- Avatar --}}
            <div
                class="shrink-0 w-24 h-24 rounded-[1.5rem] overflow-hidden border-4 border-white dark:border-zinc-700 shadow-xl bg-zinc-100 flex items-center justify-center">
                @if ($user->avatar)
                    <img src="{{ auth_storage_url($user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500 to-indigo-600">
                        <span
                            class="text-2xl font-black text-white">{{ strtoupper(substr($user->username, 0, 2)) }}</span>
                    </div>
                @endif
            </div>

            {{-- Identity --}}
            <div class="flex-1 min-w-0 text-center sm:text-left">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white truncate">{{ $user->full_name }}</h2>
                    <span
                        class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $user->account_status->color() }}">
                        {{ $user->account_status->label() }}
                    </span>
                    @if ($user->isVerifiedSeller())
                        <span
                            class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border border-emerald-500 text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40">
                            ✓ Verified Seller
                        </span>
                    @endif
                </div>
                <p class="text-sm text-primary-500 font-bold">{{ '@' . $user->username }}</p>
                <p class="text-xs text-zinc-500 mt-1 font-mono break-all">{{ $user->uuid }}</p>
            </div>

            {{-- Quick Metrics --}}
            <div class="shrink-0 flex gap-4 text-center">
                <div
                    class="p-4 rounded-2xl bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10 min-w-[90px]">
                    <p class="text-[10px] font-black uppercase text-zinc-400">Wallet</p>
                    <p class="text-lg font-black text-emerald-600 mt-1">
                        {{ number_format($user->wallet->balance ?? 0, 2) }}</p>
                </div>
                <div
                    class="p-4 rounded-2xl bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10 min-w-[90px]">
                    <p class="text-[10px] font-black uppercase text-zinc-400">Points</p>
                    <p class="text-lg font-black text-primary-600 mt-1">{{ $user->userPoint->points ?? 0 }}</p>
                </div>
                @if ($activeRank)
                    <div
                        class="p-4 rounded-2xl bg-zinc-50 dark:bg-white/5 border border-zinc-200 dark:border-white/10 min-w-[90px]">
                        <p class="text-[10px] font-black uppercase text-zinc-400">Rank</p>
                        <p class="text-sm font-black text-amber-600 mt-1">{{ $activeRank->name }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Tab Navigation ── --}}
        <div class="border-t border-zinc-100 dark:border-white/10 flex overflow-x-auto">
            <button wire:click="setTab('personal')"
                class="relative flex-1 min-w-[120px] px-6 py-4 text-[11px] font-black uppercase tracking-widest transition-all
                       {{ $activeTab === 'personal' ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-950/30' : 'text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-white/5' }}">
                @if ($activeTab === 'personal')
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-primary-500 rounded-full"></span>
                @endif
                <flux:icon name="user" class="w-4 h-4 mx-auto mb-1" />
                Personal
            </button>

            <button wire:click="setTab('buyer')"
                class="relative flex-1 min-w-[120px] px-6 py-4 text-[11px] font-black uppercase tracking-widest transition-all
                       {{ $activeTab === 'buyer' ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/30' : 'text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-white/5' }}">
                @if ($activeTab === 'buyer')
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500 rounded-full"></span>
                @endif
                <flux:icon name="shopping-bag" class="w-4 h-4 mx-auto mb-1" />
                Buyer History
            </button>

            @if ($user->isVerifiedSeller())
                <button wire:click="setTab('seller')"
                    class="relative flex-1 min-w-[120px] px-6 py-4 text-[11px] font-black uppercase tracking-widest transition-all
                           {{ $activeTab === 'seller' ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30' : 'text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-white/5' }}">
                    @if ($activeTab === 'seller')
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-amber-500 rounded-full"></span>
                    @endif
                    <flux:icon name="store" class="w-4 h-4 mx-auto mb-1" />
                    Seller History
                </button>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         TAB: PERSONAL
    ══════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'personal')
        <div class="space-y-8" wire:key="tab-personal">

            {{-- Wallet & Financial Overview --}}
            <div>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-zinc-400 mb-4">Wallet & Finances</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $wallet = $user->wallet;
                        $finCards = [
                            [
                                'label' => 'Balance',
                                'value' => number_format($wallet->balance ?? 0, 2),
                                'color' => 'text-emerald-600',
                                'bg' => 'bg-emerald-50 dark:bg-emerald-950/30',
                                'border' => 'border-emerald-200 dark:border-emerald-800',
                            ],
                            [
                                'label' => 'Frozen / Locked',
                                'value' => number_format($wallet->locked_balance ?? 0, 2),
                                'color' => 'text-rose-600',
                                'bg' => 'bg-rose-50 dark:bg-rose-950/30',
                                'border' => 'border-rose-200 dark:border-rose-800',
                            ],
                            [
                                'label' => 'Total Deposited',
                                'value' => number_format($wallet->total_deposits ?? 0, 2),
                                'color' => 'text-sky-600',
                                'bg' => 'bg-sky-50 dark:bg-sky-950/30',
                                'border' => 'border-sky-200 dark:border-sky-800',
                            ],
                            [
                                'label' => 'Total Withdrawn',
                                'value' => number_format($wallet->total_withdrawals ?? 0, 2),
                                'color' => 'text-fuchsia-600',
                                'bg' => 'bg-fuchsia-50 dark:bg-fuchsia-950/30',
                                'border' => 'border-fuchsia-200 dark:border-fuchsia-800',
                            ],
                        ];
                    @endphp
                    @foreach ($finCards as $card)
                        <div
                            class="glass-card rounded-2xl p-5 border {{ $card['border'] }} {{ $card['bg'] }} shadow-sm">
                            <p class="text-[10px] font-black uppercase text-zinc-500">{{ $card['label'] }}</p>
                            <p class="mt-2 text-2xl font-black {{ $card['color'] }}">{{ $card['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Points & Rank --}}
            <div>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-zinc-400 mb-4">Points & Rank</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="glass-card rounded-2xl p-5 border border-primary-200 dark:border-primary-800 bg-primary-50 dark:bg-primary-950/30 shadow-sm">
                        <p class="text-[10px] font-black uppercase text-zinc-500">Total Points</p>
                        <p class="mt-2 text-3xl font-black text-primary-600">
                            {{ number_format($user->userPoint->points ?? 0) }}</p>
                    </div>
                    <div
                        class="glass-card rounded-2xl p-5 border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/30 shadow-sm">
                        <p class="text-[10px] font-black uppercase text-zinc-500">Current Rank</p>
                        @if ($activeRank)
                            <p class="mt-2 text-xl font-black text-amber-600">{{ $activeRank->name }}</p>
                            <p class="text-[10px] text-zinc-500 mt-1">
                                {{ number_format($activeRank->minimum_points) }} –
                                {{ number_format($activeRank->maximum_points) }} pts
                            </p>
                        @else
                            <p class="mt-2 text-sm font-bold text-zinc-400">No rank assigned</p>
                        @endif
                    </div>
                    <div
                        class="glass-card rounded-2xl p-5 border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/40 shadow-sm">
                        <p class="text-[10px] font-black uppercase text-zinc-500">Withdrawal Requests</p>
                        <p class="mt-2 text-3xl font-black text-fuchsia-600">{{ $withdrawalRequestsCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Withdrawal History --}}
            <div
                class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
                <div
                    class="bg-zinc-50 dark:bg-white/5 p-5 border-b border-zinc-100 dark:border-white/10 flex items-center justify-between">
                    <h3 class="font-black uppercase tracking-widest text-sm flex items-center gap-2">
                        <flux:icon name="arrow-up-tray" class="w-4 h-4 text-fuchsia-500" />
                        {{ __('Withdrawal History') }}
                    </h3>
                    <div class="relative">
                        <input wire:model.live.debounce.400ms="withdrawalSearch" type="text"
                            placeholder="{{ __('Search…') }}"
                            class="pl-3 pr-8 py-1.5 text-xs rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary-400" />
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="bg-zinc-50 dark:bg-white/5 text-[10px] uppercase font-black text-zinc-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Amount</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                            @forelse ($withdrawals as $w)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-3 font-mono text-xs text-zinc-400">{{ $w->id }}</td>
                                    <td class="px-6 py-3 font-black text-emerald-600">
                                        {{ number_format($w->amount, 2) }}</td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-zinc-100 dark:bg-white/10 text-zinc-600 dark:text-zinc-300">
                                            {{ $w->status ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-zinc-500">
                                        {{ $w->created_at->toDayDateTimeString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-xs text-zinc-400 font-bold uppercase">No
                                        withdrawal requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($withdrawals->hasPages())
                    <div class="p-4 border-t border-zinc-100 dark:border-white/10">
                        {{ $withdrawals->links() }}
                    </div>
                @endif
            </div>

            {{-- Point Gain History --}}
            <div
                class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
                <div
                    class="bg-zinc-50 dark:bg-white/5 p-5 border-b border-zinc-100 dark:border-white/10 flex items-center justify-between">
                    <h3 class="font-black uppercase tracking-widest text-sm flex items-center gap-2">
                        <flux:icon name="star" class="w-4 h-4 text-primary-500" />
                        {{ __('Point History') }}
                    </h3>
                    <div class="relative">
                        <input wire:model.live.debounce.400ms="pointSearch" type="text"
                            placeholder="{{ __('Search…') }}"
                            class="pl-3 pr-8 py-1.5 text-xs rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary-400" />
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="bg-zinc-50 dark:bg-white/5 text-[10px] uppercase font-black text-zinc-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-3 text-left">Points</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Notes</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                            @forelse ($pointLogs as $log)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="px-6 py-3 font-black {{ $log->points >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $log->points >= 0 ? '+' : '' }}{{ number_format($log->points) }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-primary-100 dark:bg-primary-950/40 text-primary-600">
                                            {{ $log->type->label() ?? $log->type->value }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-zinc-500 max-w-[240px] truncate">
                                        {{ $log->notes ?? '—' }}</td>
                                    <td class="px-6 py-3 text-xs text-zinc-500">
                                        {{ $log->created_at->toDayDateTimeString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-xs text-zinc-400 font-bold uppercase">No
                                        point history found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($pointLogs->hasPages())
                    <div class="p-4 border-t border-zinc-100 dark:border-white/10">
                        {{ $pointLogs->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         TAB: BUYER HISTORY
    ══════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'buyer')
        <div class="space-y-8" wire:key="tab-buyer">

            {{-- Buyer Stats Grid --}}
            <div>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-zinc-400 mb-4">Buyer Overview</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @php
                        $buyerCards = [
                            [
                                'label' => 'Paid Orders',
                                'value' => $paidOrdersCount,
                                'color' => 'text-primary-600',
                                'bg' => 'bg-primary-50 dark:bg-primary-950/30',
                                'border' => 'border-primary-200 dark:border-primary-800',
                            ],
                            [
                                'label' => 'Delivered Orders',
                                'value' => $deliveredOrdersCount,
                                'color' => 'text-emerald-600',
                                'bg' => 'bg-emerald-50 dark:bg-emerald-950/30',
                                'border' => 'border-emerald-200 dark:border-emerald-800',
                            ],
                            [
                                'label' => 'Disputes Raised',
                                'value' => $buyerDisputesCount,
                                'color' => 'text-rose-600',
                                'bg' => 'bg-rose-50 dark:bg-rose-950/30',
                                'border' => 'border-rose-200 dark:border-rose-800',
                            ],
                            [
                                'label' => 'Disputes Won',
                                'value' => $buyerDisputesWonCount,
                                'color' => 'text-amber-600',
                                'bg' => 'bg-amber-50 dark:bg-amber-950/30',
                                'border' => 'border-amber-200 dark:border-amber-800',
                            ],
                            [
                                'label' => 'Total Spent',
                                'value' => number_format($totalTransactionAmount, 2),
                                'color' => 'text-sky-600',
                                'bg' => 'bg-sky-50 dark:bg-sky-950/30',
                                'border' => 'border-sky-200 dark:border-sky-800',
                            ],
                        ];
                    @endphp
                    @foreach ($buyerCards as $card)
                        <div
                            class="glass-card rounded-2xl p-5 border {{ $card['border'] }} {{ $card['bg'] }} shadow-sm">
                            <p class="text-[10px] font-black uppercase text-zinc-500">{{ $card['label'] }}</p>
                            <p class="mt-2 text-2xl font-black {{ $card['color'] }}">{{ $card['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Transaction History --}}
            <div
                class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
                <div
                    class="bg-zinc-50 dark:bg-white/5 p-5 border-b border-zinc-100 dark:border-white/10 flex items-center justify-between gap-4">
                    <h3 class="font-black uppercase tracking-widest text-sm flex items-center gap-2 shrink-0">
                        <flux:icon name="credit-card" class="w-4 h-4 text-sky-500" />
                        {{ __('Transaction History') }}
                    </h3>
                    <input wire:model.live.debounce.400ms="transactionSearch" type="text"
                        placeholder="{{ __('Search by TX ID…') }}"
                        class="pl-3 pr-4 py-1.5 text-xs rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary-400 w-48" />
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="bg-zinc-50 dark:bg-white/5 text-[10px] uppercase font-black text-zinc-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-3 text-left">TX ID</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Amount</th>
                                <th class="px-6 py-3 text-left">Fee</th>
                                <th class="px-6 py-3 text-left">Net</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                            @forelse ($transactions as $tx)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-3 font-mono text-xs text-zinc-400">{{ $tx->transaction_id }}
                                    </td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-zinc-100 dark:bg-white/10 text-zinc-600 dark:text-zinc-300">
                                            {{ $tx->type->value ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 font-black text-zinc-800 dark:text-zinc-200">
                                        {{ number_format($tx->amount, 2) }}</td>
                                    <td class="px-6 py-3 text-rose-500 font-bold text-xs">
                                        {{ number_format($tx->fee_amount, 2) }}</td>
                                    <td class="px-6 py-3 font-black text-emerald-600">
                                        {{ number_format($tx->net_amount, 2) }}</td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase
                                            @if ($tx->status->value === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40
                                            @elseif ($tx->status->value === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-950/40
                                            @else bg-rose-100 text-rose-700 dark:bg-rose-950/40 @endif">
                                            {{ $tx->status->value }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-zinc-500">
                                        {{ $tx->created_at->toDayDateTimeString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-12 text-center text-xs text-zinc-400 font-bold uppercase">No
                                        transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($transactions->hasPages())
                    <div class="p-4 border-t border-zinc-100 dark:border-white/10">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

            {{-- Order History --}}
            <div
                class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
                <div
                    class="bg-zinc-50 dark:bg-white/5 p-5 border-b border-zinc-100 dark:border-white/10 flex items-center justify-between gap-4">
                    <h3 class="font-black uppercase tracking-widest text-sm flex items-center gap-2 shrink-0">
                        <flux:icon name="shopping-bag" class="w-4 h-4 text-indigo-500" />
                        {{ __('Order History') }}
                    </h3>
                    <input wire:model.live.debounce.400ms="orderSearch" type="text"
                        placeholder="{{ __('Search by Order ID…') }}"
                        class="pl-3 pr-4 py-1.5 text-xs rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-primary-400 w-48" />
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="bg-zinc-50 dark:bg-white/5 text-[10px] uppercase font-black text-zinc-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-3 text-left">Order ID</th>
                                <th class="px-6 py-3 text-left">Product</th>
                                <th class="px-6 py-3 text-left">Qty</th>
                                <th class="px-6 py-3 text-left">Total</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                            @forelse ($buyerOrders as $order)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-3 font-mono text-xs font-bold text-zinc-500">
                                        {{ $order->order_id }}</td>
                                    <td
                                        class="px-6 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 max-w-[180px] truncate">
                                        {{ $order->source?->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $order->quantity ?? 1 }}
                                    </td>
                                    <td class="px-6 py-3 font-black text-zinc-800 dark:text-zinc-200">
                                        {{ number_format($order->grand_total, 2) }}</td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $order->status->color() }}">
                                            {{ $order->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-zinc-500">
                                        {{ $order->created_at->toDayDateTimeString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-12 text-center text-xs text-zinc-400 font-bold uppercase">No
                                        orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($buyerOrders->hasPages())
                    <div class="p-4 border-t border-zinc-100 dark:border-white/10">
                        {{ $buyerOrders->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         TAB: SELLER HISTORY
    ══════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'seller')
        <div class="space-y-8" wire:key="tab-seller">

            {{-- Seller Stats Grid --}}
            <div>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-zinc-400 mb-4">Seller Overview</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @php
                        $sellerCards = [
                            [
                                'label' => 'Sold Orders',
                                'value' => $soldOrdersCount,
                                'color' => 'text-emerald-600',
                                'bg' => 'bg-emerald-50 dark:bg-emerald-950/30',
                                'border' => 'border-emerald-200 dark:border-emerald-800',
                            ],
                            [
                                'label' => 'Disputes Filed',
                                'value' => $sellerDisputesCount,
                                'color' => 'text-rose-600',
                                'bg' => 'bg-rose-50 dark:bg-rose-950/30',
                                'border' => 'border-rose-200 dark:border-rose-800',
                            ],
                            [
                                'label' => 'Disputes Won',
                                'value' => $sellerDisputesWonCount,
                                'color' => 'text-amber-600',
                                'bg' => 'bg-amber-50 dark:bg-amber-950/30',
                                'border' => 'border-amber-200 dark:border-amber-800',
                            ],
                            [
                                'label' => 'Cancelled Orders',
                                'value' => $cancelledOrdersCount,
                                'color' => 'text-zinc-600',
                                'bg' => 'bg-zinc-50 dark:bg-zinc-900/40',
                                'border' => 'border-zinc-200 dark:border-white/10',
                            ],
                            [
                                'label' => 'Total Products',
                                'value' => $productsCount,
                                'color' => 'text-primary-600',
                                'bg' => 'bg-primary-50 dark:bg-primary-950/30',
                                'border' => 'border-primary-200 dark:border-primary-800',
                            ],
                        ];
                    @endphp
                    @foreach ($sellerCards as $card)
                        <div
                            class="glass-card rounded-2xl p-5 border {{ $card['border'] }} {{ $card['bg'] }} shadow-sm">
                            <p class="text-[10px] font-black uppercase text-zinc-500">{{ $card['label'] }}</p>
                            <p class="mt-2 text-2xl font-black {{ $card['color'] }}">{{ $card['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Dispute Win Rate Visual --}}
            @if ($sellerDisputesCount > 0)
                <div
                    class="glass-card rounded-2xl p-6 border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-zinc-400 mb-3">Dispute Win Rate</p>
                    @php $winRate = round(($sellerDisputesWonCount / $sellerDisputesCount) * 100); @endphp
                    <div class="flex items-center gap-4">
                        <div class="flex-1 h-3 bg-zinc-100 dark:bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-emerald-500 transition-all duration-700"
                                style="width: {{ $winRate }}%"></div>
                        </div>
                        <span class="text-lg font-black text-emerald-600 shrink-0">{{ $winRate }}%</span>
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">{{ $sellerDisputesWonCount }} won out of
                        {{ $sellerDisputesCount }} total disputes</p>
                </div>
            @endif

            {{-- Seller Orders Table --}}
            <div
                class="glass-card rounded-[2rem] border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/60 shadow-xl overflow-hidden">
                <div
                    class="bg-zinc-50 dark:bg-white/5 p-5 border-b border-zinc-100 dark:border-white/10 flex items-center gap-2">
                    <flux:icon name="store" class="w-4 h-4 text-amber-500" />
                    <h3 class="font-black uppercase tracking-widest text-sm">{{ __('Sales History') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead
                            class="bg-zinc-50 dark:bg-white/5 text-[10px] uppercase font-black text-zinc-400 tracking-widest">
                            <tr>
                                <th class="px-6 py-3 text-left">Order ID</th>
                                <th class="px-6 py-3 text-left">Buyer</th>
                                <th class="px-6 py-3 text-left">Product</th>
                                <th class="px-6 py-3 text-left">Total</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-white/5">
                            @forelse ($sellerOrders as $order)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-3 font-mono text-xs font-bold text-zinc-500">
                                        {{ $order->order_id }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-xl overflow-hidden bg-gradient-to-br from-primary-400 to-indigo-500 flex items-center justify-center shrink-0">
                                                <span
                                                    class="text-[9px] font-black text-white">{{ strtoupper(substr($order->user?->username ?? '?', 0, 2)) }}</span>
                                            </div>
                                            <span
                                                class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">{{ $order->user?->username ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 max-w-[160px] truncate">
                                        {{ $order->source?->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-3 font-black text-zinc-800 dark:text-zinc-200">
                                        {{ number_format($order->grand_total, 2) }}</td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $order->status->color() }}">
                                            {{ $order->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-zinc-500">
                                        {{ $order->created_at->toDayDateTimeString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-12 text-center text-xs text-zinc-400 font-bold uppercase">No
                                        sales found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($sellerOrders->hasPages())
                    <div class="p-4 border-t border-zinc-100 dark:border-white/10">
                        {{ $sellerOrders->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endif

</div>
