<div class="h-full max-h-screen flex flex-col bg-bg-primary text-text-primary">
    <div class="border-b border-zinc-800/60 px-4 py-3 flex items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-text-secondary">
                {{ __('Dispute for Order #:order', ['order' => $dispute->order->order_id]) }}
            </p>
            <p class="text-xs text-text-muted mt-1">
                {{ __('Buyer') }}: {{ $dispute->buyer?->full_name ?? $dispute->buyer?->username }}
                &middot;
                {{ __('Vendor') }}: {{ $dispute->vendor?->full_name ?? $dispute->vendor?->username }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center rounded-full bg-bg-secondary px-3 py-1 text-xs font-medium text-text-secondary">
                {{ $dispute->status->label() }}
            </span>
        </div>
    </div>

    <div class="flex-1 grid grid-rows-[auto,1fr,auto]">
        <div class="px-4 py-3 border-b border-zinc-800/60 bg-bg-secondary">
            <x-disputes.timeline :status="$dispute->status" />
        </div>

        <div
            class="overflow-y-auto px-4 py-4 space-y-4"
            wire:poll.5s="refreshMessages"
        >
            @foreach($dispute->messages as $message)
                @php
                    $isBuyer = $message->sender_id === $dispute->buyer_id;
                    $isVendor = $message->sender_id === $dispute->vendor_id;
                    $alignment = $isBuyer ? 'items-start' : 'items-end';
                    $bubble = $isBuyer ? 'bg-bg-secondary' : 'bg-primary-500 text-white';
                @endphp

                <div class="flex {{ $alignment }}">
                    <div class="max-w-[80%] space-y-1">
                        <div class="text-[11px] text-text-muted">
                            @if($message->sender_role === 'admin')
                                {{ __('Admin') }}
                            @elseif($isBuyer)
                                {{ __('You (Buyer)') }}
                            @elseif($isVendor)
                                {{ __('You (Vendor)') }}
                            @else
                                {{ $message->sender?->full_name ?? $message->sender?->username }}
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
                <div class="flex h-full items-center justify-center">
                    <p class="text-sm text-text-muted">
                        {{ __('No messages yet. Start the conversation below.') }}
                    </p>
                </div>
            @endif
        </div>

        <div class="border-t border-zinc-800/60 bg-bg-secondary px-4 py-3">
            <form wire:submit.prevent="send" class="space-y-2">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <flux:textarea
                            rows="2"
                            wire:model.defer="message"
                            placeholder="{{ __('Type your message...') }}"
                        />
                        @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            type="file"
                            multiple
                            class="hidden"
                            wire:model="files"
                            x-ref="chatFiles"
                        />

                        <flux:button
                            type="button"
                            size="sm"
                            variant="ghost"
                            icon="paper-clip"
                            x-on:click="$refs.chatFiles.click()"
                        >
                            {{ __('Attach') }}
                        </flux:button>

                        <flux:button
                            type="submit"
                            size="sm"
                            variant="primary"
                            wire:target="send"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="send">
                                {{ __('Send') }}
                            </span>
                            <span wire:loading wire:target="send">
                                {{ __('Sending...') }}
                            </span>
                        </flux:button>
                    </div>
                </div>

                @error('files') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                @error('files.*') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </form>
        </div>
    </div>
</div>

