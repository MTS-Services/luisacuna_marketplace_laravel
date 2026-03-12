{{--
    Deep View — Admin Order Management
    Laravel 12 · Livewire 4 · Alpine.js · Tailwind 4
    Supports: dark + light mode via Tailwind dark: prefix
--}}
<div class="flex flex-col gap-4 p-4 min-h-screen bg-gray-50 dark:bg-gray-950 transition-colors duration-200"
    x-data="{
        delaySeconds: {{ (int) $orderDelaySeconds }},
        isOverdue: {{ $isOverdue ? 'true' : 'false' }},
        ticker: null,
        splitBuyerPct: @entangle('splitBuyerPercent').live,
        escrowTotal: {{ number_format($escrowTotal, 2, '.', '') }},
        get buyerAmt() { return (this.escrowTotal * this.splitBuyerPct / 100).toFixed(2); },
        get sellerAmt() { return (this.escrowTotal - parseFloat(this.buyerAmt)).toFixed(2); },
        get timerLabel() {
            let s = this.delaySeconds;
            let h = Math.floor(s / 3600);
            let m = Math.floor((s % 3600) / 60);
            let sc = s % 60;
            if (h > 0) return h + ':' + String(m).padStart(2, '0') + ':' + String(sc).padStart(2, '0');
            return String(m).padStart(2, '0') + ':' + String(sc).padStart(2, '0');
        },
        startTimer() {
            this.ticker = setInterval(() => {
                if (this.isOverdue) { this.delaySeconds++; } else {
                    if (this.delaySeconds > 0) this.delaySeconds--;
                    else this.isOverdue = true;
                }
            }, 1000);
        }
    }" x-init="startTimer()" @destroy.window="clearInterval(ticker)">

    {{-- ═══════════════════════════════════════════════════════════
         HEADER BAR
    ═══════════════════════════════════════════════════════════ --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3 flex-wrap">
            {{-- Back button --}}
            <a href="{{ $backUrl ?? '#' }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                      bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                      text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white
                      hover:border-gray-300 dark:hover:border-gray-600
                      shadow-sm transition-all duration-150">
                <flux:icon name="arrow-left" class="w-4 h-4" />
            </a>

            {{-- Title --}}
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                    Deep View
                </span>
                <span class="text-gray-300 dark:text-gray-600">/</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white font-mono tracking-wide">
                    #{{ $order->order_id }}
                </span>
            </div>

            {{-- Status badge --}}
            <span
                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $order->status->color() }}">
                {{ $order->status->label() }}
            </span>

            {{-- Same IP warning --}}
            @if ($sameIpDetected)
                <span
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold
                             bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                             border border-red-300 dark:border-red-700/50 animate-pulse">
                    <flux:icon name="exclamation-triangle" class="w-3.5 h-3.5" />
                    SAME IP
                </span>
            @endif
        </div>

        {{-- Timestamps --}}
        <div class="flex items-center gap-4 text-xs">
            <span class="text-gray-500 dark:text-gray-500">
                {{ __('Created:') }}
                <span class="font-semibold text-gray-700 dark:text-gray-300 ml-1">
                    {{ $order->created_at?->format('d M Y, H:i') }}
                </span>
            </span>
            @if ($order->paid_at)
                <span class="text-gray-300 dark:text-gray-700">|</span>
                <span class="text-gray-500 dark:text-gray-500">
                    {{ __('Paid:') }}
                    <span class="font-semibold text-blue-600 dark:text-blue-400 ml-1">
                        {{ $order->paid_at->format('d M Y, H:i') }}
                    </span>
                </span>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         3-COLUMN GRID
    ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-[350px_1fr_320px] gap-4 items-start">

        {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
             COL 1 — PROFILES
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
        <div class="flex flex-col gap-4">

            <x-profile-card :user="$buyer" :role="'buyer'" :accentClass="'text-blue-600 dark:text-blue-400'" :dotClass="'bg-blue-500'" :ringClass="'ring-blue-500/20'"
                :routeHref="route('profile', $buyer->username) ?? '#'" :totalOrders="$buyerTotalOrders" :done="$buyerCompletedOrders" :cancelled="$buyerCancelledOrders" :trustScore="$buyerTrustScore"
                :wins="$buyerWins" :active="$buyerActiveDisputes" :disputeRate="$buyerDisputeRate" :country="$buyerCountry" :countryCode="$buyerCountryCode"
                :sellerSince="$buyerSellerSince" :ipMatch="$buyerIpMatch" :hasIp="$buyerLastIp ? true : false" :sameIp="$sameIpDetected" :statsLabel="'Shopping'"
                :dispLabel="'Score'" :dispValue="$buyerTrustScore . '%'" :winLabel="'Won'" :winValue="$buyerWins" :repOrScore="$buyerTrustScore" />

            <x-profile-card :user="$seller" :role="'seller'" :accentClass="'text-orange-600 dark:text-orange-400'" :dotClass="'bg-orange-500'"
                :ringClass="'ring-orange-500/20'" :routeHref="route('profile', $seller->username) ?? '#'" :totalOrders="$sellerTotalSales" :done="$sellerCompletedSales" :cancelled="$sellerCancelledSales"
                :trustScore="$sellerReputation" :wins="$sellerWins" :active="$sellerActiveDisputes" :disputeRate="$sellerDisputeRate" :country="$sellerCountry"
                :countryCode="$sellerCountryCode" :sellerSince="$sellerSellerSince" :ipMatch="$sellerIpMatch" :hasIp="$sellerLastIp ? true : false" :sameIp="$sameIpDetected"
                :statsLabel="'Sales'" :dispLabel="'Rep.'" :dispValue="$sellerReputation . '%'" :winLabel="'Lost'" :winValue="$sellerLosses"
                :repOrScore="$sellerReputation" />

            {{-- ▌TIMELINE (collapsible) --}}
            @if ($statusTimeline->isNotEmpty())
                <div x-data="{ open: false }"
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3
                                   hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <flux:icon name="clock" class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                                {{ __('Order Status Timeline') }}
                            </span>
                            <span
                                class="inline-flex items-center justify-center min-w-5 h-5 px-1.5
                                         rounded-full text-[10px] font-bold
                                         bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                {{ $statusTimeline->count() }}
                            </span>
                        </div>
                        {{-- <flux:icon name="chevron-down" class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" /> --}}
                    </button>
                    <div x-show="open" x-collapse class="border-t border-gray-100 dark:border-gray-800">
                        <div class="p-3 max-h-56 overflow-y-auto space-y-2.5">
                            @foreach ($statusTimeline as $entry)
                                <div class="flex items-start gap-2.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-700 dark:text-gray-300">
                                            <span class="font-medium">{{ $entry->from_status?->label() ?? '—' }}</span>
                                            <span class="text-gray-400 dark:text-gray-600 mx-1">→</span>
                                            <span
                                                class="font-semibold text-gray-900 dark:text-white">{{ $entry->to_status->label() }}</span>
                                        </p>
                                        <p class="text-[11px] text-gray-400 dark:text-gray-600 mt-0.5">
                                            {{ ucfirst($entry->actor_type) }} ·
                                            {{ $entry->created_at?->format('d M, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ▌DELIVERY PROOFS (collapsible) --}}
            @if ($deliveryRecords->isNotEmpty())
                <div x-data="{ open: false }"
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3
                                   hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <flux:icon name="document-text" class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                                {{ __('Delivery Proofs') }}
                            </span>
                            <span
                                class="inline-flex items-center justify-center min-w-5 h-5 px-1.5
                                         rounded-full text-[10px] font-bold
                                         bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                {{ $deliveryRecords->count() }}
                            </span>
                        </div>
                        {{-- <flux:icon name="chevron-down" class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" /> --}}
                    </button>
                    <div x-show="open" x-collapse class="border-t border-gray-100 dark:border-gray-800">
                        <div class="p-3 max-h-56 overflow-y-auto space-y-2">
                            @foreach ($deliveryRecords as $delivery)
                                <div class="bg-gray-50 dark:bg-gray-800/60 rounded-lg p-3 space-y-1.5">
                                    <p
                                        class="text-xs text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                        {{ $delivery->delivery_message }}
                                    </p>
                                    @if ($delivery->files)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($delivery->files as $file)
                                                <span
                                                    class="text-[10px] bg-gray-200 dark:bg-gray-700
                                                             text-gray-600 dark:text-gray-400 rounded px-1.5 py-0.5">
                                                    {{ basename($file) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <p class="text-[11px] text-gray-400 dark:text-gray-600">
                                        {{ $delivery->created_at?->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
             COL 2 — ORDER INFO + CHAT
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
        <div class="flex flex-col gap-4 min-h-0">

            {{-- ORDER & CHAT PANEL --}}
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
                        rounded-xl overflow-hidden shadow-sm flex flex-col">

                {{-- Panel header --}}
                <div
                    class="flex items-center justify-between px-5 py-3
                            bg-gray-50 dark:bg-gray-800/60
                            border-b border-gray-200 dark:border-gray-800">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        {{ __('Order & Chat') }}
                    </span>
                    {{-- @if ($order->status->isChatLocked())
                        <div class="flex items-center gap-1.5 text-xs text-red-600 dark:text-red-400 font-medium">
                            <flux:icon name="lock-closed" class="w-3.5 h-3.5" />
                            {{ __('Chat Locked') }}
                        </div>
                    @endif --}}
                </div>

                {{-- Item info bar + countdown --}}
                <div
                    class="flex items-center justify-between gap-4 px-5 py-3
                            border-b border-gray-100 dark:border-gray-800/70">
                    <div class="flex items-center gap-3 min-w-0">
                        @if ($order->source?->game?->logo)
                            <img src="{{ storage_url($order->source->game->logo) }}"
                                class="w-9 h-9 rounded-lg object-cover shadow-sm shrink-0" />
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                {{ $order->source?->translatedName(app()->getLocale()) ?? __('Unknown Item') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 truncate mt-0.5">
                                {{ $order->source?->game?->translatedName(app()->getLocale()) }}
                                @if ($order->quantity > 1)
                                    · <span class="text-gray-400 dark:text-gray-600">{{ $order->quantity }}×</span>
                                @endif
                                · <span class="font-semibold text-gray-700 dark:text-gray-300">
                                    ${{ number_format($order->default_grand_total ?? $order->grand_total, 2) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Live countdown timer --}}
                    @if ($orderDelaySeconds > 0)
                        <div class="shrink-0 flex items-center gap-1.5 rounded-lg px-3 py-1.5 border font-mono text-xs font-bold"
                            :class="isOverdue
                                ?
                                'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400' :
                                'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800/50 text-green-600 dark:text-green-400'">
                            <flux:icon name="clock" class="w-3.5 h-3.5" />
                            <span x-text="(isOverdue ? 'Delay: -' : 'Auto: +') + timerLabel"></span>
                        </div>
                    @endif
                </div>

                {{-- Dispute info --}}
                @if ($dispute)
                    <div
                        class="px-5 py-2.5 border-b border-gray-100 dark:border-gray-800/70
                                bg-red-50/50 dark:bg-red-900/10 flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-red-500 shrink-0"></div>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-500 uppercase tracking-wider">
                                {{ __('Dispute') }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $dispute->status->color() }}">
                                {{ $dispute->status->label() }}
                            </span>
                        </div>
                        @if ($dispute->reason_category)
                            <span
                                class="text-xs text-gray-500 dark:text-gray-500">{{ $dispute->reason_category }}</span>
                        @endif
                        @if ($dispute->description)
                            <p
                                class="w-full text-xs text-gray-600 dark:text-gray-400
                                      bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30
                                      rounded-lg px-3 py-1.5 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($dispute->description, 180) }}
                            </p>
                        @endif
                    </div>
                @endif

                {{-- ── CHAT MESSAGES ── --}}
                <div class="overflow-y-auto px-5 py-4 space-y-4 min-h-[320px] max-h-[440px]" id="chat-scroll"
                    wire:poll.5s="loadChatMessages" x-data="{
                        atBottom: true,
                        threshold: 60,
                        init() {
                            this.$el.scrollTop = this.$el.scrollHeight;
                    
                            this.$el.addEventListener('scroll', () => {
                                const el = this.$el;
                                this.atBottom = (el.scrollHeight - el.scrollTop - el.clientHeight) < this.threshold;
                            });
                    
                            new MutationObserver(() => {
                                if (this.atBottom) {
                                    this.$el.scrollTop = this.$el.scrollHeight;
                                }
                            }).observe(this.$el, { childList: true, subtree: true });
                        }
                    }">

                    @forelse ($chatMessages as $msg)
                        @php
                            $senderType = $msg->sender_type ?? '';
                            $senderId = (int) ($msg->sender_id ?? 0);
                            $msgBody = $msg->message_body ?? ($msg->message ?? '');
                            $msgType = $msg->message_type?->value ?? ($msg->message_type ?? 'text');
                            $isSystem =
                                is_null($msg->sender_id) || in_array($msgType, ['system', 'order_notification']);
                            $isAdmin = !$isSystem && str_contains($senderType, 'Admin');
                            $isBuyer = !$isSystem && !$isAdmin && $buyer && $senderId === (int) $buyer->id;
                        @endphp

                        @if ($isSystem)
                            {{-- System message --}}
                            <div class="flex items-center gap-3">
                                <div class="h-px flex-1 bg-gray-200 dark:bg-gray-800"></div>
                                <p
                                    class="text-[11px] text-gray-400 dark:text-gray-600 px-2 text-center max-w-sm leading-relaxed">
                                    {{ $msgBody }}</p>
                                <div class="h-px flex-1 bg-gray-200 dark:bg-gray-800"></div>
                            </div>
                        @elseif ($isAdmin)
                            {{-- Admin message — centered --}}
                            <div class="flex flex-col items-center gap-1">
                                <p class="text-[11px] font-semibold text-amber-600 dark:text-amber-500">
                                    {{ $msg->sender?->full_name ?? ($msg->sender?->first_name . ' ' . $msg->sender?->last_name ?? __('Admin')) }}
                                    · {{ $msg->created_at?->diffForHumans() }}
                                </p>
                                <div
                                    class="max-w-[82%] bg-amber-50 dark:bg-amber-900/20
                                            border border-amber-200 dark:border-amber-700/40
                                            rounded-2xl px-4 py-2.5">
                                    <p
                                        class="text-sm text-amber-800 dark:text-amber-200 whitespace-pre-line break-words leading-relaxed">
                                        {{ $msgBody }}</p>
                                </div>
                            </div>
                        @elseif ($isBuyer)
                            {{-- Buyer — left --}}
                            <div class="flex items-end gap-2.5">
                                <img src="{{ auth_storage_url($buyer->avatar) }}"
                                    class="w-7 h-7 rounded-full object-cover shrink-0 ring-2 ring-blue-200 dark:ring-blue-800" />
                                <div class="max-w-[78%]">
                                    <p class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold mb-1 ml-1">
                                        {{ $buyer->username }} · {{ $msg->created_at?->diffForHumans() }}
                                    </p>
                                    <div
                                        class="bg-gray-100 dark:bg-gray-800
                                                border border-gray-200 dark:border-gray-700/50
                                                rounded-2xl rounded-bl-sm px-4 py-2.5">
                                        <p
                                            class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line break-words leading-relaxed">
                                            {{ $msgBody }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Seller — right --}}
                            <div class="flex items-end gap-2.5 flex-row-reverse">
                                @if ($seller)
                                    <img src="{{ auth_storage_url($seller->avatar) }}"
                                        class="w-7 h-7 rounded-full object-cover shrink-0 ring-2 ring-orange-200 dark:ring-orange-800" />
                                @endif
                                <div class="max-w-[78%]">
                                    <p
                                        class="text-[11px] text-orange-600 dark:text-orange-400 font-semibold mb-1 mr-1 text-right">
                                        {{ $msg->created_at?->diffForHumans() }} ·
                                        {{ $seller?->username ?? __('Seller') }}
                                    </p>
                                    <div
                                        class="bg-orange-50 dark:bg-gray-700/50
                                                border border-orange-100 dark:border-gray-600/40
                                                rounded-2xl rounded-br-sm px-4 py-2.5">
                                        <p
                                            class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line break-words leading-relaxed">
                                            {{ $msgBody }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 gap-3">
                            <flux:icon name="chat-bubble-left-right"
                                class="w-10 h-10 text-gray-300 dark:text-gray-700" />
                            <p class="text-sm text-gray-400 dark:text-gray-600">{{ __('No messages yet.') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Admin input --}}
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                    <form wire:submit="sendAdminMessage" class="flex gap-2.5 items-center">
                        <flux:input wire:model="adminMessage" placeholder="{{ __('Intervene as Admin...') }}"
                            class="flex-1 text-sm" />
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex items-center gap-2 px-4 py-2.5
                                   bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-500
                                   disabled:opacity-40 disabled:cursor-not-allowed
                                   text-white text-xs font-bold rounded-lg shadow-sm transition-all shrink-0">
                            <flux:icon name="paper-airplane" class="w-4 h-4" />
                            <span wire:loading.remove wire:target="sendAdminMessage">{{ __('Send') }}</span>
                            <span wire:loading wire:target="sendAdminMessage">...</span>
                        </button>
                    </form>
                    @error('adminMessage')
                        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- STAFF NOTES --}}
            <div x-data="{ expanded: {{ $staffNotes->isNotEmpty() ? 'true' : 'false' }} }"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
                        rounded-xl overflow-hidden shadow-sm">
                <button @click="expanded = !expanded"
                    class="w-full flex items-center justify-between px-5 py-3.5
                               bg-amber-50/70 dark:bg-amber-900/10
                               hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors
                               border-b border-amber-100 dark:border-amber-800/20">
                    <div class="flex items-center gap-2.5">
                        <flux:icon name="exclamation-triangle" class="w-4 h-4 text-amber-600 dark:text-amber-500" />
                        <span class="text-xs font-bold text-amber-700 dark:text-amber-500 uppercase tracking-widest">
                            {{ __('Staff Notes') }}
                        </span>
                        @if ($staffNotes->isNotEmpty())
                            <span
                                class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full
                                         text-[10px] font-bold
                                         bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400
                                         border border-amber-200 dark:border-amber-700/40">
                                {{ $staffNotes->count() }}
                            </span>
                        @endif
                    </div>
                    {{-- <flux:icon name="chevron-down" class="w-4 h-4 text-amber-500 transition-transform duration-200"
                        :class="expanded ? 'rotate-180' : ''" /> --}}
                </button>

                <div x-show="expanded" x-collapse>
                    @if ($staffNotes->isNotEmpty())
                        <div wire:poll.5s="loadStaffNotes" x-data="{
                            atTop: true,
                            threshold: 60,
                            init() {
                                this.$el.scrollTop = 0;
                        
                                this.$el.addEventListener('scroll', () => {
                                    this.atTop = this.$el.scrollTop < this.threshold;
                                });
                        
                                new MutationObserver(() => {
                                    if (this.atTop) {
                                        this.$el.scrollTop = 0;
                                    }
                                }).observe(this.$el, { childList: true, subtree: true });
                            }
                        }"
                            class="p-4 space-y-2.5 max-h-48 overflow-y-auto border-b border-gray-100 dark:border-gray-800">
                            @foreach ($staffNotes as $note)
                                <div
                                    class="bg-amber-50 dark:bg-amber-900/10
                                            border border-amber-100 dark:border-amber-800/20
                                            rounded-xl px-4 py-3">
                                    <p
                                        class="text-sm text-gray-700 dark:text-amber-100 whitespace-pre-line leading-relaxed">
                                        {{ $note->note }}</p>
                                    <p class="text-[11px] text-amber-600/70 dark:text-amber-600/60 mt-1.5">
                                        {{ $note->admin?->full_name ?? ($note->admin?->first_name . ' ' . $note->admin?->last_name ?? __('Admin')) }}
                                        · {{ $note->created_at?->diffForHumans() }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-5 py-3">
                            <p class="text-sm text-gray-400 dark:text-gray-600">{{ __('No staff notes yet.') }}</p>
                        </div>
                    @endif

                    <div class="px-4 py-3">
                        <form wire:submit="addStaffNote" class="flex gap-2.5 items-start">
                            <flux:textarea wire:model="staffNoteText" rows="2"
                                placeholder="{{ __('Add internal note...') }}" class="flex-1 text-sm resize-none" />
                            <button type="submit" wire:loading.attr="disabled"
                                class="mt-0.5 px-3 py-2
                                           bg-gray-800 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600
                                           text-white text-xs font-semibold rounded-lg transition-colors shrink-0 disabled:opacity-50">
                                {{ __('Add') }}
                            </button>
                        </form>
                        @error('staffNoteText')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
             COL 3 — ACTIONS + RESOLUTION
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}
        <div class="flex flex-col gap-4">

            @if ($order->status->value === 'resolved')
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-4 py-3 bg-green-50 dark:bg-green-900/10
                        border-b border-green-100 dark:border-green-800/20 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-widest">
                            {{ __('Resolution Applied') }}
                        </span>
                    </div>
                    <div class="p-4 space-y-2.5">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-500">{{ __('Type') }}</span>
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                 {{ $order->resolution_type?->color() ?? 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                                {{ $order->resolution_type?->label() ?? '—' }}
                            </span>
                        </div>
                        @if ($order->resolution_buyer_amount)
                            <div class="flex justify-between">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-500">{{ __('Buyer Received') }}</span>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                    ${{ number_format($order->resolution_buyer_amount, 2) }}
                                </span>
                            </div>
                        @endif
                        @if ($order->resolution_seller_amount)
                            <div class="flex justify-between">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-500">{{ __('Seller Received') }}</span>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                    ${{ number_format($order->resolution_seller_amount, 2) }}
                                </span>
                            </div>
                        @endif
                        @if ($order->resolved_at)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-500">{{ __('Resolved at') }}</span>
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $order->resolved_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        @endif
                        @if ($order->resolution_notes)
                            <div
                                class="bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700 rounded-xl p-3 mt-1">
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                    {{ $order->resolution_notes }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif ($order->status->value === 'escalated')
                {{-- ▌ACTIONS / SANCTIONS --}}
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-4 py-3 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('Actions / Sanctions') }}
                        </span>
                    </div>

                    <div class="p-4 space-y-3">
                        {{-- Target --}}
                        <flux:select wire:model.live="sanctionTarget"
                            class="w-full text-sm border-gray-200 dark:border-gray-700">
                            <option value="">{{ __('Select target user...') }}</option>
                            <option value="buyer">{{ __('Buyer') }}: {{ $buyer?->username ?? '?' }}</option>
                            <option value="seller">{{ __('Seller') }}: {{ $seller?->username ?? '?' }}</option>
                        </flux:select>

                        {{-- Duration --}}
                        <flux:select wire:model="sanctionDuration"
                            class="w-full text-sm border-gray-200 dark:border-gray-700">
                            <option value="">{{ __('Select Duration...') }}</option>
                            <option value="24h">{{ __('24 Hours') }}</option>
                            <option value="7d">{{ __('7 Days') }}</option>
                            <option value="30d">{{ __('30 Days') }}</option>
                            <option value="90d">{{ __('90 Days') }}</option>
                            <option value="permanent">{{ __('Permanent') }}</option>
                        </flux:select>

                        {{-- Reason textarea --}}
                        <div>
                            <flux:textarea wire:model="sanctionReason" rows="2"
                                placeholder="{{ __('Write reason (e.g. Fraud attempt, Dispute abuse)...') }}"
                                class="w-full text-sm resize-none border-gray-200 dark:border-gray-700" />
                            @error('sanctionReason')
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2×2 action buttons --}}
                        @php
                            $canSanction = $sanctionTarget && $sanctionDuration;
                            $sanctionButtons = [
                                [
                                    'key' => 'force_kyc',
                                    'label' => 'Force KYC',
                                    'icon' => 'identification',
                                    'light' => 'bg-blue-50 border-blue-200 text-blue-700 hover:bg-blue-100',
                                    'dark' =>
                                        'dark:bg-blue-900/20 dark:border-blue-700/50 dark:text-blue-400 dark:hover:bg-blue-900/40',
                                ],
                                [
                                    'key' => 'freeze_wallet',
                                    'label' => 'Freeze Wallet',
                                    'icon' => 'lock-closed',
                                    'light' => 'bg-cyan-50 border-cyan-200 text-cyan-700 hover:bg-cyan-100',
                                    'dark' =>
                                        'dark:bg-cyan-900/20 dark:border-cyan-700/50 dark:text-cyan-400 dark:hover:bg-cyan-900/40',
                                ],
                                [
                                    'key' => 'suspend',
                                    'label' => 'Suspend',
                                    'icon' => 'pause-circle',
                                    'light' => 'bg-yellow-50 border-yellow-200 text-yellow-700 hover:bg-yellow-100',
                                    'dark' =>
                                        'dark:bg-yellow-900/20 dark:border-yellow-700/50 dark:text-yellow-400 dark:hover:bg-yellow-900/40',
                                ],
                                [
                                    'key' => 'ban_hwid',
                                    'label' => 'Ban HWID',
                                    'icon' => 'computer-desktop',
                                    'light' => 'bg-red-50 border-red-200 text-red-700 hover:bg-red-100',
                                    'dark' =>
                                        'dark:bg-red-900/20 dark:border-red-700/50 dark:text-red-400 dark:hover:bg-red-900/40',
                                ],
                            ];
                            $disabledStyle =
                                'bg-gray-50 dark:bg-gray-800/40 border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-600 cursor-not-allowed';
                        @endphp

                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($sanctionButtons as $s)
                                <button wire:click="$set('sanctionType', '{{ $s['key'] }}')"
                                    @if ($canSanction && $sanctionReason) wire:then="applySanction"
                                    wire:confirm="{{ __('Apply ') . $s['label'] . __(' to this user?') }}"
                                @else
                                    disabled @endif
                                    class="flex items-center justify-center gap-1.5 px-2.5 py-2.5 rounded-xl border
                                       text-xs font-bold uppercase tracking-wide transition-all duration-150
                                       {{ $canSanction && $sanctionReason ? $s['light'] . ' ' . $s['dark'] : $disabledStyle }}">
                                    <flux:icon name="{{ $s['icon'] }}" class="w-4 h-4" />
                                    {{ $s['label'] }}
                                </button>
                            @endforeach
                        </div>

                        @if ($canSanction && !$sanctionReason)
                            <p class="text-xs text-amber-600 dark:text-amber-500 text-center font-medium">
                                {{ __('Add a reason to enable actions.') }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- ▌RESOLUTION PANEL --}}
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="flex items-center justify-between px-4 py-3
                                bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <flux:icon name="scale" class="w-4 h-4 text-green-600 dark:text-green-500" />
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                                {{ __('Resolution') }}
                            </span>
                        </div>
                        <span class="text-base font-bold text-gray-900 dark:text-white">
                            ${{ number_format($escrowTotal, 2) }}
                        </span>
                    </div>

                    <div class="p-4 space-y-4">

                        {{-- Slider section --}}
                        <div class="space-y-3">
                            {{-- Labels --}}
                            <div class="flex justify-between items-center text-xs font-bold">
                                <span class="text-blue-700 dark:text-blue-400">
                                    {{ __('Buyer:') }}
                                    <span x-text="splitBuyerPct + '%'"></span>
                                </span>
                                <span class="text-orange-700 dark:text-orange-400">
                                    {{ __('Seller:') }}
                                    <span x-text="(100 - splitBuyerPct) + '%'"></span>
                                </span>
                            </div>

                            {{-- Slider track --}}
                            <div class="relative h-6 flex items-center select-none">
                                <div
                                    class="absolute inset-x-0 h-2 rounded-full overflow-hidden
                                            bg-gray-200 dark:bg-gray-700">
                                    <div class="h-full transition-all duration-75"
                                        :style="`background: linear-gradient(to right, #3b82f6 ${splitBuyerPct}%, #f97316 ${splitBuyerPct}%)`">
                                    </div>
                                </div>
                                <input type="range" min="0" max="100" step="1"
                                    wire:model.live="splitBuyerPercent"
                                    class="absolute inset-x-0 h-6 w-full cursor-pointer opacity-0 z-10" />
                                <div class="absolute w-5 h-5 bg-white dark:bg-gray-200 rounded-full
                                            shadow-md border-2 border-blue-500 pointer-events-none
                                            transition-all duration-75"
                                    :style="`left: calc(${splitBuyerPct}% - 10px)`">
                                </div>
                            </div>

                            {{-- Amount cards --}}
                            <div class="grid grid-cols-2 gap-2">
                                <div
                                    class="bg-blue-50 dark:bg-blue-900/15
                                            border border-blue-200 dark:border-blue-800/30
                                            rounded-xl p-3 text-center">
                                    <p
                                        class="text-[10px] font-bold text-blue-500 dark:text-blue-400/70
                                              uppercase tracking-wider mb-1">
                                        {{ __('Refund (Buyer)') }}</p>
                                    <p class="text-base font-bold text-blue-700 dark:text-blue-300"
                                        x-text="'$' + buyerAmt"></p>
                                </div>
                                <div
                                    class="bg-orange-50 dark:bg-orange-900/15
                                            border border-orange-200 dark:border-orange-800/30
                                            rounded-xl p-3 text-center">
                                    <p
                                        class="text-[10px] font-bold text-orange-500 dark:text-orange-400/70
                                              uppercase tracking-wider mb-1">
                                        {{ __('Payment (Seller)') }}</p>
                                    <p class="text-base font-bold text-orange-700 dark:text-orange-300"
                                        x-text="'$' + sellerAmt"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <flux:textarea wire:model="resolutionNotes" rows="2"
                            placeholder="{{ __('Resolution notes (optional)...') }}"
                            class="w-full text-sm resize-none border-gray-200 dark:border-gray-700" />

                        {{-- Action buttons --}}
                        <div class="space-y-2">

                            {{-- Apply Split --}}
                            <button wire:click="applySplit"
                                wire:confirm="{{ __('Apply this split? This action cannot be undone.') }}"
                                wire:loading.attr="disabled"
                                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl
                                       bg-violet-600 hover:bg-violet-700 dark:bg-violet-700 dark:hover:bg-violet-600
                                       text-white text-xs font-bold uppercase tracking-wide
                                       shadow-sm transition-all disabled:opacity-50">
                                <flux:icon name="scale" class="w-4 h-4 stroke-white" />
                                <span wire:loading.remove wire:target="applySplit"
                                    class="text-white">{{ __('Apply Division') }}</span>
                                <span wire:loading wire:target="applySplit"
                                    class="text-white">{{ __('Processing...') }}</span>
                            </button>

                            {{-- Win Buyer --}}
                            <button wire:click="awardBuyer"
                                wire:confirm="{{ __('Award full amount to buyer? This cannot be undone.') }}"
                                wire:loading.attr="disabled"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl
                                       bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600
                                       text-white text-xs font-bold uppercase tracking-wide
                                       shadow-sm transition-all disabled:opacity-50">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                                    <span wire:loading.remove wire:target="awardBuyer"
                                        class="text-white">{{ __('Win Buyer') }}</span>
                                    <span wire:loading wire:target="awardBuyer"
                                        class="text-white">{{ __('Processing...') }}</span>
                                </div>
                                <span class="font-bold text-red-100">${{ number_format($escrowTotal, 2) }}</span>
                            </button>

                            {{-- Win Seller --}}
                            <button wire:click="awardSeller"
                                wire:confirm="{{ __('Award full amount to seller? This cannot be undone.') }}"
                                wire:loading.attr="disabled"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl
                                       bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600
                                       text-white text-xs font-bold uppercase tracking-wide
                                       shadow-sm transition-all disabled:opacity-50">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="check-circle" class="w-4 h-4 stroke-white" />
                                    <span wire:loading.remove wire:target="awardSeller" class="text-white">
                                        {{ __('Win Seller') }}
                                        @if ($seller)
                                            <span
                                                class="normal-case font-normal tracking-normal opacity-80 text-white">
                                                {{ $seller->username }}
                                            </span>
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="awardSeller">{{ __('Processing...') }}</span>
                                </div>
                                <span class="font-bold text-green-100">${{ number_format($escrowTotal, 2) }}</span>
                            </button>

                            {{-- Neutral cancel --}}
                            {{-- <button wire:click="applyNeutralCancel"
                                wire:confirm="{{ __('Neutral cancel — full refund to buyer?') }}"
                                wire:loading.attr="disabled"
                                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl
                                       bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-600 dark:text-gray-400 text-xs font-semibold
                                       transition-all disabled:opacity-50">
                                <flux:icon name="arrow-uturn-left" class="w-4 h-4" />
                                {{ __('Neutral Cancel (Refund)') }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            @else
                {{-- Non-escalated: order details --}}
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-4 py-3 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('Order Details') }}
                        </span>
                    </div>
                    <div class="p-4 space-y-2.5">
                        @foreach ([['label' => __('Grand Total'), 'value' => '$' . number_format($order->default_grand_total ?? $order->grand_total, 2), 'cls' => 'font-bold text-gray-900 dark:text-white'], ['label' => __('Quantity'), 'value' => $order->quantity, 'cls' => 'text-gray-700 dark:text-gray-300']] as $row)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-500">{{ $row['label'] }}</span>
                                <span class="text-sm {{ $row['cls'] }}">{{ $row['value'] }}</span>
                            </div>
                        @endforeach
                        @if ($order->delivered_at)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-500">{{ __('Delivered') }}</span>
                                <span
                                    class="text-sm text-gray-700 dark:text-gray-300">{{ $order->delivered_at->format('d M, H:i') }}</span>
                            </div>
                        @endif
                        @if ($order->auto_completes_at && $order->status->value === 'delivered')
                            <div class="flex justify-between">
                                <span
                                    class="text-sm text-amber-600 dark:text-amber-500">{{ __('Auto-completes') }}</span>
                                <span
                                    class="text-sm font-semibold text-amber-600 dark:text-amber-400">{{ $order->auto_completes_at->diffForHumans() }}</span>
                            </div>
                        @endif
                        @if ($order->escalated_at)
                            <div class="flex justify-between">
                                <span class="text-sm text-red-600 dark:text-red-500">{{ __('Escalated') }}</span>
                                <span
                                    class="text-sm text-red-600 dark:text-red-400">{{ $order->escalated_at->format('d M, H:i') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- <div class="p-4">
                        <button wire:click="forceOpenEscalation"
                            wire:confirm="{{ __('Force open escalation? This action cannot be undone.') }}"
                            wire:loading.attr="disabled"
                            class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl
                                       bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-600 dark:text-gray-400 text-xs font-semibold
                                       transition-all disabled:opacity-50">
                            <flux:icon name="arrow-uturn-left" class="w-4 h-4" />
                            {{ __('Force Open Escalation') }}
                        </button>
                    </div> --}}
                </div>
            @endif

            {{-- Dispute evidence --}}
            @if ($dispute && $dispute->attachments->isNotEmpty())
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-4 py-3 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                            {{ __('Evidence Files') }}
                        </span>
                    </div>
                    <div class="p-3 space-y-1.5">
                        @foreach ($dispute->attachments as $att)
                            <div
                                class="flex items-center justify-between rounded-xl
                                        bg-gray-50 dark:bg-gray-800/60
                                        border border-gray-100 dark:border-gray-700/50
                                        px-3 py-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate max-w-[72%]">
                                    {{ $att->original_name ?? basename($att->path) }}
                                </span>
                                <span
                                    class="text-[10px] font-bold
                                             bg-gray-200 dark:bg-gray-700
                                             text-gray-500 dark:text-gray-400
                                             rounded px-1.5 py-0.5 ml-2 shrink-0 uppercase">
                                    {{ pathinfo($att->path, PATHINFO_EXTENSION) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>{{-- /col 3 --}}
    </div>
</div>
