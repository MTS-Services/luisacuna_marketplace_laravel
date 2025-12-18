@props(['pagination' => []])

@if (isset($pagination['last_page']) && $pagination['last_page'] > 1)
    <div class="flex flex-wrap items-center justify-end mt-8 text-sm gap-2">

        {{-- Previous --}}
        <button
            wire:click="previousPage"
            @disabled($pagination['current_page'] <= 1)
            class="px-3 md:px-4 py-2 text-text-white shadow-2xl rounded-lg
                   hover:bg-bg-primary/60 transition-colors
                   disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Previous') }}
        </button>

        {{-- First 3 Pages --}}
        @for ($i = 1; $i <= min(3, $pagination['last_page']); $i++)
            <button
                wire:click="gotoPage({{ $i }})"
                class="px-3 md:px-4 py-2 rounded-lg text-sm transition-colors
                    {{ $i == $pagination['current_page']
                        ? 'bg-zinc-500 text-white font-semibold shadow-lg shadow-primary-900/50'
                        : 'text-text-white shadow-2xl hover:bg-bg-primary/60' }}">
                {{ $i }}
            </button>
        @endfor

        {{-- Dots --}}
        @if ($pagination['last_page'] > 5)
            <span class="px-2 text-text-muted">...</span>
        @endif

        {{-- Last 2 Pages --}}
        @for ($i = max($pagination['last_page'] - 1, 4); $i <= $pagination['last_page']; $i++)
            <button
                wire:click="gotoPage({{ $i }})"
                class="px-3 md:px-4 py-2 rounded-lg text-sm transition-colors
                    {{ $i == $pagination['current_page']
                        ? 'bg-zinc-500 text-white font-semibold shadow-lg shadow-primary-900/50'
                        : 'text-text-white shadow-2xl hover:bg-bg-primary/60' }}">
                {{ $i }}
            </button>
        @endfor

        {{-- Next --}}
        <button
            wire:click="nextPage"
            @disabled($pagination['current_page'] >= $pagination['last_page'])
            class="px-3 md:px-4 py-2 text-text-white shadow-2xl rounded-lg
                   hover:bg-bg-primary/60 transition-colors
                   disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Next') }}
        </button>

    </div>
@endif
