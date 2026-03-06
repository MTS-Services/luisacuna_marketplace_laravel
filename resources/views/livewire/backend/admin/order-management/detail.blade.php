<div>
    @if ($data)
        <div class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 w-full shadow-2xl">
            @include('livewire.backend.admin.order-management.partials.order-detail-core')
            {{-- @dd($data->is_disputed); --}}
            @if ($data->is_disputed)
                <div
                    class="glass-card rounded-2xl p-6 sm:p-8 bg-white/5 border border-primary-200 dark:border-zinc-800 mt-8">
                    <div
                        class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 border-b border-zinc-800 pb-6 gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-zinc-500/90 flex items-center justify-center shadow-inner">
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
                        <p class="text-sm text-text-primary mt-2">
                            {{ $data->disputes->reason ?? __('No specific reason provided by the buyer.') }}</p>
                        <div class="flex justify-end gap-2">


                            @if ($data->is_disputed && $data->status->value == 'paid')
                                <x-ui.button class="mt-6 px-4! py-2! w-auto!" wire:click="rejectDispute">
                                    {{ __('Reject') }} </x-ui.button>
                                <x-ui.button class="mt-6 px-4! py-2! w-auto!" wire:click="acceptDispute">
                                    {{ __('Accept') }} </x-ui.button>
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
                                <div class="bg-main border border-primary-200 dark:border-zinc-800 rounded-2xl p-5 md:p-7">
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
                                class="bg-main border border-primary-200 dark:border-zinc-800 rounded-2xl p-6 h-full flex flex-col justify-center">
                                <h3 class="text-text-white text-center text-sm font-semibold mb-6">
                                    {{ __('Resolution Center') }}
                                </h3>

                                <div class="space-y-4">
                                    <button
                                        class="w-full group flex flex-col items-center justify-center gap-1 px-6 py-4 rounded-xl border border-primary-200 dark:border-zinc-800 hover:bg-white/5 transition-all">
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
                                        class="w-full group flex flex-col items-center justify-center gap-1 px-6 py-4 rounded-xl border border-primary-200 dark:border-zinc-800 hover:bg-white/5 transition-all">
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

                <div x-data="{ show: @entangle('showDisputeModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                    @keydown.escape.window="show = false">

                    {{-- Red Overlay --}}
                    <div x-show="show" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @click="show = false"
                        class="fixed inset-0 bg-bg-primary backdrop-blur-sm"></div>

                    {{-- Modal Wrapper --}}
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div x-show="show" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95" @click.stop
                            class="relative dark:bg-[#1B0C33] bg-white rounded-lg shadow-xl w-full sm:max-w-md lg:max-w-xl">

                            {{-- Close Button --}}
                            <button @click="show = false"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
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


                                    <textarea wire:model="reason" rows="3"
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
                                    @click="show = false">
                                    {{ __('Cancel') }}
                                </x-ui.button>

                                <x-ui.button wire:click="submitDispute"
                                    class="bg-pink-700! w-fit! py-2! px-4! sm:py-3! sm:px-6! border-none!">
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
