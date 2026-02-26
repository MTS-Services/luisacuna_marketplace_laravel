@props([
    'value' => null,
    'label' => '',
    'disabled' => false,
])

<li 
    data-option-value="{{ $value }}"
    data-option-label="{{ $label }}"
    @if($disabled) data-disabled @endif
    class="cursor-pointer px-4 py-2 text-sm transition-colors rounded"
    :class="{
        'bg-bg-secondary text-text-primary': selectedValue == {{ json_encode($value) }},
        'hover:text-text-secondary hover:bg-bg-hover': !{{ $disabled ? 'true' : 'false' }} && selectedValue != {{ json_encode($value) }},
        'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
    }">
    {{ $label }}
</li>