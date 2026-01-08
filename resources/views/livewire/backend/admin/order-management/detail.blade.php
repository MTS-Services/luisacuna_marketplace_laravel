<div>
    <div
        class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-zinc-800">

        <div class="flex items-center justify-between mb-8 border-b border-zinc-800 pb-5">
            <div>
                <h2 class="text-text-white text-2xl md:text-3xl font-bold tracking-tight">
                    {{ __('Order Detail') }}
                </h2>
                <p class="text-text-muted text-sm mt-1">
                    {{ __('Review all information regarding this transaction') }}
                </p>
            </div>
            <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto py-2! text-nowrap">
                <flux:icon name="arrow-left"
                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                {{ __('Back') }}
            </x-ui.button>
        </div>

        <div class="glass-card rounded-2xl p-2 sm:p-6 md:p-8 bg-white/5 border border-zinc-800">
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="flex-1 flex flex-col md:flex-row gap-4 sm:gap-6">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 flex-shrink-0 mx-auto md:mx-0">
                        <img src="{{ storage_url($data?->source?->game?->logo) }}" alt="{{ $data?->source?->name }}"
                            class="w-full h-full object-cover rounded-full border border-zinc-800 shadow-lg">
                    </div>

                    <div class="flex-1 space-y-4">
                        <h3
                            class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-700 pl-3 leading-none">
                            {{ __('Order Info') }}
                        </h3>
                        <div class="grid grid-cols-1 gap-y-3">
                            <div class="flex justify-between items-start border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Order ID: ') }}</span>
                                <span
                                    class="text-text-white font-medium text-right break-all ml-4 text-sm uppercase">{{ $data?->order_id }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Product: ') }}</span>
                                <span class="text-text-white font-medium">{{ $data?->source?->name }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Purchased at: ') }}</span>
                                <span class="text-text-white font-medium">{{ $data?->created_at_formatted }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Status: ') }}</span>
                                <span
                                    class="text-text-white font-medium badge badge-soft {{ $data->status->color() }}">{{ $data?->status?->label() }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                <span class="text-text-muted text-sm">{{ __('Currency: ') }}</span>
                                <span class="text-text-white font-medium">{{ $data?->currency }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-muted text-sm">{{ __('Total Amount: ') }}</span>
                                <span class="text-zinc-500 font-bold text-lg">{{ $data?->grand_total }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <h3 class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-800 pl-3 leading-none">
                        {{ __('Transaction History') }}
                    </h3>
                    <div class="overflow-hidden border border-zinc-800 rounded-xl bg-main">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-card text-text-white uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">{{ __('Transactions ID') }}</th>
                                    <th class="px-4 py-3 font-semibold">{{ __('Amount') }}</th>
                                    <th class="px-4 py-3 font-semibold">{{ __('Method') }}</th>
                                    <th class="px-4 py-3 font-semibold text-right">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @if (isset($data?->transactions))
                                    @foreach ($data?->transactions as $transaction)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted">
                                                {{ $transaction?->transaction_id }}</td>
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                                {{ $transaction?->amount }}
                                            </td>
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                                {{ $transaction?->payment_gateway }}
                                            </td>
                                            <td
                                                class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted text-right italic text-xs">
                                                {{ $transaction?->created_at_formatted }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                    {{ __('Seller Details') }}
                </h3>
                <div class="flex items-center gap-5">
                    <a href="{{ route('profile', $data?->source?->user?->username) }}">
                        <img src="{{ auth_storage_url($data?->user?->avatar) }}"
                            alt="{{ $data?->source?->user?->full_name }}"
                            class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                    </a>
                    <div class="space-y-1">
                        <div class="flex gap-2 items-center pb-2">
                            <a href="{{ route('profile', $data?->source?->user?->username) }}"
                                class="text-text-white font-bold">{{ $data?->source?->user?->full_name }}</a>
                        </div>
                        <div class="flex gap-2 items-center pb-2">
                            <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                            </p>
                            <a href="{{ route('profile', $data?->source?->user?->username) }}"
                                class="text-text-muted text-xs underline">{{ $data?->source?->user?->username }}</a>
                        </div>
                        <div class="flex gap-2 items-center pb-2">
                            <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                            <a href="mailto:{{ $data?->source?->user?->email }}"
                                class="text-text-muted text-xs break-all underline">{{ $data?->source?->user?->email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                    {{ __('Buyer Details') }}
                </h3>
                <div class="flex items-center gap-5">
                    <a href="{{ route('profile', $data?->user?->username) }}">
                        <img src="{{ auth_storage_url($data?->user?->avatar) }}" alt="{{ $data?->user?->full_name }}"
                            class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                    </a>
                    <div class="space-y-1">
                        <div class="flex gap-2 items-center pb-2">
                            <a href="{{ route('profile', $data?->user?->username) }}"
                                class="text-text-white font-bold">{{ $data?->user?->full_name }}</a>
                        </div>
                        <div class="flex gap-2 items-center pb-2">
                            <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                            </p>
                            <a href="{{ route('profile', $data?->user?->username) }}"
                                class="text-text-muted text-xs underline">{{ $data?->user?->username }}</a>
                        </div>
                        <div class="flex gap-2 items-center pb-2">
                            <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                            <a href="mailto:{{ $data?->user?->email }}"
                                class="text-text-muted text-xs underline">{{ $data?->user?->email }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center text-text-muted text-sm">
        {{ __('No order found.') }}
    </div>

</div>
