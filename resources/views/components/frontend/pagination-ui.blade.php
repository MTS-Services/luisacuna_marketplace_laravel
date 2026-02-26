{{--
    Reusable pagination component (Custom UI).
    Accepts ONLY pagination metadata—no item data.
    Props:
        pagination  (array: current_page, last_page, per_page, total, from, to)
        class       (optional)
        pageName    (optional, for Livewire named paginators)
        wireKey     (optional, unique key prefix when multiple paginators exist on one page)
--}}
@props([
    'pagination' => [],
    'class' => '',
    'pageName' => null,
    'wireKey' => 'pagination',
])

@php
    $pagination = is_array($pagination) ? $pagination : [];
    $current = (int) ($pagination['current_page'] ?? 1);
    $last = (int) ($pagination['last_page'] ?? 1);
    $last = max(1, $last);
    $start = max(4, $current - 1);
    $end = min($last - 3, $current + 1);
    $class = $class ?? '';
    $pageName = $pageName ?? null;
    $pageNameArg = $pageName ? ", '" . e($pageName) . "'" : '';
    $wireKeyBase = e($wireKey);
@endphp

@if ($last > 1)
    <div wire:key="{{ $wireKeyBase }}-wrapper" x-data="{
        loadingPage: null,
        init() {
            {{-- Reset loading state whenever Livewire finishes a request --}}
            this.$wire.$on('loading-done', () => this.loadingPage = null);
            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                succeed(({ snapshot, effect }) => {
                    this.loadingPage = null;
                });
            });
        },
        goto(page) {
            this.loadingPage = page;
            this.$wire.gotoPage(page{{ $pageNameArg }});
        },
        previous() {
            this.loadingPage = 'prev';
            this.$wire.previousPage({{ $pageName ? "'" . e($pageName) . "'" : '' }});
        },
        next() {
            this.loadingPage = 'next';
            this.$wire.nextPage({{ $pageName ? "'" . e($pageName) . "'" : '' }});
        }
    }"
        class="flex flex-wrap items-center justify-end mt-8 text-sm gap-2 mb-7 {{ $class }}">

        {{-- Previous --}}
        <div wire:key="{{ $wireKeyBase }}-prev" class="relative">
            <button @click="previous()" :disabled="{{ $current <= 1 ? 'true' : 'false' }}"
                class="px-3 md:px-4 py-2 text-text-primary shadow-2xl rounded-lg
                   hover:bg-bg-primary/60 transition-colors
                   disabled:opacity-50 disabled:cursor-not-allowed relative overflow-hidden">
                {{ __('Previous') }}
                {{-- Loading overlay --}}
                <span x-show="loadingPage === 'prev'" x-transition.opacity
                    class="absolute inset-0 flex items-center justify-center rounded-lg bg-zinc-700/60 backdrop-blur-[1px]">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                    </svg>
                </span>
            </button>
        </div>

        {{-- First 3 Pages --}}
        @for ($i = 1; $i <= min(3, $last); $i++)
            <div wire:key="{{ $wireKeyBase }}-page-{{ $i }}" class="relative">
                <button @click="goto({{ $i }})"
                    class="px-3 md:px-4 py-2 rounded-lg transition-colors relative overflow-hidden
                {{ $i == $current ? 'bg-zinc-500 text-text-primary font-semibold' : 'text-text-primary hover:bg-bg-primary/60' }}">
                    {{ $i }}
                    <span x-show="loadingPage === {{ $i }}" x-transition.opacity
                        class="absolute inset-0 flex items-center justify-center rounded-lg bg-zinc-700/60 backdrop-blur-[1px]">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                        </svg>
                    </span>
                </button>
            </div>
        @endfor

        {{-- Left Dots --}}
        @if ($start > 4)
            <span wire:key="{{ $wireKeyBase }}-dots-left" class="px-2 text-text-muted">...</span>
        @endif

        {{-- Middle Pages (Sliding) --}}
        @for ($i = $start; $i <= $end; $i++)
            <div wire:key="{{ $wireKeyBase }}-page-{{ $i }}" class="relative">
                <button @click="goto({{ $i }})"
                    class="px-3 md:px-4 py-2 rounded-lg transition-colors relative overflow-hidden
                {{ $i == $current ? 'bg-zinc-500 text-text-primary font-semibold' : 'text-text-primary hover:bg-bg-primary/60' }}">
                    {{ $i }}
                    <span x-show="loadingPage === {{ $i }}" x-transition.opacity
                        class="absolute inset-0 flex items-center justify-center rounded-lg bg-zinc-700/60 backdrop-blur-[1px]">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                        </svg>
                    </span>
                </button>
            </div>
        @endfor

        {{-- Right Dots --}}
        @if ($end < $last - 3)
            <span wire:key="{{ $wireKeyBase }}-dots-right" class="px-2 text-text-muted">...</span>
        @endif

        {{-- Last 3 Pages --}}
        @for ($i = max($last - 2, 4); $i <= $last; $i++)
            <div wire:key="{{ $wireKeyBase }}-page-{{ $i }}" class="relative">
                <button @click="goto({{ $i }})"
                    class="px-3 md:px-4 py-2 rounded-lg transition-colors relative overflow-hidden
                {{ $i == $current ? 'bg-zinc-500 text-text-primary font-semibold' : 'text-text-primary hover:bg-bg-primary/60' }}">
                    {{ $i }}
                    <span x-show="loadingPage === {{ $i }}" x-transition.opacity
                        class="absolute inset-0 flex items-center justify-center rounded-lg bg-zinc-700/60 backdrop-blur-[1px]">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                        </svg>
                    </span>
                </button>
            </div>
        @endfor

        {{-- Next --}}
        <div wire:key="{{ $wireKeyBase }}-next" class="relative">
            <button @click="next()" :disabled="{{ $current >= $last ? 'true' : 'false' }}"
                class="px-3 md:px-4 py-2 text-text-primary shadow-2xl rounded-lg
                   hover:bg-bg-primary/60 transition-colors
                   disabled:opacity-50 disabled:cursor-not-allowed relative overflow-hidden">
                {{ __('Next') }}
                <span x-show="loadingPage === 'next'" x-transition.opacity
                    class="absolute inset-0 flex items-center justify-center rounded-lg bg-zinc-700/60 backdrop-blur-[1px]">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                    </svg>
                </span>
            </button>
        </div>

    </div>
@endif
