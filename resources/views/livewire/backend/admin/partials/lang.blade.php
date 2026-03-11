<flux:dropdown x-data align="end">
    <flux:button variant="subtle" square class="group" aria-label="{{ __('Language') }}">
        <span>{{ strtoupper($this->selectedLangLocale) }}</span>
    </flux:button>

    <flux:menu>
        @foreach ($this->languages as $language)
            <flux:menu.item
                wire:click="switchLocale('{{ $language->locale }}')"
                wire:loading.attr="disabled"
            >
                {{ $language->native_name }} ({{ strtoupper($language->locale) }})
            </flux:menu.item>
        @endforeach
    </flux:menu>
</flux:dropdown>
