<div>
    @if ($data)
        <div class="bg-main rounded-3xl p-3 sm:p-6 md:p-10 w-full shadow-2xl">
            @include('livewire.backend.admin.order-management.partials.order-detail-core')

            <div class="glass-card rounded-2xl p-4 sm:p-6 bg-white/5 border border-primary-200 dark:border-zinc-800 mt-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <h3 class="text-text-white text-lg font-semibold">
                            {{ __('Dispute Tools') }}
                        </h3>
                        <p class="text-text-muted text-xs">
                            {{ __('Conversation + dispute status + evidence and admin verdict') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if ($conversationUrl)
                            <x-ui.button href="{{ $conversationUrl }}" class="w-auto! py-2! px-4!" target="_blank">
                                <flux:icon name="chat-bubble-left-right" class="w-4 h-4" />
                                {{ __('See conversation') }}
                            </x-ui.button>
                        @else
                            <x-ui.button class="w-auto! py-2! px-4! opacity-60 cursor-not-allowed" disabled>
                                <flux:icon name="chat-bubble-left-right" class="w-4 h-4" />
                                {{ __('No conversation') }}
                            </x-ui.button>
                        @endif

                        @if ($data->is_disputed)
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-md bg-white/5 border border-primary-200 dark:border-zinc-800 text-text-white">
                                {{ __('Disputed') }}
                            </span>
                        @else
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-md bg-white/5 border border-primary-200 dark:border-zinc-800 text-text-muted">
                                {{ __('Not disputed') }}
                            </span>
                        @endif

                        @if ($dispute?->status)
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-md bg-white/5 border border-primary-200 dark:border-zinc-800 text-text-white">
                                {{ __('Status: :status', ['status' => $dispute->status->label()]) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- @if ($dispute)
                <div class="mt-8">
                    <livewire:backend.admin.disputes.admin-verdict-panel :disputeId="$dispute->id" />
                </div>
            @else
                <div class="glass-card rounded-2xl p-6 bg-white/5 border border-primary-200 dark:border-zinc-800 mt-8">
                    <h3 class="text-text-white text-lg font-semibold">
                        {{ __('Dispute (New System)') }}
                    </h3>
                    <p class="text-text-muted text-sm mt-2">
                        {{ __('No dispute record found in the new disputes system for this order.') }}
                    </p>
                </div>
            @endif --}}

            @if ($data->disputes)
                <div class="glass-card rounded-2xl p-6 bg-white/5 border border-primary-200 dark:border-zinc-800 mt-8">
                    <h3 class="text-text-white text-lg font-semibold mb-2">
                        {{ __('Legacy Dispute Info') }}
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-text-muted text-xs">{{ __('Reason') }}</p>
                            <p class="text-text-white mt-1">{{ $data->disputes->reason ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-text-muted text-xs">{{ __('Resolution') }}</p>
                            <p class="text-text-white mt-1">{{ $data->disputes->resolution ?? '-' }}</p>
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

