@props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'actionStyle' => 'icons',
    'emptyMessage' => 'No records found.',
])

<div class="bg-bg-primary">
    {{-- Desktop Table View --}}
    <div class="hidden md:block overflow-x-visible"> {{-- Changed from overflow-x-auto to visible to prevent clipping --}}
        <table class="w-full text-left table-auto border-separate border-spacing-0">
            <thead>
                <tr class="text-sm text-text-white bg-bg-secondary/80 uppercase tracking-wider">
                    @foreach ($columns as $column)
                        <th
                            class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                            @if (isset($column['sortable']) && $column['sortable'])
                                <div class="flex items-center gap-1">
                                    {{ __($column['label']) }}
                                    <div class="flex flex-col">
                                        <x-phosphor-caret-up-fill class="w-3 h-3 fill-zinc-500" />
                                        <x-phosphor-caret-down-fill class='w-3 h-3' />
                                    </div>
                                </div>
                            @else
                                {{ __($column['label']) }}
                            @endif
                        </th>
                    @endforeach

                    @if (count($actions) > 0)
                        <th
                            class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                            {{ __('Actions') }}
                        </th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-800">
                @forelse ($data as $index => $item)
                    <tr
                        class="{{ $index % 2 === 0 ? 'bg-bg-hover/50' : 'bg-bg-secondary/50' }} hover:bg-bg-hover transition-colors">
                        @foreach ($columns as $column)
                            <td class="px-2 sm:px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">
                                @if (isset($column['format']) && is_callable($column['format']))
                                    {!! $column['format']($item) !!}
                                @elseif (isset($column['badge']) && $column['badge'])
                                    @php
                                        $value = data_get($item, $column['key']);
                                        $badgeColors = $column['badgeColors'] ?? [
                                            'active' => 'bg-pink-500',
                                            'paused' => 'bg-red-500',
                                            'inactive' => 'bg-gray-500',
                                            'in progress' => 'bg-emerald-500',
                                        ];
                                        $badgeColor = $badgeColors[strtolower($value)] ?? 'bg-gray-500';
                                    @endphp
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeColor }} text-white whitespace-nowrap inline-block">
                                        {{ ucfirst($value) }}
                                    </span>
                                @else
                                    <span class="text-text-white text-xs sm:text-sm">
                                        {{ data_get($item, $column['key']) ?? '-' }}
                                    </span>
                                @endif
                            </td>
                        @endforeach

                        @if (count($actions) > 0)
                            {{-- Added 'relative' and 'z-index' logic to the TD --}}
                            <td class="px-2 sm:px-4 md:px-6 py-3 relative" x-data="{ open: false }">
                                @if ($actionStyle === 'dropdown')
                                    @php
                                        $activeActions = collect($actions)->filter(
                                            fn($action) => isset($action['condition'])
                                                ? $action['condition']($item)
                                                : true,
                                        );
                                    @endphp

                                    @if ($activeActions->isNotEmpty())
                                        <div class="relative">
                                            <button type="button" @click="open = !open" @click.outside="open = false"
                                                class="cursor-pointer p-2 rounded-lg hover:bg-zinc-700 transition-colors text-text-muted hover:text-text-white">
                                                <x-phosphor-gear-six class="w-5 h-5" />
                                            </button>

                                            {{-- Dropdown Menu --}}
                                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95" {{-- Added 'top-full' and higher z-index --}}
                                                class="absolute right-0 top-full z-[100] mt-1 w-48 rounded-lg bg-bg-primary border border-zinc-700 shadow-2xl py-2"
                                                x-cloak>
                                                @foreach ($actions as $action)
                                                    @php
                                                        $rawValue = data_get($item, $action['param'] ?? 'id');
                                                        $actionValue = !empty($action['encrypt'])
                                                            ? encrypt($rawValue)
                                                            : $rawValue;
                                                        $isActive = isset($action['condition'])
                                                            ? $action['condition']($item)
                                                            : true;
                                                        $componentName =
                                                            'phosphor-' . ($action['icon'] ?? 'question-mark');
                                                    @endphp
                                                    @if ($isActive)
                                                        @if (isset($action['method']))
                                                            <button type="button"
                                                                wire:click="{{ $action['method'] }}({{ is_numeric($actionValue) ? $actionValue : "'$actionValue'" }})"
                                                                @click="open = false"
                                                                class="w-full flex items-center gap-3 px-4 py-2 text-sm text-text-muted hover:text-text-white hover:bg-zinc-700/60 transition-colors">
                                                                <x-dynamic-component :component="$componentName"
                                                                    class="w-4 h-4 {{ $action['hoverClass'] ?? '' }}" />
                                                                <span>{{ __($action['label']) }}</span>
                                                            </button>
                                                        @elseif (isset($action['route']))
                                                            <a href="{{ route($action['route'], $actionValue) }}"
                                                                wire:navigate
                                                                class="flex items-center gap-3 px-4 py-2 text-sm text-text-muted hover:text-text-white hover:bg-zinc-700/60 transition-colors">
                                                                <x-dynamic-component :component="$componentName"
                                                                    class="w-4 h-4 {{ $action['hoverClass'] ?? '' }}" />
                                                                <span>{{ __($action['label']) }}</span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    {{-- Standard Icon Style --}}
                                    <div class="flex items-center gap-3 text-text-muted">
                                        {{-- ... (Your existing Icon Logic) ... --}}
                                    </div>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (count($actions) > 0 ? 1 : 0) }}"
                            class="px-4 py-12 text-center text-text-muted">
                            <p class="text-lg font-medium">{{ __($emptyMessage) }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="block md:hidden space-y-4 p-4">
        @forelse ($data as $item)
            <div class="bg-bg-secondary rounded-xl shadow-lg border border-zinc-800 overflow-hidden">
                <div class="p-4 space-y-4">
                    {{-- Header Row --}}
                    <div class="flex justify-between items-start">
                        <div>
                            @if (isset($columns[0]))
                                <div class="text-text-white font-bold text-base">
                                    {!! isset($columns[0]['format']) ? $columns[0]['format']($item) : data_get($item, $columns[0]['key']) ?? '-' !!}
                                </div>
                            @endif
                        </div>
                        {{-- Find and Show Status Badge if exists --}}
                        @foreach ($columns as $column)
                            @if (isset($column['badge']) && $column['badge'])
                                @php
                                    $val = data_get($item, $column['key']);
                                    $bColor =
                                        ($column['badgeColors'] ?? ['active' => 'bg-pink-500'])[strtolower($val)] ??
                                        'bg-gray-500';
                                @endphp
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $bColor }} text-white">
                                    {{ ucfirst($val) }}
                                </span>
                                @break
                            @endif
                        @endforeach
                    </div>

                    {{-- Data Grid --}}
                    <div class="grid grid-cols-2 gap-y-3 pt-2 border-t border-zinc-800/50">
                        @foreach ($columns as $index => $column)
                            @if ($index > 0 && !(isset($column['badge']) && $column['badge']))
                                <div class="text-xs text-text-muted uppercase tracking-tight">
                                    {{ __($column['label']) }}</div>
                                <div class="text-xs text-text-white font-medium text-right">
                                    {!! isset($column['format']) ? $column['format']($item) : data_get($item, $column['key']) ?? '-' !!}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Actions Button (Full Width Mobile) --}}
                    @if (count($actions) > 0)
                        <div x-data="{ open: false }" class="mt-4">
                            <button @click="open = !open"
                                class="w-full bg-bg-hover py-2.5 rounded-lg text-sm font-medium text-text-white flex items-center justify-center gap-2 border border-zinc-700/50">
                                <x-phosphor-dots-three-outline-fill class="w-5 h-5" />
                                {{ __('Manage Order') }}
                            </button>

                            <div x-show="open" x-collapse x-cloak
                                class="mt-2 bg-bg-primary rounded-lg border border-zinc-700 overflow-hidden shadow-xl">
                                @foreach ($actions as $action)
                                    @php
                                        $rawValue = data_get($item, $action['param'] ?? 'id');
                                        $actionValue = !empty($action['encrypt']) ? encrypt($rawValue) : $rawValue;
                                        $isActive = isset($action['condition']) ? $action['condition']($item) : true;
                                        $componentName = 'phosphor-' . ($action['icon'] ?? 'question-mark');
                                    @endphp

                                    @if ($isActive)
                                        {{-- Check for Method --}}
                                        @if (isset($action['method']))
                                            <button type="button"
                                                wire:click="{{ $action['method'] }}({{ is_numeric($actionValue) ? $actionValue : "'$actionValue'" }})"
                                                @click="open = false"
                                                  class="w-full flex items-center gap-3 px-4 py-3 text-sm text-text-muted border-b border-zinc-800 last:border-0 hover:bg-zinc-800 transition-colors">
                                                <x-dynamic-component :component="$componentName"
                                                    class="w-5 h-5 {{ $action['hoverClass'] ?? '' }}" />
                                                <span>{{ __($action['label'] ?? '') }}</span>
                                            </button>

                                            {{-- Check for Route --}}
                                        @elseif (isset($action['route']))
                                            <a href="{{ route($action['route'], $actionValue) }}" wire:navigate
                                                @click="open = false"
                                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-text-muted border-b border-zinc-800 last:border-0 hover:bg-zinc-800 transition-colors">
                                                <x-dynamic-component :component="$componentName"
                                                    class="w-5 h-5 {{ $action['hoverClass'] ?? '' }}" />
                                                <span>{{ __($action['label'] ?? '') }}</span>
                                            </a>

                                            {{-- Check for Href --}}
                                        @elseif (isset($action['href']))
                                            <a href="{{ $action['href'] }}"
                                                target="{{ $action['target'] ?? '_self' }}" @click="open = false"
                                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-text-muted border-b border-zinc-800 last:border-0 hover:bg-zinc-800 transition-colors">
                                                <x-dynamic-component :component="$componentName"
                                                    class="w-5 h-5 {{ $action['hoverClass'] ?? '' }}" />
                                                <span>{{ __($action['label'] ?? '') }}</span>
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-text-muted">{{ __($emptyMessage) }}</div>
        @endforelse
    </div>
</div>
