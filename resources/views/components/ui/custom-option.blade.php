@props([
    'value' => null,
    'label' => null
])

<li 
    @click="
        selectedOption = @js($label); 
        $wire.set(wireModel, @js($value)); 
        open = false; 
        if(onChange) $wire.call(onChange)
    "
    {!! $attributes->merge(['class' => 'py-2 px-4 text-text-primary bg-bg-secondary cursor-pointer hover:text-text-secondary hover:bg-bg-hover rounded transition-colors duration-150']) !!}
>
    {{ $label }}
</li>