<div class="space-y-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ $backUrl }}" class="text-text-muted hover:text-text-white transition">
                <flux:icon name="arrow-left" class="w-5 h-5" />
            </a>
            <h1 class="text-text-white text-xl font-bold">
                {{ __('Deep View') }} — #{{ $order->order_id }}
            </h1>
            <span
                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $order->status->color() }}">
                {{ $order->status->label() }}
            </span>
        </div>
        <div class="text-xs text-text-muted">
            {{ __('Created') }}: {{ $order->created_at?->format('M d, Y H:i') }}
        </div>
    </div>

    {{-- 3-Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ═══════════════ COLUMN 1: PROFILES ═══════════════ --}}
        <div class="space-y-4">

            {{-- Buyer Profile --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-blue-400 uppercase tracking-wider flex items-center gap-2">
                    <flux:icon name="user" class="w-4 h-4" />
                    {{ __('Buyer') }}
                </h2>

                @if ($buyer)
                    <div class="flex items-center gap-3">
                        <img src="{{ auth_storage_url($buyer->avatar) }}" alt="{{ $buyer->full_name }}"
                            class="w-10 h-10 rounded-full object-cover" />
                        <div>
                            <p class="text-text-white text-sm font-semibold">{{ $buyer->full_name }}</p>
                            <p class="text-text-muted text-xs">{{ '@' . $buyer->username }}</p>
                        </div>
                    </div>

                    <dl class="space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Email') }}</dt>
                            <dd class="text-text-secondary truncate ml-2">{{ $buyer->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Joined') }}</dt>
                            <dd class="text-text-secondary">{{ $buyer->created_at?->format('M d, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="border-t border-zinc-800/60 pt-3">
                        <h3 class="text-xs font-semibold text-text-secondary mb-2">{{ __('Purchase History') }}</h3>
                        <dl class="grid grid-cols-2 gap-1.5 text-xs">
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Total') }}</dt>
                                <dd class="text-text-white font-medium">{{ $buyerTotalOrders }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Completed') }}</dt>
                                <dd class="text-green-400 font-medium">{{ $buyerCompletedOrders }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Cancelled') }}</dt>
                                <dd class="text-red-400 font-medium">{{ $buyerCancelledOrders }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Disputes Won') }}</dt>
                                <dd class="text-green-400 font-medium">{{ $buyerWins }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Disputes Lost') }}</dt>
                                <dd class="text-red-400 font-medium">{{ $buyerLosses }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-bg-primary rounded-lg p-2 text-center">
                            <p class="text-[10px] text-text-muted uppercase tracking-wider">{{ __('Trust Score') }}</p>
                            <p class="text-lg font-bold {{ $buyerTrustScore >= 70 ? 'text-green-400' : ($buyerTrustScore >= 40 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $buyerTrustScore }}%
                            </p>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-2 text-center">
                            <p class="text-[10px] text-text-muted uppercase tracking-wider">{{ __('Dispute Rate') }}</p>
                            <p class="text-lg font-bold {{ $buyerDisputeRate <= 30 ? 'text-green-400' : ($buyerDisputeRate <= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $buyerDisputeRate }}%
                            </p>
                        </div>
                    </div>

                    @if ($buyerActiveDisputes > 0)
                        <p class="text-[10px] text-red-400 text-center">{{ $buyerActiveDisputes }} {{ __('active dispute(s)') }}</p>
                    @endif
                    @if ($buyerDisputeRate > 50)
                        <div class="bg-red-900/20 border border-red-700/30 rounded-lg p-2">
                            <p class="text-[10px] text-red-400 font-semibold text-center">{{ __('HIGH DISPUTE RATE — Potential abuse') }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-text-muted text-xs">{{ __('Buyer not found.') }}</p>
                @endif
            </div>

            {{-- Seller Profile --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-orange-400 uppercase tracking-wider flex items-center gap-2">
                    <flux:icon name="building-storefront" class="w-4 h-4" />
                    {{ __('Seller') }}
                </h2>

                @if ($seller)
                    <div class="flex items-center gap-3">
                        <img src="{{ auth_storage_url($seller->avatar) }}" alt="{{ $seller->full_name }}"
                            class="w-10 h-10 rounded-full object-cover" />
                        <div>
                            <p class="text-text-white text-sm font-semibold">{{ $seller->full_name }}</p>
                            <p class="text-text-muted text-xs">{{ '@' . $seller->username }}</p>
                        </div>
                    </div>

                    <dl class="space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Email') }}</dt>
                            <dd class="text-text-secondary truncate ml-2">{{ $seller->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Joined') }}</dt>
                            <dd class="text-text-secondary">{{ $seller->created_at?->format('M d, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="border-t border-zinc-800/60 pt-3">
                        <h3 class="text-xs font-semibold text-text-secondary mb-2">{{ __('Sales History') }}</h3>
                        <dl class="grid grid-cols-2 gap-1.5 text-xs">
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Total') }}</dt>
                                <dd class="text-text-white font-medium">{{ $sellerTotalSales }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Completed') }}</dt>
                                <dd class="text-green-400 font-medium">{{ $sellerCompletedSales }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Cancelled') }}</dt>
                                <dd class="text-red-400 font-medium">{{ $sellerCancelledSales }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Disputes Won') }}</dt>
                                <dd class="text-green-400 font-medium">{{ $sellerWins }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Disputes Lost') }}</dt>
                                <dd class="text-red-400 font-medium">{{ $sellerLosses }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-bg-primary rounded-lg p-2 text-center">
                            <p class="text-[10px] text-text-muted uppercase tracking-wider">{{ __('Reputation') }}</p>
                            <p class="text-lg font-bold {{ $sellerReputation >= 70 ? 'text-green-400' : ($sellerReputation >= 40 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $sellerReputation }}%
                            </p>
                        </div>
                        <div class="bg-bg-primary rounded-lg p-2 text-center">
                            <p class="text-[10px] text-text-muted uppercase tracking-wider">{{ __('Dispute Rate') }}</p>
                            <p class="text-lg font-bold {{ $sellerDisputeRate <= 30 ? 'text-green-400' : ($sellerDisputeRate <= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                {{ $sellerDisputeRate }}%
                            </p>
                        </div>
                    </div>

                    @if ($sellerActiveDisputes > 0)
                        <p class="text-[10px] text-red-400 text-center">{{ $sellerActiveDisputes }} {{ __('active dispute(s)') }}</p>
                    @endif
                    @if ($sellerDisputeRate > 50)
                        <div class="bg-red-900/20 border border-red-700/30 rounded-lg p-2">
                            <p class="text-[10px] text-red-400 font-semibold text-center">{{ __('HIGH DISPUTE RATE — Potential abuse') }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-text-muted text-xs">{{ __('Seller not found.') }}</p>
                @endif
            </div>
        </div>

        {{-- ═══════════════ COLUMN 2: CONTEXT & CHAT ═══════════════ --}}
        <div class="space-y-4">

            {{-- Item Details --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-2">
                <h2 class="text-sm font-semibold text-text-secondary uppercase tracking-wider">{{ __('Item Details') }}
                </h2>
                <div class="flex items-center gap-3">
                    @if ($order->source?->game?->logo)
                        <img src="{{ storage_url($order->source->game->logo) }}"
                            alt="{{ $order->source?->game?->translatedName(app()->getLocale()) }}"
                            class="w-10 h-10 rounded object-cover" />
                    @endif
                    <div>
                        <p class="text-text-white text-sm font-semibold">
                            {{ $order->source?->translatedName(app()->getLocale()) }}</p>
                        <p class="text-text-muted text-xs">
                            {{ $order->source?->game?->translatedName(app()->getLocale()) }}</p>
                    </div>
                </div>
                <dl class="space-y-1 text-xs">
                    <div class="flex justify-between">
                        <dt class="text-text-muted">{{ __('Amount') }}</dt>
                        <dd class="text-text-white font-medium">
                            ${{ number_format($order->default_grand_total ?? $order->grand_total, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-text-muted">{{ __('Qty') }}</dt>
                        <dd class="text-text-white">{{ $order->quantity }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-text-muted">{{ __('Paid at') }}</dt>
                        <dd class="text-text-secondary">{{ $order->paid_at?->format('M d, Y H:i') ?? '—' }}</dd>
                    </div>
                    @if ($order->delivered_at)
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Delivered at') }}</dt>
                            <dd class="text-text-secondary">{{ $order->delivered_at->format('M d, Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($order->auto_completes_at && $order->status->value === 'delivered')
                        <div class="flex justify-between">
                            <dt class="text-yellow-400">{{ __('Auto-completes') }}</dt>
                            <dd class="text-yellow-400 font-medium">{{ $order->auto_completes_at->diffForHumans() }}
                            </dd>
                        </div>
                    @endif
                    @if ($order->escalated_at)
                        <div class="flex justify-between">
                            <dt class="text-red-400">{{ __('Escalated at') }}</dt>
                            <dd class="text-red-400">{{ $order->escalated_at->format('M d, Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Dispute Info --}}
            @if ($dispute)
                <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-2">
                    <h2 class="text-sm font-semibold text-red-400 uppercase tracking-wider">{{ __('Dispute') }}</h2>
                    <dl class="space-y-1 text-xs">
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Status') }}</dt>
                            <dd>
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $dispute->status->color() }}">
                                    {{ $dispute->status->label() }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Category') }}</dt>
                            <dd class="text-text-secondary">{{ $dispute->reason_category ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Opened') }}</dt>
                            <dd class="text-text-secondary">{{ $dispute->created_at?->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                    @if ($dispute->description)
                        <div class="mt-2 p-2 bg-bg-primary rounded-lg">
                            <p class="text-xs text-text-secondary whitespace-pre-line">{{ $dispute->description }}</p>
                        </div>
                    @endif
                    @if ($dispute->attachments->isNotEmpty())
                        <div class="mt-2">
                            <p class="text-[10px] text-text-muted uppercase mb-1">{{ __('Evidence') }}</p>
                            <ul class="space-y-1">
                                @foreach ($dispute->attachments as $attachment)
                                    <li
                                        class="flex items-center justify-between rounded-md bg-bg-primary px-2 py-1 text-xs">
                                        <span
                                            class="text-text-secondary truncate">{{ $attachment->original_name ?? basename($attachment->path) }}</span>
                                        <span
                                            class="text-text-muted text-[10px] ml-2">{{ strtoupper(pathinfo($attachment->path, PATHINFO_EXTENSION)) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Status Timeline --}}
            @if ($statusTimeline->isNotEmpty())
                <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-2">
                    <h2 class="text-sm font-semibold text-text-secondary uppercase tracking-wider flex items-center gap-2">
                        <flux:icon name="clock" class="w-4 h-4" />
                        {{ __('Status Timeline') }}
                    </h2>
                    <div class="max-h-[200px] overflow-y-auto space-y-2">
                        @foreach ($statusTimeline as $entry)
                            <div class="flex items-start gap-2 text-xs">
                                <div class="w-1.5 h-1.5 rounded-full bg-primary-500 mt-1.5 shrink-0"></div>
                                <div class="flex-1">
                                    <p class="text-text-white">
                                        <span class="font-medium">{{ $entry->from_status?->label() ?? '—' }}</span>
                                        <span class="text-text-muted mx-1">&rarr;</span>
                                        <span class="font-medium">{{ $entry->to_status->label() }}</span>
                                    </p>
                                    <p class="text-text-muted text-[10px]">
                                        {{ ucfirst($entry->actor_type) }}
                                        &middot;
                                        {{ $entry->created_at?->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Delivery Records --}}
            @if ($deliveryRecords->isNotEmpty())
                <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-2">
                    <h2 class="text-sm font-semibold text-text-secondary uppercase tracking-wider flex items-center gap-2">
                        <flux:icon name="document-text" class="w-4 h-4" />
                        {{ __('Delivery Proofs') }} ({{ $deliveryRecords->count() }})
                    </h2>
                    <div class="max-h-[200px] overflow-y-auto space-y-2">
                        @foreach ($deliveryRecords as $delivery)
                            <div class="bg-bg-primary rounded-lg p-2 space-y-1">
                                <p class="text-xs text-text-white whitespace-pre-line">{{ $delivery->delivery_message }}</p>
                                @if ($delivery->files)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($delivery->files as $file)
                                            <span class="text-[10px] bg-zinc-800 rounded px-1.5 py-0.5 text-text-muted">{{ basename($file) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="text-[10px] text-text-muted">{{ $delivery->created_at?->format('M d, Y H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Immutable Chat --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 flex flex-col"
                style="max-height: 500px;">
                <h2
                    class="text-sm font-semibold text-text-secondary uppercase tracking-wider mb-3 flex items-center gap-2">
                    <flux:icon name="chat-bubble-left-right" class="w-4 h-4" />
                    {{ __('Order Chat') }}
                    @if ($order->status->isChatLocked())
                        <flux:icon name="lock-closed" class="w-3 h-3 text-red-400" />
                    @endif
                </h2>

                <div
                    class="flex-1 min-h-[200px] max-h-[350px] overflow-y-auto space-y-3 border border-zinc-800/40 rounded-lg px-3 py-2">
                    @forelse ($chatMessages as $msg)
                        @php
                            $isAdmin = str_contains($msg->sender_type ?? '', 'Admin');
                            $isBuyerMsg = (int) ($msg->sender_id ?? 0) === (int) ($buyer?->id ?? -1) && !$isAdmin;
                            $alignment = $isAdmin ? 'items-center' : ($isBuyerMsg ? 'items-start' : 'items-end');
                            $bubble = $isAdmin
                                ? 'bg-amber-900/30 text-amber-200 border border-amber-700/40'
                                : ($isBuyerMsg
                                    ? 'bg-bg-primary text-text-white'
                                    : 'bg-primary-500/20 text-primary-200');
                        @endphp
                        <div class="flex {{ $alignment }}">
                            <div class="max-w-[85%] space-y-0.5">
                                <div class="text-[10px] text-text-muted">
                                    @if ($isAdmin)
                                        <span class="text-amber-400 font-semibold">{{ __('Admin') }}</span>
                                    @elseif ($isBuyerMsg)
                                        <span class="text-blue-400">{{ __('Buyer') }}</span>
                                    @else
                                        <span class="text-orange-400">{{ __('Seller') }}</span>
                                    @endif
                                    <span class="ml-1">{{ $msg->created_at?->diffForHumans() }}</span>
                                </div>
                                <div class="rounded-xl px-3 py-1.5 text-xs {{ $bubble }}">
                                    <p class="whitespace-pre-line wrap-break-word">
                                        {{ $msg->message_body ?? $msg->message }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xs text-text-muted">{{ __('No messages yet.') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Admin Message Input --}}
                <div class="mt-3">
                    <form wire:submit="sendAdminMessage" class="flex gap-2">
                        <flux:input wire:model="adminMessage" placeholder="{{ __('Send message as admin...') }}"
                            class="flex-1" />
                        <x-ui.button type="submit" variant="primary" size="sm" wire:loading.attr="disabled">
                            <flux:icon name="paper-airplane" class="w-4 h-4" />
                        </x-ui.button>
                    </form>
                    @error('adminMessage')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ═══════════════ COLUMN 3: CONTROLS ═══════════════ --}}
        <div class="space-y-4">

            {{-- Staff Notes (Yellow Warning) --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-yellow-400 uppercase tracking-wider flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="w-4 h-4" />
                    {{ __('Staff Notes') }}
                </h2>

                <div class="max-h-[200px] overflow-y-auto space-y-2">
                    @forelse ($staffNotes as $note)
                        <div class="bg-yellow-900/20 border border-yellow-700/30 rounded-lg p-2">
                            <p class="text-xs text-yellow-200 whitespace-pre-line">{{ $note->note }}</p>
                            <p class="text-[10px] text-yellow-500/60 mt-1">
                                {{ $note->admin?->first_name ?? ($note->admin?->name ?? __('Admin')) }} —
                                {{ $note->created_at?->diffForHumans() }}
                            </p>
                        </div>
                    @empty
                        <p class="text-xs text-text-muted">{{ __('No staff notes yet.') }}</p>
                    @endforelse
                </div>

                <form wire:submit="addStaffNote" class="space-y-2">
                    <flux:textarea wire:model="staffNoteText" rows="2"
                        placeholder="{{ __('Add internal staff note...') }}" />
                    @error('staffNoteText')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <x-ui.button type="submit" variant="secondary" class="w-full">
                        {{ __('Add Note') }}
                    </x-ui.button>
                </form>
            </div>

            {{-- Resolution Tools --}}
            @if ($order->status->value === 'escalated')
                <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                    <h2 class="text-sm font-semibold text-green-400 uppercase tracking-wider flex items-center gap-2">
                        <flux:icon name="scale" class="w-4 h-4" />
                        {{ __('Resolution') }}
                    </h2>

                    <div class="space-y-3">
                        <flux:field>
                            <flux:label>{{ __('Resolution Type') }}</flux:label>
                            <flux:select wire:model.live="resolutionType">
                                <option value="">{{ __('Select...') }}</option>
                                <option value="buyer_wins">{{ __('Buyer Wins (100% Refund)') }}</option>
                                <option value="seller_wins">{{ __('Seller Wins (Release + 3-day Hold)') }}</option>
                                <option value="partial_split">{{ __('Partial Split') }}</option>
                                <option value="neutral_cancel">{{ __('Neutral Cancellation (100% Refund)') }}
                                </option>
                            </flux:select>
                        </flux:field>

                        {{-- Partial Split Slider --}}
                        @if ($resolutionType === 'partial_split')
                            <div class="space-y-2 bg-bg-primary rounded-lg p-3" x-data>
                                <label
                                    class="text-xs text-text-secondary font-medium">{{ __('Split Ratio') }}</label>
                                <input type="range" min="0" max="100" step="1"
                                    wire:model.live="splitBuyerPercent" class="w-full accent-primary-500" />
                                <div class="flex justify-between text-xs">
                                    <div class="text-blue-400">
                                        <p class="font-semibold">{{ __('Buyer') }}: {{ $splitBuyerPercent }}%</p>
                                        <p>${{ number_format($this->buyerAmount, 2) }}</p>
                                    </div>
                                    <div class="text-orange-400 text-right">
                                        <p class="font-semibold">{{ __('Seller') }}:
                                            {{ 100 - $splitBuyerPercent }}%</p>
                                        <p>${{ number_format($this->sellerAmount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <flux:field>
                            <flux:label>{{ __('Admin Notes (optional)') }}</flux:label>
                            <flux:textarea wire:model="resolutionNotes" rows="2"
                                placeholder="{{ __('Reason for this resolution...') }}" />
                        </flux:field>

                        @if ($resolutionType)
                            <x-ui.button wire:click="resolveOrder"
                                wire:confirm="{{ __('Are you sure you want to apply this resolution? This action cannot be undone.') }}"
                                variant="primary" class="w-full" wire:loading.attr="disabled">
                                <span wire:loading.remove
                                    wire:target="resolveOrder">{{ __('Apply Resolution') }}</span>
                                <span wire:loading wire:target="resolveOrder">{{ __('Processing...') }}</span>
                            </x-ui.button>
                        @endif
                    </div>
                </div>
            @elseif ($order->status->value === 'resolved')
                <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-2">
                    <h2 class="text-sm font-semibold text-green-400 uppercase tracking-wider">
                        {{ __('Resolution Applied') }}</h2>
                    <dl class="space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <dt class="text-text-muted">{{ __('Type') }}</dt>
                            <dd>
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium {{ $order->resolution_type?->color() ?? '' }}">
                                    {{ $order->resolution_type?->label() ?? '—' }}
                                </span>
                            </dd>
                        </div>
                        @if ($order->resolution_buyer_amount)
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Buyer Received') }}</dt>
                                <dd class="text-green-400">${{ number_format($order->resolution_buyer_amount, 2) }}
                                </dd>
                            </div>
                        @endif
                        @if ($order->resolution_seller_amount)
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Seller Received') }}</dt>
                                <dd class="text-green-400">${{ number_format($order->resolution_seller_amount, 2) }}
                                </dd>
                            </div>
                        @endif
                        @if ($order->resolved_at)
                            <div class="flex justify-between">
                                <dt class="text-text-muted">{{ __('Resolved at') }}</dt>
                                <dd class="text-text-secondary">{{ $order->resolved_at->format('M d, Y H:i') }}</dd>
                            </div>
                        @endif
                        @if ($order->resolution_notes)
                            <div class="mt-2 p-2 bg-bg-primary rounded-lg">
                                <p class="text-xs text-text-secondary whitespace-pre-line">
                                    {{ $order->resolution_notes }}</p>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            {{-- Mod Tools --}}
            <div class="bg-bg-secondary border border-zinc-800/60 rounded-xl p-4 space-y-3">
                <h2 class="text-sm font-semibold text-red-400 uppercase tracking-wider flex items-center gap-2">
                    <flux:icon name="shield-exclamation" class="w-4 h-4" />
                    {{ __('Mod Tools') }}
                </h2>

                <div class="space-y-3">
                    <flux:field>
                        <flux:label>{{ __('Target') }}</flux:label>
                        <flux:select wire:model.live="sanctionTarget">
                            <option value="">{{ __('Select user...') }}</option>
                            <option value="buyer">{{ __('Buyer') }} — {{ $buyer?->username ?? '?' }}</option>
                            <option value="seller">{{ __('Seller') }} — {{ $seller?->username ?? '?' }}</option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Sanction Type') }}</flux:label>
                        <flux:select wire:model.live="sanctionType">
                            <option value="">{{ __('Select action...') }}</option>
                            @foreach (\App\Enums\SanctionType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reason') }}</flux:label>
                        <flux:textarea wire:model="sanctionReason" rows="2"
                            placeholder="{{ __('Document the reason...') }}" />
                        @error('sanctionReason')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Duration') }}</flux:label>
                        <flux:select wire:model="sanctionDuration">
                            <option value="">{{ __('Select...') }}</option>
                            <option value="24h">{{ __('24 Hours') }}</option>
                            <option value="7d">{{ __('7 Days') }}</option>
                            <option value="30d">{{ __('30 Days') }}</option>
                            <option value="90d">{{ __('90 Days') }}</option>
                            <option value="permanent">{{ __('Permanent') }}</option>
                        </flux:select>
                    </flux:field>

                    @if ($sanctionTarget && $sanctionType)
                        <x-ui.button wire:click="applySanction"
                            wire:confirm="{{ __('Are you sure you want to apply this sanction?') }}"
                            variant="danger" class="w-full" wire:loading.attr="disabled">
                            {{ __('Apply Sanction') }}
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
