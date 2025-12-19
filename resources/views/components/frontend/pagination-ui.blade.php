@props(['pagination' => []])

@php
    $current = $pagination['current_page'];
    $last = $pagination['last_page'];

    $start = max(4, $current - 1);
    $end   = min($last - 3, $current + 1);
@endphp

@if ($last > 1)
<div class="flex flex-wrap items-center justify-end mt-8 text-sm gap-2">

    {{-- Previous --}}
    <button
        wire:click="previousPage"
        @disabled($current <= 1)
        class="px-3 md:px-4 py-2 text-text-white shadow-2xl rounded-lg
               hover:bg-bg-primary/60 transition-colors
               disabled:opacity-50 disabled:cursor-not-allowed">
        {{ __('Previous') }}
    </button>

    {{-- First 3 Pages --}}
    @for ($i = 1; $i <= min(3, $last); $i++)
        <button
            wire:click="gotoPage({{ $i }})"
            class="px-3 md:px-4 py-2 rounded-lg transition-colors
            {{ $i == $current
                ? 'bg-zinc-500 text-white font-semibold'
                : 'text-text-white hover:bg-bg-primary/60' }}">
            {{ $i }}
        </button>
    @endfor

    {{-- Left Dots --}}
    @if ($start > 4)
        <span class="px-2 text-text-muted">...</span>
    @endif

    {{-- Middle Pages (Sliding) --}}
    @for ($i = $start; $i <= $end; $i++)
        <button
            wire:click="gotoPage({{ $i }})"
            class="px-3 md:px-4 py-2 rounded-lg transition-colors
            {{ $i == $current
                ? 'bg-zinc-500 text-white font-semibold'
                : 'text-text-white hover:bg-bg-primary/60' }}">
            {{ $i }}
        </button>
    @endfor

    {{-- Right Dots --}}
    @if ($end < $last - 3)
        <span class="px-2 text-text-muted">...</span>
    @endif

    {{-- Last 3 Pages --}}
    @for ($i = max($last - 2, 4); $i <= $last; $i++)
        <button
            wire:click="gotoPage({{ $i }})"
            class="px-3 md:px-4 py-2 rounded-lg transition-colors
            {{ $i == $current
                ? 'bg-zinc-500 text-white font-semibold'
                : 'text-text-white hover:bg-bg-primary/60' }}">
            {{ $i }}
        </button>
    @endfor

    {{-- Next --}}
    <button
        wire:click="nextPage"
        @disabled($current >= $last)
        class="px-3 md:px-4 py-2 text-text-white shadow-2xl rounded-lg
               hover:bg-bg-primary/60 transition-colors
               disabled:opacity-50 disabled:cursor-not-allowed">
        {{ __('Next') }}
    </button>

</div>
@endif
