<section class="space-y-6">

    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-text-primary">{{ __('Payment Gateways') }}</h2>
                <p class="text-sm text-text-muted mt-1">
                    {{ __('Manage your payment gateway credentials and settings.') }}
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs text-text-muted bg-bg-secondary border border-border px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ $gateways->where('is_active', true)->count() }} / {{ $gateways->count() }} {{ __('Active') }}
            </div>
        </div>
    </div>

    {{-- Gateway Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach ($gateways as $gateway)
            @php
                $meta = match($gateway->slug) {
                    'stripe'  => ['icon' => 'credit-card',   'color' => '#6366f1'],
                    'crypto'  => ['icon' => 'bitcoin',        'color' => '#f59e0b'],
                    'tebex'   => ['icon' => 'shopping-bag',   'color' => '#22c55e'],
                    'wallet'  => ['icon' => 'wallet-minimal', 'color' => '#ec4899'],
                    default   => ['icon' => 'banknotes',      'color' => '#71717a'],
                };
                $creds   = $gateway->getCredentials();
                $hasKeys = !empty($creds) && count(array_filter($creds, fn($v) => $v !== '')) > 0;
            @endphp

            {{-- Each card has its own Alpine scope with a local `toggling` flag --}}
            <div
                x-data="{ toggling: false }"
                class="glass-card rounded-2xl overflow-hidden flex flex-col relative group hover:shadow-lg transition-all duration-300">

                {{-- Accent top bar --}}
                <div class="h-0.5 w-full" style="background: linear-gradient(90deg, {{ $meta['color'] }}55, {{ $meta['color'] }})"></div>

                {{-- Toggle loading overlay — shown instantly by Alpine --}}
                <div
                    x-show="toggling"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 z-10 bg-main/75 backdrop-blur-sm rounded-2xl flex items-center justify-center"
                    style="display: none;">
                    <div class="flex flex-col items-center gap-2">
                        <div class="relative w-8 h-8">
                            <div class="absolute inset-0 rounded-full border-4 border-white/10"></div>
                            <div class="absolute inset-0 rounded-full border-4 border-t-transparent border-l-transparent border-r-zinc-400 border-b-zinc-200 animate-spin"></div>
                        </div>
                        <span class="text-xs text-text-muted">{{ __('Updating…') }}</span>
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-1 gap-4">

                    {{-- Header --}}
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center border border-white/10 shrink-0 overflow-hidden"
                                style="background: {{ $meta['color'] }}18">
                                @if ($gateway->icon)
                                    <img src="{{ storage_url($gateway->icon) }}" alt="{{ $gateway->name }}" class="w-5 h-5 object-contain" />
                                @else
                                    <flux:icon name="{{ $meta['icon'] }}" class="w-5 h-5" style="color: {{ $meta['color'] }}" />
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-text-primary text-sm leading-tight">{{ $gateway->name }}</h3>
                                <span class="text-xs text-text-muted font-mono">{{ $gateway->slug }}</span>
                            </div>
                        </div>

                        {{-- Toggle button: Alpine sets toggling=true instantly, then calls Livewire,
                             Livewire re-renders the page which resets Alpine scope (toggling back to false) --}}
                        <button
                            @click="
                                toggling = true;
                                $wire.toggleActive({{ $gateway->id }}).then(() => { toggling = false });
                            "
                            :disabled="toggling"
                            title="{{ $gateway->is_active ? __('Deactivate') : __('Activate') }}"
                            class="relative inline-flex h-5 w-9 shrink-0 rounded-full border-2 border-transparent cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none {{ $gateway->is_active ? 'bg-green-500' : 'bg-zinc-600' }}">
                            <span class="pointer-events-none inline-block h-4 w-4 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $gateway->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                    {{-- Info rows --}}
                    <div class="space-y-2.5 flex-1 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-text-muted">{{ __('Status') }}</span>
                            <span class="inline-flex items-center gap-1 font-medium {{ $gateway->is_active ? 'text-green-500' : 'text-red-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $gateway->is_active ? 'bg-green-500' : 'bg-red-400' }}"></span>
                                {{ $gateway->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-muted">{{ __('Mode') }}</span>
                            <span class="inline-flex items-center gap-1 font-medium {{ $gateway->mode === \App\Enums\MethodModeStatus::LIVE ? 'text-green-500' : 'text-amber-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $gateway->mode === \App\Enums\MethodModeStatus::LIVE ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                {{ $gateway->mode?->label() ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-muted">{{ __('Keys') }}</span>
                            <span class="font-medium {{ $hasKeys ? 'text-green-500' : 'text-text-muted' }}">
                                {{ $hasKeys ? '✓ ' . __('Configured') : '— ' . __('Not set') }}
                            </span>
                        </div>
                        @if ($gateway->updated_at)
                            <div class="flex items-center justify-between">
                                <span class="text-text-muted">{{ __('Updated') }}</span>
                                <span class="text-text-muted">{{ $gateway->updated_at_human ?? $gateway->updated_at->diffForHumans() }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Configure button --}}
                    <button
                        @click="$dispatch('gateway-edit-open', { id: {{ $gateway->id }} })"
                        class="w-full flex items-center justify-center gap-2 py-2 px-4 rounded-xl text-xs font-semibold border border-white/10 hover:border-white/20 bg-white/5 hover:bg-white/10 text-text-primary transition-all duration-200 group/btn">
                        <flux:icon name="cog-6-tooth" class="w-3.5 h-3.5 text-text-muted group-hover/btn:rotate-45 transition-transform duration-300" />
                        {{ __('Configure') }}
                    </button>

                </div>
            </div>
        @endforeach
    </div>
</section>