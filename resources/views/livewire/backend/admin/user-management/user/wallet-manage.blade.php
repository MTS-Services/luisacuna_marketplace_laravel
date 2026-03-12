<div class="space-y-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
            class="relative overflow-hidden bg-[#1e1b4b] dark:bg-[#0f172a] rounded-[2.5rem] p-9 shadow-2xl shadow-indigo-200 dark:shadow-none transition-all duration-300">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-500/20 rounded-full blur-[60px]"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <p
                            class="text-indigo-200/70 dark:text-slate-400 font-bold tracking-[0.15em] uppercase text-[10px]">
                            {{ __('Total Wallet Balance') }}</p>
                    </div>
                    <h2 class="text-white text-5xl font-extrabold mt-4 tracking-tight">
                        <span
                            class="text-2xl font-medium text-indigo-300/50">{{ currency_symbol() }}</span>{{ currency_exchange($wallet->balance ?? 0) }}
                    </h2>
                </div>
                <div class="mt-8">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <p class="text-[11px] font-medium text-indigo-100">{{ __('Available for use') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-9 shadow-sm">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                <p class="text-slate-500 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                    {{ __('Frozen Amount') }}</p>
            </div>
            <h2 class="text-slate-900 dark:text-white text-4xl font-bold mt-2 tracking-tight">
                <span
                    class="text-xl font-medium text-slate-400">{{ currency_symbol() }}</span>{{ currency_exchange($frozenAmount ?? 0) }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-6 text-xs italic">
                {{ __('Funds locked in active escrows.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div
            class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
                <span
                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 rounded-lg text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </span>
                {{ __('Add Balance') }}
            </h3>
            <form wire:submit.prevent="addBalance" class="space-y-5">
                <x-ui.input type="number" step="0.01" wire:model.defer="addAmount" placeholder="0.00"
                    class="!bg-slate-50 dark:!bg-slate-800/50" />
                <x-ui.textarea wire:model.defer="addReason" placeholder="{{ __('Deposit note') }}" rows="2"
                    class="!bg-slate-50 dark:!bg-slate-800/50" />
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-bold rounded-xl py-3 shadow-lg shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 transition-all">{{ __('Deposit') }}</button>
            </form>
        </div>

        <div
            class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 border border-slate-200 dark:border-slate-800 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center gap-2">
                <span
                    class="w-8 h-8 flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 rounded-lg text-rose-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </span>
                {{ __('Deduct Balance') }}
            </h3>
            <form wire:submit.prevent="cutBalance" class="space-y-5">
                <x-ui.input type="number" step="0.01" wire:model.defer="cutAmount" placeholder="0.00"
                    class="!bg-slate-50 dark:!bg-slate-800/50" />
                <x-ui.textarea wire:model.defer="cutReason" placeholder="{{ __('Deduction reason') }}" rows="2"
                    class="!bg-slate-50 dark:!bg-slate-800/50" />
                <button type="submit"
                    class="w-full bg-slate-900 dark:bg-slate-700 text-white font-bold rounded-xl py-3 hover:bg-black transition-all">{{ __('Deduct') }}</button>
            </form>
        </div>
    </div>

    <div
        class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div
            class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">{{ __('Transaction History') }}</h3>
            <span
                class="text-xs font-medium px-3 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full text-slate-500 italic">
                {{ __('Showing last') }} {{ $perPage }} {{ __('records') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="text-[11px] uppercase tracking-widest text-slate-400 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-8 py-4 font-bold">{{ __('Date') }}</th>
                        <th class="px-8 py-4 font-bold">{{ __('Type') }}</th>
                        <th class="px-8 py-4 font-bold">{{ __('Amount') }}</th>
                        <th class="px-8 py-4 font-bold">{{ __('Snapshot') }}</th>
                        <th class="px-8 py-4 font-bold">{{ __('Note') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="px-8 py-5">
                                <span
                                    class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $transaction->created_at->format('M d, Y') }}</span>
                                <div class="text-[10px] text-slate-400">{{ $transaction->created_at->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $isCredit =
                                        $transaction->calculation_type === \App\Enums\CalculationType::CREDIT->value;
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase badge {{ $transaction->calculation_type->color() }}">
                                    {{ $transaction->type }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-bold {{ $transaction->calculation_type->textColor() }}">
                                    {{ $transaction->calculation_type->prefix() }}{{ currency_symbol() }}{{ number_format($transaction->amount, 2) }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="text-sm text-slate-500 dark:text-slate-400">{{ currency_symbol() }}{{ number_format($transaction->balance_snapshot, 2) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs text-slate-600 dark:text-slate-400 truncate max-w-xs">
                                    {{ $transaction->notes ?? '-' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">
                                {{ __('No transactions found for this user.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transactions->hasPages())
            <div class="px-8 py-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
