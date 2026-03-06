<div class="flex items-center justify-between mb-8 border-b border-primary-200 dark:border-zinc-800 pb-5">
    <div>
        <h2 class="text-text-white text-2xl md:text-3xl font-bold tracking-tight">
            {{ __('Order Detail') }}
        </h2>
        <p class="text-text-muted text-sm mt-1">
            {{ __('Review all information regarding this transaction') }}
        </p>
    </div>
    <x-ui.button href="{{ $backUrl }}" class="w-auto! py-2! text-nowrap">
        <flux:icon name="arrow-left" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
        {{ __('Back') }}
    </x-ui.button>
</div>

<div class="glass-card rounded-2xl p-2 sm:p-6 md:p-8 bg-white/5 border border-primary-200 dark:border-zinc-800">
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 flex flex-col md:flex-row gap-4 sm:gap-6">
            <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ storage_url($data?->source?->game?->logo) }}" alt="{{ $data?->source?->name }}"
                    class="w-full h-full object-cover rounded-full border border-primary-200 dark:border-zinc-800 shadow-lg">
            </div>

            <div class="flex-1 space-y-4">
                <h3 class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-700 pl-3 leading-none">
                    {{ __('Order Info') }}
                </h3>
                <div class="grid grid-cols-1 gap-y-3">
                    <div class="flex justify-between items-start border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Order ID: ') }}</span>
                        <span
                            class="text-text-white font-medium text-right break-all ml-4 text-sm uppercase">{{ $data->order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Product: ') }}</span>
                        <span class="text-text-white font-medium">{{ $data?->source?->name }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Purchased at: ') }}</span>
                        <span class="text-text-white font-medium">{{ $data->created_at_formatted }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Status: ') }}</span>
                        <span class="text-text-white font-medium badge badge-soft {{ $data->status->color() }}">{{ $data->status->label() }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Default Price: ') }} </span>
                        <span class="text-text-white font-medium">{{ $data->default_grand_total }}
                            {{ $data->default_currency }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-primary-200 dark:border-zinc-800 pb-2">
                        <span class="text-text-muted text-sm">{{ __('Display Price: ') }}</span>
                        <span class="text-text-white font-medium">{{ $data->grand_total }}
                            {{ $data->display_currency }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-text-muted text-sm">{{ __('Total Amount') }} <span class="text-xs text-text-muted">{{ __('(as payment): ') }}</span></span>
                        <span class="text-zinc-500 font-bold text-lg">{{ $data->transactions->first()?->amount }}
                            {{ $data->transactions->first()?->currency }}</span>

                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1">
            <h3 class="text-text-white text-xl font-semibold mb-4 border-l-4 border-primary-200 dark:border-zinc-800 pl-3 leading-none">
                {{ __('Transaction History') }}
            </h3>
            <div class="overflow-hidden border border-primary-200 dark:border-zinc-800 rounded-xl bg-main">
                <table class="w-full text-sm text-left">
                    <thead class="bg-card text-text-white uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 font-semibold">{{ __('Transactions ID') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('Amount') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('Method') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('Date') }}</th>
                            <th class="px-4 py-3 font-semibold">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($data->transactions as $transaction)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted">
                                    {{ $transaction->transaction_id }}</td>
                                <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                    {{ $transaction->amount }} {{ $transaction->currency }}</td>
                                <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                    {{ $transaction->payment_gateway }}</td>
                                <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted text-right text-xs">
                                    {{ $transaction->created_at_formatted }}</td>

                                <td class="px-1 sm:px-4 py-1 sm:py-3 text-right text-xs">
                                    <button type="button"
                                        @click="$dispatch('transaction-detail-modal-open', { transactionId: '{{ $transaction->transaction_id }}' })"
                                        class="inline-block px-3 py-1.5 text-xs font-medium text-white bg-primary rounded-md hover:bg-primary/90 transition">
                                        {{ __('Details') }}
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-text-muted italic">
                                    {{ __('No transactions found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="glass-card rounded-2xl p-6 mt-8 bg-zinc-900/40 border border-primary-200 dark:border-zinc-800 shadow-sm relative overflow-hidden group hover:border-zinc-700 transition-all duration-300">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg">
                <svg class="w-5 h-5 text-text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
            </div>
            <h3 class="text-text-white text-base font-bold tracking-tight">
                {{ __('Feedback') }}
            </h3>
        </div>

        @if ($data->feedbacks->first())
            <span
                class="text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider {{ $data->feedbacks->first()->type->color() }} bg-opacity-10 border border-current opacity-80">
                {{ $data->feedbacks->first()->type->label() }}
            </span>
        @endif
    </div>

    <div class="relative">
        @forelse ($data->feedbacks->take(1) as $feedback)
            <div class="mb-6">
                <p class="text-text-white leading-relaxed font-medium">
                    {{ $feedback->message }}
                </p>
            </div>

            <hr class="border-zinc-800 mb-5">

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-zinc-700 to-zinc-800 flex items-center justify-center border border-zinc-700 shadow-inner">
                        <img src="{{ auth_storage_url($feedback->author?->avatar) }}" alt="{{ $feedback->author?->username }}"
                            class="w-full h-full rounded-full ring-2 ring-white/10 object-cover">
                    </div>
                    <div>
                        <a href="{{ route('profile', $feedback->author?->username) }}"
                            class="text-text-white text-sm font-semibold leading-none mb-1" target="_blank">
                            {{ $feedback->author?->full_name }}
                        </a>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-zinc-500 text-[11px] block italic mb-1">
                        {{ $feedback->created_at_formatted }}
                    </span>
                    <div class="flex gap-1 justify-end">
                        <span class="w-1.5 h-1.5 rounded-full bg-zinc-500/40 animate-pulse"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-zinc-700"></span>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-10 text-center">
                <p class="text-zinc-500 text-sm italic">{{ __('No feedback to review.') }}</p>
            </div>
        @endforelse
    </div>

    <div class="absolute top-0 right-0 p-1">
        <div class="w-1.5 h-1.5 rounded-full bg-zinc-800"></div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
    <div class="glass-card p-6 bg-main border border-primary-200 dark:border-zinc-800 rounded-2xl">
        <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
            <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
            {{ __('Seller Details') }}
        </h3>
        @if ($data?->source?->user)
            <div class="flex items-center gap-5">
                <a href="{{ route('profile', $data->source->user->username) }}">
                    <img src="{{ auth_storage_url($data->source->user->avatar) }}" alt="{{ $data->source->user->full_name }}"
                        class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                </a>
                <div class="space-y-1">
                    <div class="flex gap-2 items-center pb-2">
                        <a href="{{ route('profile', $data->source->user->username) }}" class="text-text-white font-bold">{{ $data->source->user->full_name }}</a>
                    </div>
                    <div class="flex gap-2 items-center pb-2">
                        <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                        </p>
                        <a href="{{ route('profile', $data->source->user->username) }}"
                            class="text-text-muted text-xs underline">{{ $data->source->user->username }}</a>
                    </div>
                    <div class="flex gap-2 items-center pb-2">
                        <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                        <a href="mailto:{{ $data->source->user->email }}" class="text-text-muted text-xs break-all underline">{{ $data->source->user->email }}</a>
                    </div>
                </div>
            </div>
        @else
            <p class="text-text-muted text-sm italic">{{ __('Seller information not available.') }}</p>
        @endif
    </div>

    <div class="glass-card p-6 bg-main border border-primary-200 dark:border-zinc-800 rounded-2xl">
        <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
            <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
            {{ __('Buyer Details') }}
        </h3>
        @if ($data?->user)
            <div class="flex items-center gap-5">
                <a href="{{ route('profile', $data->user->username) }}">
                    <img src="{{ auth_storage_url($data->user->avatar) }}" alt="{{ $data->user->full_name }}"
                        class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                </a>
                <div class="space-y-1">
                    <div class="flex gap-2 items-center pb-2">
                        <a href="{{ route('profile', $data->user->username) }}" class="text-text-white font-bold">{{ $data->user->full_name }}</a>
                    </div>
                    <div class="flex gap-2 items-center pb-2">
                        <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                        </p>
                        <a href="{{ route('profile', $data->user->username) }}"
                            class="text-text-muted text-xs underline">{{ $data->user->username }}</a>
                    </div>
                    <div class="flex gap-2 items-center pb-2">
                        <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                        <a href="mailto:{{ $data->user->email }}" class="text-text-muted text-xs underline">{{ $data->user->email }}</a>
                    </div>
                </div>
            </div>
        @else
            <p class="text-text-muted text-sm italic">{{ __('Buyer information not available.') }}</p>
        @endif
    </div>
</div>

