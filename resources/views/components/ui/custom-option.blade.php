@props([
    'value' => null,
    'label' => '',
    'disabled' => false,
])

<li 
    @click="!{{ $disabled ? 'true' : 'false' }} && selectOption({{ json_encode($value) }}, {{ json_encode($label) }})"
    data-option-value="{{ $value }}"
    data-option-label="{{ $label }}"
    class="cursor-pointer px-4 py-2 text-sm transition-colors rounded"
    :class="{
        'bg-bg-secondary text-text-primary': selectedValue == {{ json_encode($value) }},
        'hover:text-text-secondary hover:bg-bg-hover': !{{ $disabled ? 'true' : 'false' }} && selectedValue != {{ json_encode($value) }},
        'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
    }">
    {{ $label }}
</li>