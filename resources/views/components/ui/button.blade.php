@props([
    'href' => null,
    'disabled' => false,
    'type' => 'button',

    'target' => '_self',
    'variant' => 'primary',
    'button' => false,
    'wire' => true,
    'permission' => null,
])

@php
    $variantClasses = [
        'primary' =>
            'bg-zinc-500 px-4 md:px-6 py-2 md:py-4 text-text-btn-primary hover:text-text-btn-secondary hover:bg-zinc-50 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500',
        'secondary' =>
            'bg-zinc-50 px-4 md:px-6 py-2 md:py-4 text-text-btn-secondary hover:text-text-btn-primary hover:bg-zinc-500 border border-zinc-500 focus:outline-none focus:ring focus:ring-pink-500',
        'tertiary' =>
            'bg-pink-500 px-4 md:px-6 py-2 md:py-4 text-text-btn-primary hover:text-text-btn-tertiary hover:bg-pink-50 border border-pink-500 focus:outline-none focus:ring focus:ring-zinc-500',
        'link' =>
            'bg-transparent px-4 md:px-6 py-2 md:py-4 text-text-btn-primary hover:text-text-btn-secondary/90 focus:outline-none focus:ring focus:ring-pink-500',
    ];
@endphp

@if (!empty($permission))
    @if (Auth::user()->can($permission))
        @if ($href != 'javascript:void(0)' || $href != '' || $href != null || $href != undefined || $href != '#')
            <a href="{{ $href }}" target="{{ $target }}" {{ $disabled ? 'disabled' : '' }}
                {{ $wire ? 'wire:navigate' : '' }} {!! $attributes->merge([
                    'class' => "{$variantClasses[$variant]} font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out group",
                ]) !!}>
                {{ $slot }}
            </a>
        @else
            <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
                'class' => "{$variantClasses[$variant]} font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out group",
            ]) !!}>
                {{ $slot }}
            </button>
        @endif
    @endif
@else
    @if ($href != 'javascript:void(0)' || $href != '' || $href != null || $href != undefined || $href != '#')
        <a href="{{ $href }}" target="{{ $target }}" {{ $disabled ? 'disabled' : '' }}
            {{ $wire ? 'wire:navigate' : '' }} {!! $attributes->merge([
                'class' => "{$variantClasses[$variant]} font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out group",
            ]) !!}>
            {{ $slot }}
        </a>
    @else
        <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => "{$variantClasses[$variant]} font-medium text-base w-full rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out group",
        ]) !!}>
            {{ $slot }}
        </button>
    @endif
@endif
