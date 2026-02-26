@props([
    'label' => 'Select Option',
    'onChange' => null,
    'options' => [],
    'wireModel' => null,
    'dropDownClasses' => '',
    'wireLive' => false,
    'disabled' => false,
])

<div class="relative w-full" wire:key="custom-select-{{ $wireModel ?? 'default' }}" x-data="{
    open: false,
    justOpened: false,
    selectedOption: @js($label),
    selectedValue: null,
    options: [],
    disabled: @js($disabled),

    init() {
        this.$nextTick(() => {
            this.buildOptionsMap();
            this.syncFromWire();
        });

        @if($wireModel)
        Livewire.hook('commit', ({ component, commit, respond }) => {
            this.$nextTick(() => {
                this.buildOptionsMap();
                this.syncFromWire();
            });
        });
        @endif
    },

    buildOptionsMap() {
        this.options = [];
        const optionElements = this.$el.querySelectorAll('[data-option-value]');
        optionElements.forEach(el => {
            this.options.push({
                value: el.getAttribute('data-option-value'),
                label: el.getAttribute('data-option-label')
            });
        });
    },

    syncFromWire() {
        @if($wireModel)
        const wireValue = @this.get('{{ $wireModel }}');
        if (wireValue !== undefined && wireValue !== this.selectedValue) {
            this.selectedValue = wireValue;
            this.updateSelectedLabel(wireValue);
        }
        @endif
    },

    updateSelectedLabel(value) {
        if (value === null || value === '' || value === undefined) {
            this.selectedOption = @js($label);
            return;
        }
        const option = this.options.find(opt => opt.value == value);
        if (option) {
            this.selectedOption = option.label;
        }
    },

    selectOption(value, label) {
        if (this.disabled) return;

        this.selectedValue = value;
        this.selectedOption = label;
        this.open = false;

        @if($wireModel)
        // @this.set() with the second arg true fires a live network
        // request immediately, which is what wire:loading/wire:target
        // listens for automatically — no hidden button trick needed.
        @this.set('{{ $wireModel }}', value, @js($wireLive));
        @endif

        @if($onChange)
        if (typeof window['{{ $onChange }}'] === 'function') {
            window['{{ $onChange }}'](value);
        }
        @endif

        this.$dispatch('select-changed', { value: value, label: label });
    },

    toggle() {
        if (!this.disabled) {
            const wasOpen = this.open;
            this.open = !this.open;
            if (this.open && !wasOpen) {
                this.justOpened = true;
                setTimeout(() => { this.justOpened = false; }, 150);
            }
        }
    },

    onMenuClick(event) {
        const el = event.target.closest('[data-option-value]');
        if (el && !el.hasAttribute('data-disabled') && !this.disabled) {
            const value = el.getAttribute('data-option-value');
            const label = el.getAttribute('data-option-label');
            this.selectOption(value, label);
        }
    }
}"
    @click.away="if (!justOpened) open = false"
    @select-updated.window="
        if ($event.detail.wireModel === '{{ $wireModel }}') {
            selectedValue = $event.detail.value;
            updateSelectedLabel($event.detail.value);
        }
    ">

    {{-- Dropdown Trigger --}}
    <div @click="toggle()" {!! $attributes->merge([
        'class' =>
            'flex justify-between bg-bg-primary items-center px-3 py-2 cursor-pointer border border-zinc-700 rounded-full w-full transition-all',
    ]) !!}
        :class="{
            'opacity-50 cursor-not-allowed': disabled,
            'hover:border-zinc-600': !disabled
        }">
        <span x-text="selectedOption" class="text-sm"></span>
        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    {{-- Dropdown Menu --}}
    <div @click.stop="onMenuClick($event)" x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150 transform"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
        class="absolute top-[110%] left-0 w-full rounded bg-bg-primary z-50 overflow-hidden shadow-lg border border-zinc-700 {{ $dropDownClasses }}"
        style="display: none;">
        <ul class="list-none overflow-y-auto max-h-[50vh] py-1">
            {{ $slot }}
        </ul>
    </div>

</div>
