@props([
    'value' => null,
    'label' => null
])

<li 
    @click="selectOption(@js($value), @js($label))"
    {!! $attributes->merge(['class' => 'py-2 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150']) !!}
>
    {{ $label }}
</li>