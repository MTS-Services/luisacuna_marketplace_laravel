<div class="h-full max-h-screen flex flex-col gap-4">
    @if (session()->has('success'))
        <div class="rounded-lg bg-bg-info text-text-primary px-4 py-2 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)] gap-4">
        <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 flex flex-col">
            <h2 class="text-sm font-semibold text-text-secondary mb-3">
                {{ __('Conversation') }}
            </h2>
            <div class="mb-3">
                <x-disputes.timeline :status="$dispute->status" />
            </div>

            <div class="flex-1 min-h-[260px] overflow-y-auto space-y-4 border border-zinc-800/60 rounded-lg px-3 py-3">
                @foreach($dispute->messages as $message)
                    @php
                        $isAdmin = $message->sender_role === 'admin';
                        $isBuyer = $message->sender_id === $dispute->buyer_id;
                        $alignment = $isAdmin || $isBuyer ? 'items-start' : 'items-end';
                        $bubble = $isAdmin
                            ? 'bg-bg-info text-text-primary'
                            : ($isBuyer ? 'bg-bg-secondary text-text-primary' : 'bg-primary-500 text-white');
                    @endphp

                    <div class="flex {{ $alignment }}">
                        <div class="max-w-[80%] space-y-1">
                            <div class="text-[11px] text-text-muted">
                                @if($isAdmin)
                                    {{ __('Admin') }}
                                @elseif($isBuyer)
                                    {{ __('Buyer') }}
                                @else
                                    {{ __('Vendor') }}
                                @endif
                                <span class="ml-1 text-[10px] text-text-muted/80">
                                    {{ $message->created_at?->diffForHumans() }}
                                </span>
                            </div>

                            <div class="rounded-2xl px-3 py-2 text-sm {{ $bubble }}">
                                <p class="whitespace-pre-line wrap-break-word">
                                    {{ $message->message }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($dispute->messages->isEmpty())
                    <div class="flex items-center justify-center h-full">
                        <p class="text-sm text-text-muted">
                            {{ __('No messages yet for this dispute.') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-text-secondary">
                    {{ __('Dispute Summary') }}
                </h2>

                <dl class="space-y-1 text-xs text-text-muted">
                    <div class="flex justify-between gap-2">
                        <dt class="font-medium text-text-secondary">{{ __('Order') }}</dt>
                        <dd>#{{ $dispute->order->order_id }}</dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="font-medium text-text-secondary">{{ __('Buyer') }}</dt>
                        <dd>{{ $dispute->buyer?->full_name ?? $dispute->buyer?->username }}</dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="font-medium text-text-secondary">{{ __('Vendor') }}</dt>
                        <dd>{{ $dispute->vendor?->full_name ?? $dispute->vendor?->username }}</dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="font-medium text-text-secondary">{{ __('Status') }}</dt>
                        <dd class="inline-flex items-center rounded-full bg-bg-primary px-2 py-0.5">
                            <span class="text-[11px]">{{ $dispute->status->label() }}</span>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="font-medium text-text-secondary">{{ __('Opened At') }}</dt>
                        <dd>{{ $dispute->created_at?->format('Y-m-d H:i') }}</dd>
                    </div>
                    @if($dispute->resolved_at)
                        <div class="flex justify-between gap-2">
                            <dt class="font-medium text-text-secondary">{{ __('Resolved At') }}</dt>
                            <dd>{{ $dispute->resolved_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-text-secondary">
                    {{ __('Evidence') }}
                </h2>

                @if($dispute->attachments->isEmpty())
                    <p class="text-xs text-text-muted">
                        {{ __('No evidence has been uploaded for this dispute.') }}
                    </p>
                @else
                    <ul class="space-y-1 text-xs text-text-secondary">
                        @foreach($dispute->attachments as $attachment)
                            <li class="flex items-center justify-between rounded-md bg-bg-primary px-3 py-1.5">
                                <span class="truncate">
                                    {{ $attachment->original_name ?? basename($attachment->path) }}
                                </span>
                                <span class="ml-2 text-[11px] text-text-muted">
                                    {{ strtoupper(pathinfo($attachment->path, PATHINFO_EXTENSION)) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-text-secondary">
                    {{ __('Admin Verdict') }}
                </h2>

                <flux:field>
                    <flux:label for="note">{{ __('Admin note (optional)') }}</flux:label>
                    <flux:textarea
                        id="note"
                        rows="3"
                        wire:model.defer="note"
                        placeholder="{{ __('Explain the reason for your decision...') }}"
                    />
                    @error('note') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </flux:field>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <flux:button
                        type="button"
                        variant="secondary"
                        wire:click="releasePayment"
                        wire:target="releasePayment"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="releasePayment">
                            {{ __('Release Payment') }}
                        </span>
                        <span wire:loading wire:target="releasePayment">
                            {{ __('Processing...') }}
                        </span>
                    </flux:button>

                    <flux:button
                        type="button"
                        variant="primary"
                        wire:click="issueRefund"
                        wire:target="issueRefund"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="issueRefund">
                            {{ __('Issue Refund') }}
                        </span>
                        <span wire:loading wire:target="issueRefund">
                            {{ __('Processing...') }}
                        </span>
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>

