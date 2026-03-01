<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-text-primary">{{ __('Payment Gateways') }}</h2>
                <p class="text-sm text-text-muted mt-1">{{ __('Manage your payment gateway credentials and settings.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Gateway Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($gateways as $gateway)
            <div class="glass-card rounded-2xl p-6 flex flex-col justify-between relative overflow-hidden">
                {{-- Status indicator bar --}}
                <div class="absolute top-0 left-0 right-0 h-1 {{ $gateway->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                </div>

                <div>
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-4 pt-1">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl glass-card shadow-shadow-primary flex items-center justify-center">
                                @if ($gateway->slug === 'stripe')
                                    <flux:icon name="credit-card" class="w-5 h-5 text-zinc-500" />
                                @elseif ($gateway->slug === 'crypto')
                                    <flux:icon name="bitcoin" class="w-5 h-5 text-zinc-500" />
                                @else
                                    <flux:icon name="wallet-minimal" class="w-5 h-5 text-zinc-500" />
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-text-primary text-base">{{ $gateway->name }}</h3>
                                <span class="text-xs text-text-muted font-mono">{{ $gateway->slug }}</span>
                            </div>
                        </div>

                        {{-- Active toggle --}}
                        <button wire:click="toggleActive({{ $gateway->id }})" wire:loading.attr="disabled"
                            class="relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 {{ $gateway->is_active ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }}"
                            role="switch" aria-checked="{{ $gateway->is_active ? 'true' : 'false' }}"
                            title="{{ $gateway->is_active ? 'Deactivate' : 'Activate' }}">
                            <span
                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $gateway->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                    {{-- Info rows --}}
                    <div class="space-y-3 mb-5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-muted">{{ __('Status') }}</span>
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full {{ $gateway->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $gateway->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $gateway->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-muted">{{ __('Mode') }}</span>
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full {{ $gateway->mode === \App\Enums\MethodModeStatus::LIVE ? 'bg-green-500/10 text-green-500' : 'bg-amber-500/10 text-amber-500' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $gateway->mode === \App\Enums\MethodModeStatus::LIVE ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                {{ $gateway->mode?->label() ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-muted">{{ __('Credentials') }}</span>
                            @php
                                $creds = $gateway->getCredentials();
                                $hasKeys = !empty($creds) && count(array_filter($creds, fn($v) => $v !== '')) > 0;
                            @endphp
                            <span
                                class="text-xs font-medium px-2.5 py-1 rounded-full {{ $hasKeys ? 'bg-green-500/10 text-green-500' : 'bg-zinc-500/10 text-text-muted' }}">
                                {{ $hasKeys ? __('Configured') : __('Not Set') }}
                            </span>
                        </div>
                        @if ($gateway->updated_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-text-muted">{{ __('Last Updated') }}</span>
                                <span class="text-xs text-text-muted">{{ $gateway->updated_at_human }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Edit button --}}
                <x-ui.button wire:click="openEdit({{ $gateway->id }})" variant="secondary" class="w-full! py-2!">
                    <flux:icon name="cog-6-tooth" class="w-4 h-4" />
                    {{ __('Configure') }}
                </x-ui.button>
            </div>
        @endforeach
    </div>

    {{-- Edit Modal (Alpine.js for open/close, Livewire for data) --}}
    @if ($showEditModal && $editingGatewayId)
        @php
            $editingGateway = $gateways->firstWhere('id', $editingGatewayId);
            $fields = $this->credentialFields[$editingGateway?->slug] ?? [];
        @endphp

        <div x-data="{ open: true }" x-show="open" x-on:keydown.escape.window="open = false; $wire.closeEdit()"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" x-on:click="open = false; $wire.closeEdit()"></div>

            {{-- Modal Panel --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative glass-card rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto custom-scrollbar z-10">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-6 border-b border-border">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl glass-card shadow-shadow-primary flex items-center justify-center">
                            @if ($editingGateway?->slug === 'stripe')
                                <flux:icon name="credit-card" class="w-5 h-5 text-zinc-500" />
                            @elseif ($editingGateway?->slug === 'crypto')
                                <flux:icon name="bitcoin" class="w-5 h-5 text-zinc-500" />
                            @else
                                <flux:icon name="wallet-minimal" class="w-5 h-5 text-zinc-500" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-text-primary">{{ __('Configure') }} {{ $editName }}
                            </h3>
                            <span class="text-xs text-text-muted font-mono">{{ $editingGateway?->slug }}</span>
                        </div>
                    </div>
                    <button x-on:click="open = false; $wire.closeEdit()"
                        class="p-2 rounded-xl hover:bg-hover transition">
                        <flux:icon name="x-mark" class="w-5 h-5 text-text-muted" />
                    </button>
                </div>

                {{-- Modal Body --}}
                <form wire:submit="saveGateway" class="p-6 space-y-6">
                    {{-- Gateway Name --}}
                    <div>
                        <x-ui.label value="{{ __('Gateway Name') }}" class="mb-1" />
                        <x-ui.input type="text" wire:model="editName" placeholder="{{ __('Gateway Name') }}" />
                        <x-ui.input-error :messages="$errors->get('editName')" />
                    </div>

                    {{-- Status & Mode row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Active toggle --}}
                        <div>
                            <x-ui.label value="{{ __('Active Status') }}" class="mb-2" />
                            <button type="button"
                                wire:click="$set('editIsActive', {{ $editIsActive ? 'false' : 'true' }})"
                                class="relative inline-flex h-8 w-14 shrink-0 rounded-full border-2 border-transparent cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 {{ $editIsActive ? 'bg-green-500' : 'bg-zinc-300 dark:bg-zinc-600' }}"
                                role="switch" aria-checked="{{ $editIsActive ? 'true' : 'false' }}">
                                <span
                                    class="pointer-events-none inline-block h-7 w-7 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $editIsActive ? 'translate-x-6' : 'translate-x-0' }}"></span>
                            </button>
                            <span class="ml-3 text-sm {{ $editIsActive ? 'text-green-500' : 'text-text-muted' }}">
                                {{ $editIsActive ? __('Enabled') : __('Disabled') }}
                            </span>
                        </div>

                        {{-- Mode select --}}
                        <div>
                            <x-ui.label value="{{ __('Mode') }}" class="mb-2" />
                            <select wire:model.live="editMode"
                                class="w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 transition duration-150 placeholder-zinc-400 focus:outline-none focus:ring-offset-0">
                                @foreach ($modeOptions as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </select>
                            <x-ui.input-error :messages="$errors->get('editMode')" />
                        </div>
                    </div>

                    @if (count($fields) > 0)
                        {{-- Live Credentials --}}
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <h4 class="text-sm font-semibold text-text-primary">{{ __('Live Credentials') }}</h4>
                            </div>
                            <div class="space-y-3 pl-4 border-l-2 border-green-500/20">
                                @foreach ($fields as $field)
                                    <div>
                                        <x-ui.label :value="$field['label']" class="mb-1" />
                                        <x-ui.input :type="$field['type']" wire:model="editLiveData.{{ $field['key'] }}"
                                            placeholder="{{ $field['label'] }}" />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Sandbox Credentials --}}
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <h4 class="text-sm font-semibold text-text-primary">{{ __('Sandbox Credentials') }}
                                </h4>
                            </div>
                            <div class="space-y-3 pl-4 border-l-2 border-amber-500/20">
                                @foreach ($fields as $field)
                                    <div>
                                        <x-ui.label :value="$field['label']" class="mb-1" />
                                        <x-ui.input :type="$field['type']" wire:model="editSandboxData.{{ $field['key'] }}"
                                            placeholder="{{ $field['label'] }} (Sandbox)" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Modal Footer --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                        <x-ui.button type="button" variant="tertiary" class="w-auto! py-2!"
                            x-on:click="open = false; $wire.closeEdit()">
                            <flux:icon name="x-circle"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                            {{ __('Cancel') }}
                        </x-ui.button>

                        <x-ui.button type="submit" variant="primary" class="w-auto! py-2!">
                            <span wire:loading.remove wire:target="saveGateway"
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                {{ __('Save Changes') }}
                            </span>
                            <span wire:loading wire:target="saveGateway"
                                class="text-text-btn-primary group-hover:text-text-btn-secondary">
                                {{ __('Saving...') }}
                            </span>
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</section>
