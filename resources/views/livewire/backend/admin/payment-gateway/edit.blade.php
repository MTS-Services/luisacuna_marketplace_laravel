<section class="space-y-6">
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span
                    class="w-9 h-9 rounded-xl glass-card flex items-center justify-center shadow-shadow-primary shrink-0">
                    <flux:icon name="cog-6-tooth" class="w-5 h-5 text-pink-400" />
                </span>
                <div>
                    <h2 class="text-base font-bold text-text-white leading-tight">
                        @if ($this->currentGateway)
                            {{ __('Configure') }} {{ $this->currentGateway->name }}
                        @else
                            {{ __('Configure Gateway') }}
                        @endif
                    </h2>
                    <p class="text-xs text-text-muted">
                        @if ($this->currentGateway)
                            <span class="font-mono">{{ $this->currentGateway->slug }}</span>
                        @else
                            {{ __('Edit credentials and settings') }}
                        @endif
                    </p>
                </div>
            </div>
            <x-ui.button href="{{ route('admin.gi.pay-g.index') }}" class="w-auto! py-2!">
                <flux:icon name="arrow-left"
                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                {{ __('Back') }}
            </x-ui.button>
        </div>
    </div>

    {{-- Form --}}
    <div class="glass-card rounded-2xl p-6">
        <form wire:submit="saveGateway" class="space-y-6">
            {{-- Name + Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2 space-y-1.5">
                    <x-ui.label value="{{ __('Gateway Name') }}" />
                    <x-ui.input type="text" wire:model="editName" placeholder="{{ __('Display name') }}" />
                    <x-ui.input-error :messages="$errors->get('editName')" />
                </div>
                <div class="space-y-1.5">
                    <x-ui.label value="{{ __('Status') }}" />
                    <button type="button" wire:click="$set('editIsActive', {{ $editIsActive ? 'false' : 'true' }})"
                        class="flex items-center gap-3 w-full px-3 py-2 rounded-xl border border-white/10 hover:border-white/20 bg-white/5 hover:bg-white/[0.07] transition-all duration-200">
                        <div
                            class="relative inline-flex h-5 w-9 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 {{ $editIsActive ? 'bg-green-500' : 'bg-zinc-600' }}">
                            <span
                                class="inline-block h-4 w-4 rounded-full bg-white shadow transition duration-200 {{ $editIsActive ? 'translate-x-4' : 'translate-x-0' }}"></span>
                        </div>
                        <span class="text-sm font-medium {{ $editIsActive ? 'text-green-400' : 'text-text-muted' }}">
                            {{ $editIsActive ? __('Active') : __('Inactive') }}
                        </span>
                    </button>
                </div>
            </div>

            {{-- Gateway Icon --}}
            <div class="space-y-1.5">
                <x-ui.file-input wire:model="editIcon" label="{{ __('Gateway Icon') }}" accept="image/*"
                    :existingFiles="$this->currentGateway && $this->currentGateway->icon
                        ? [$this->currentGateway->icon]
                        : []" removeModel="editRemoveIcon" :error="$errors->first('editIcon')" hint="{{ __('Max: 2MB') }}" />
            </div>

            {{-- Mode selector --}}
            <div class="space-y-1.5">
                <x-ui.label value="{{ __('Operating Mode') }}" />
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($this->modeOptions as $option)
                        <button type="button" wire:click="$set('editMode', '{{ $option['value'] }}')"
                            class="flex items-center gap-2.5 px-4 py-3 rounded-xl border text-sm font-medium transition-all duration-200
                            {{ $editMode === $option['value'] ? ($option['value'] === 'live' ? 'border-green-500/50 bg-green-500/10 text-green-400' : 'border-amber-500/50 bg-amber-500/10 text-amber-400') : 'border-violet-500/10 text-text-muted hover:border-violet-500/20 hover:bg-white/5' }}">
                            <span
                                class="w-2 h-2 rounded-full {{ $option['value'] === 'live' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                            {{ $option['label'] }}
                            @if ($editMode === $option['value'])
                                <flux:icon name="check" class="w-4 h-4 ml-auto" />
                            @endif
                        </button>
                    @endforeach
                </div>
                <x-ui.input-error :messages="$errors->get('editMode')" />
            </div>

            {{-- Credentials --}}
            @if (count($this->currentFields) > 0)
                <div class="space-y-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <h4 class="text-sm font-semibold text-text-primary">{{ __('Live Credentials') }}</h4>
                            <span class="text-xs text-text-muted ml-1">{{ __('Used when mode is Live') }}</span>
                        </div>
                        <div class="space-y-3 pl-4 border-l-2 border-green-500/20">
                            @foreach ($this->currentFields as $field)
                                <div class="space-y-1.5">
                                    <x-ui.label :value="$field['label']" />
                                    <x-ui.input :type="$field['type']" wire:model="editLiveData.{{ $field['key'] }}"
                                        :placeholder="$field['label']" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <h4 class="text-sm font-semibold text-text-primary">{{ __('Sandbox Credentials') }}</h4>
                            <span class="text-xs text-text-muted ml-1">{{ __('Used when mode is Sandbox') }}</span>
                        </div>
                        <div class="space-y-3 pl-4 border-l-2 border-amber-500/20">
                            @foreach ($this->currentFields as $field)
                                <div class="space-y-1.5">
                                    <x-ui.label :value="$field['label']" />
                                    <x-ui.input :type="$field['type']" wire:model="editSandboxData.{{ $field['key'] }}"
                                        :placeholder="$field['label'] . ' (Sandbox)'" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 p-4 rounded-xl border border-white/10 bg-white/5">
                    <flux:icon name="check-circle" class="w-5 h-5 text-text-muted shrink-0" />
                    <p class="text-sm text-text-muted">
                        {{ __('This gateway requires no external credentials.') }}
                    </p>
                </div>
            @endif

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-white/10">
                <x-ui.button type="button" variant="tertiary" class="w-auto! py-2!"
                    href="{{ route('admin.gi.pay-g.index') }}">
                    <flux:icon name="x-mark"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Cancel') }}
                </x-ui.button>

                {{-- during filed update disabled the button. when all fields are updated, enable the button. --}}
                <x-ui.button type="submit" variant="primary" class="w-auto! py-2!" wire:loading.attr="disabled"
                    wire:target="saveGateway, editName, editMode, editIsActive, editIcon, editRemoveIcon, editLiveData, editSandboxData">
                    <flux:icon name="check"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                        wire:loading.remove
                        wire:target="saveGateway, editName, editMode, editIsActive, editIcon, editRemoveIcon, editLiveData, editSandboxData" />
                    <span wire:loading.remove
                        wire:target="saveGateway, editName, editMode, editIsActive, editIcon, editRemoveIcon, editLiveData, editSandboxData"
                        class="text-text-btn-primary group-hover:text-text-secondary">
                        {{ __('Save Changes') }}
                    </span>
                    <flux:icon name="arrow-path"
                        class="w-4 h-4 animate-spin stroke-text-btn-primary group-hover:stroke-text-btn-secondary"
                        wire:loading
                        wire:target="saveGateway, editName, editMode, editIsActive, editIcon, editRemoveIcon, editLiveData, editSandboxData" />
                    <span wire:loading wire:target="saveGateway"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Saving…') }}
                    </span>
                    <span wire:loading
                        wire:target="editName, editMode, editIsActive, editIcon, editRemoveIcon, editLiveData, editSandboxData"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">
                        {{ __('Updating...') }}
                    </span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
