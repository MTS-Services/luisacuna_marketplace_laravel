<div x-data="{ orderDetailModalShow: @entangle('orderDetailModalShow').live }"
    @order-detail-modal-open.window="orderDetailModalShow = true; console.log('open order detail');"
    x-show="orderDetailModalShow" class="fixed inset-0 bg-black/5 backdrop-blur-md z-20 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

    @if ($order)

        <div class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 max-w-7xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-zinc-800"
            @click.away="orderDetailModalShow = false">

            <div class="flex items-center justify-between mb-8 border-b border-zinc-800 pb-5">
                <div>
                    <h2 class="text-text-white text-2xl md:text-3xl font-bold tracking-tight">{{ __('Order Detail') }}
                    </h2>
                    <p class="text-text-muted text-sm mt-1">
                        {{ __('Review all information regarding this transaction') }}
                    </p>
                </div>
                <button wire:click="closeModal" @click="orderDetailModalShow = false"
                    class="text-text-muted hover:text-text-primary">
                    <x-phosphor name="x" variant="regular" class="w-6 h-6 text-text-white" />
                </button>
            </div>

            <div class="glass-card rounded-2xl p-2 sm:p-6 md:p-8 bg-white/5 border border-zinc-800">
                <div class="flex flex-col lg:flex-row gap-8">

                    <div class="flex-1 flex flex-col md:flex-row gap-4 sm:gap-6">
                        <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 flex-shrink-0 mx-auto md:mx-0">
                            <img src="{{ storage_url($order?->source?->game?->logo) }}"
                                alt="{{ $order?->source?->name }}"
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
                                        class="text-text-white font-medium text-right break-all ml-4 text-sm uppercase">{{ $order?->order_id }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Product: ') }}</span>
                                    <span class="text-text-white font-medium">{{ $order?->source?->name }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Purchased at: ') }}</span>
                                    <span
                                        class="text-text-white font-medium">{{ $order?->created_at_formatted }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Status: ') }}</span>
                                    <span
                                        class="text-text-white font-medium">{{ $order?->status?->label() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-text-muted text-sm">{{ __('Total Amount: ') }}</span>
                                    <span class="text-zinc-500 font-bold text-lg">{{ $order?->grand_total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <h3
                            class="text-text-white text-xl font-semibold mb-4 border-l-4 border-zinc-800 pl-3 leading-none">
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
                                    @if (isset($order?->transactions))
                                        @foreach ($order?->transactions as $transaction)
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
                        <a href="{{ route('profile', $order?->source?->user?->username) }}">
                            <img src="{{ storage_url($order?->user?->avatar) }}"
                                alt="{{ $order?->source?->user?->full_name }}"
                                class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                        </a>
                        <div class="space-y-1">
                            <div class="flex gap-2 items-center pb-2">
                                <a href="{{ route('profile', $order?->source?->user?->username) }}"
                                    class="text-text-white font-bold">{{ $order?->source?->user?->full_name }}</a>
                            </div>
                            <div class="flex gap-2 items-center pb-2">
                                <p class="text-text-white font-bold">{{ __('User Name: ') }}</p>
                                <a href="{{ route('profile', $order?->source?->user?->username) }}"
                                    class="text-text-muted text-xs">{{ $order?->source?->user?->username }}</a>
                            </div>
                            <div class="flex gap-2 items-center pb-2">
                                <p class="text-text-white font-bold">{{ __('Email: ') }}</p>
                                <a href="mailto:{{ $order?->source?->user?->email }}"
                                    class="text-text-muted text-xs break-all">{{ $order?->source?->user?->email }}</a>
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
                        <a href="{{ route('profile', $order?->user?->username) }}">
                            <img src="{{ storage_url($order?->user?->avatar) }}" alt="{{ $order?->user?->full_name }}"
                                class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                        </a>
                        <div class="space-y-1">
                            <div class="flex gap-2 items-center pb-2">
                                <a href="{{ route('profile', $order?->user?->username) }}"
                                    class="text-text-white font-bold">{{ $order?->user?->full_name }}</a>
                            </div>
                            <div class="flex gap-2 items-center pb-2">
                                <p class="text-text-white font-bold">{{ __('User Name: ') }}</p>
                                <a href="{{ route('profile', $order?->user?->username) }}"
                                    class="text-text-muted text-xs">{{ $order?->user?->username }}</a>
                            </div>
                            <div class="flex gap-2 items-center pb-2">
                                <p class="text-text-white font-bold">{{ __('Email: ') }}</p>
                                <a href="mailto:{{ $order?->user?->email }}"
                                    class="text-text-muted text-xs">{{ $order?->user?->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
