<div>
    @if ($data)
        <div class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 w-full shadow-2xl">

            <div class="flex items-center justify-between mb-8 border-b border-zinc-800 pb-5">
                <div>
                    <h2 class="text-text-white text-2xl md:text-3xl font-bold tracking-tight">
                        {{ __('Order Detail') }}
                    </h2>
                    <p class="text-text-muted text-sm mt-1">
                        {{ __('Review all information regarding this transaction') }}
                    </p>
                </div>
                <x-ui.button href="{{ $backUrl }}" class="w-auto! py-2! text-nowrap">
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
                                        class="text-text-white font-medium text-right break-all ml-4 text-sm uppercase">{{ $data->order_id }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Product: ') }}</span>
                                    <span class="text-text-white font-medium">{{ $data?->source?->name }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Purchased at: ') }}</span>
                                    <span class="text-text-white font-medium">{{ $data->created_at_formatted }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Status: ') }}</span>
                                    <span
                                        class="text-text-white font-medium badge badge-soft {{ $data->status->color() }}">{{ $data->status->label() }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-zinc-800 pb-2">
                                    <span class="text-text-muted text-sm">{{ __('Currency: ') }}</span>
                                    <span class="text-text-white font-medium">{{ $data->currency }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-text-muted text-sm">{{ __('Total Amount: ') }}</span>
                                    <span class="text-zinc-500 font-bold text-lg">{{ $data->grand_total }}</span>
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
                                    @forelse ($data->transactions as $transaction)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted">
                                                {{ $transaction->transaction_id }}</td>
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                                {{ $transaction->amount }}</td>
                                            <td class="px-1 sm:px-4 py-1 sm:py-3 text-text-white font-medium">
                                                {{ $transaction->payment_gateway }}</td>
                                            <td
                                                class="px-1 sm:px-4 py-1 sm:py-3 text-text-muted text-right italic text-xs">
                                                {{ $transaction->created_at_formatted }}</td>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                    <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                        {{ __('Seller Details') }}
                    </h3>
                    @if ($data?->source?->user)
                        <div class="flex items-center gap-5">
                            <a href="{{ route('profile', $data->source->user->username) }}">
                                <img src="{{ auth_storage_url($data->source->user->avatar) }}"
                                    alt="{{ $data->source->user->full_name }}"
                                    class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                            </a>
                            <div class="space-y-1">
                                <div class="flex gap-2 items-center pb-2">
                                    <a href="{{ route('profile', $data->source->user->username) }}"
                                        class="text-text-white font-bold">{{ $data->source->user->full_name }}</a>
                                </div>
                                <div class="flex gap-2 items-center pb-2">
                                    <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                                    </p>
                                    <a href="{{ route('profile', $data->source->user->username) }}"
                                        class="text-text-muted text-xs underline">{{ $data->source->user->username }}</a>
                                </div>
                                <div class="flex gap-2 items-center pb-2">
                                    <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                                    <a href="mailto:{{ $data->source->user->email }}"
                                        class="text-text-muted text-xs break-all underline">{{ $data->source->user->email }}</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-text-muted text-sm italic">{{ __('Seller information not available.') }}</p>
                    @endif
                </div>

                <div class="glass-card p-6 bg-main border border-zinc-800 rounded-2xl">
                    <h3 class="text-text-white text-lg font-semibold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-zinc-500 rounded-full"></span>
                        {{ __('Buyer Details') }}
                    </h3>
                    @if ($data?->user)
                        <div class="flex items-center gap-5">
                            <a href="{{ route('profile', $data->user->username) }}">
                                <img src="{{ auth_storage_url($data->user->avatar) }}"
                                    alt="{{ $data->user->full_name }}"
                                    class="w-16 h-16 rounded-full ring-2 ring-white/10 object-cover">
                            </a>
                            <div class="space-y-1">
                                <div class="flex gap-2 items-center pb-2">
                                    <a href="{{ route('profile', $data->user->username) }}"
                                        class="text-text-white font-bold">{{ $data->user->full_name }}</a>
                                </div>
                                <div class="flex gap-2 items-center pb-2">
                                    <p class="text-text-muted text-xs break-all font-semibold">{{ __('User Name: ') }}
                                    </p>
                                    <a href="{{ route('profile', $data->user->username) }}"
                                        class="text-text-muted text-xs underline">{{ $data->user->username }}</a>
                                </div>
                                <div class="flex gap-2 items-center pb-2">
                                    <p class="text-text-muted text-xs break-all font-semibold">{{ __('Email: ') }}</p>
                                    <a href="mailto:{{ $data->user->email }}"
                                        class="text-text-muted text-xs underline">{{ $data->user->email }}</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-text-muted text-sm italic">{{ __('Buyer information not available.') }}</p>
                    @endif
                </div>
            </div>
            {{-- @dd($data->is_disputed); --}}
            @if ($data->is_disputed)
                <div class="glass-card rounded-2xl p-6 sm:p-8 bg-white/5 border border-zinc-800 mt-8">
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 border-b border-zinc-800 pb-6 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-zinc-500/90 flex items-center justify-center shadow-inner">
                                <flux:icon name="exclamation-circle" class="w-6 h-6 text-text-white" />
                            </div>
                            <div>
                                <h2 class="text-text-white text-xl md:text-2xl font-bold tracking-tight">
                                    {{ __('Order Dispute') }}
                                </h2>
                                <p class="text-text-muted text-xs mt-1 uppercase tracking-widest font-medium">
                                    {{ __('Status: Under Review') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2>{{ __('Dispute Reason') }}</h2>
                        <p class="text-sm text-text-primary mt-2">{{ $data->disputes->reason ?? __('No specific reason provided by the buyer.') }}</p>
                        <div class="flex justify-end gap-2">

                           
                            @if($data->is_disputed && $data->status->value == 'paid')
                            <x-ui.button class="mt-6 px-4! py-2! w-auto!" wire:click="rejectDispute" > {{ __('Reject') }} </x-ui.button>
                            <x-ui.button  class="mt-6 px-4! py-2! w-auto!" wire:click="acceptDispute"> {{ __('Accept') }} </x-ui.button>
                            @else 
                                <p>Resolved</p>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <h3
                                    class="text-text-white text-sm font-semibold mb-3 flex items-center gap-2 uppercase tracking-wider">
                                    <span class="w-1.5 h-4 bg-zinc-700 rounded-full"></span>
                                    {{ __('Buyer Claim') }}
                                </h3>
                                <div class="bg-main border border-zinc-800 rounded-2xl p-5 md:p-7">
                                    <p class="text-text-muted text-sm leading-relaxed italic">
                                        "{{ $data->dispute_reason ?? __('No specific reason provided by the buyer.') }}"
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 px-2">
                                <flux:icon name="information-circle" class="w-5 h-5 text-text-muted flex-shrink-0" />
                                <p class="text-text-muted text-xs leading-normal">
                                    {{ __('Please review the claim above. You can either accept the dispute to issue a full refund or reject it to involve our support team for mediation.') }}
                                </p>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div
                                class="bg-main border border-zinc-800 rounded-2xl p-6 h-full flex flex-col justify-center">
                                <h3 class="text-text-white text-center text-sm font-semibold mb-6">
                                    {{ __('Resolution Center') }}
                                </h3>

                                <div class="space-y-4">
                                    <button
                                        class="w-full group flex flex-col items-center justify-center gap-1 px-6 py-4 rounded-xl border border-zinc-800 hover:bg-white/5 transition-all">
                                        <span
                                            class="text-text-white font-bold text-sm">{{ __('Accept Dispute') }}</span>
                                        <span
                                            class="text-text-muted text-[10px] group-hover:text-text-white/60 transition-colors uppercase tracking-tighter">{{ __('Authorize Refund') }}</span>
                                    </button>

                                    <div class="relative flex items-center py-2">
                                        <div class="flex-grow border-t border-zinc-800"></div>
                                        <span
                                            class="flex-shrink mx-4 text-zinc-600 text-[10px] uppercase font-bold">{{ __('Or') }}</span>
                                        <div class="flex-grow border-t border-zinc-800"></div>
                                    </div>

                                    <button
                                        class="w-full group flex flex-col items-center justify-center gap-1 px-6 py-4 rounded-xl border border-zinc-800 hover:bg-white/5 transition-all">
                                        <span
                                            class="text-text-white font-bold text-sm">{{ __('Reject Dispute') }}</span>
                                        <span
                                            class="text-text-muted text-[10px] group-hover:text-text-white/60 transition-colors uppercase tracking-tighter">{{ __('Submit for Review') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

      <div 
    x-data="{ show: @entangle('showDisputeModal') }"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    @keydown.escape.window="show = false"
>

    {{-- Red Overlay --}}
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false"
        class="fixed inset-0 bg-bg-primary backdrop-blur-sm"
    ></div>

    {{-- Modal Wrapper --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div 
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            @click.stop
            class="relative dark:bg-[#1B0C33] bg-white rounded-lg shadow-xl w-full sm:max-w-md lg:max-w-xl"
        >

            {{-- Close Button --}}
            <button 
                @click="show = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Header --}}
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-text-primary">
                    {{ __('Give a Reason') }}
                </h2>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-4">

                <div>
                    

                    <textarea 
                        wire:model="reason"
                        rows="3"
                        class="w-full bg-transparent border border-zinc-500 text-text-primary rounded-lg px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none"
                        placeholder="{{ __('Explain why you are giving this action....') }}">
                    </textarea>

                    @error('reason')
                        <span class="text-pink-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Footer --}}
            <div class="p-6 flex justify-end gap-3 border-t">

                <x-ui.button
                    class="bg-gray-300! text-gray-800! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!"
                    @click="show = false"
                >
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button
                    wire:click="submitDispute"
                    class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!"
                >
                    {{ __('Submit') }}
                </x-ui.button>

            </div>

        </div>
    </div>
</div>


            @endif

        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <flux:icon name="exclamation-circle" class="w-12 h-12 text-text-muted mb-4" />
            <h2 class="text-text-white text-xl font-bold">{{ __('Order Not Found') }}</h2>
            <p class="text-text-muted text-sm">{{ __('The requested order could not be located in our system.') }}</p>
            <x-ui.button href="{{ $backUrl }}" class="mt-6">
                {{ __('Back to Orders') }}
            </x-ui.button>
        </div>
    @endif
</div>
