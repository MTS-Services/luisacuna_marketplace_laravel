@props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'emptyMessage' => 'No records found.',
])

<div class="bg-bg-primary">
    {{-- Desktop Table View --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left table-auto border-separate border-spacing-0">
            <thead>
                <tr class="text-sm text-text-white bg-bg-secondary/80! uppercase tracking-wider">
                    @foreach ($columns as $column)
                        <th
                            class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                            @if (isset($column['sortable']) && $column['sortable'])
                                <div class="flex items-center gap-1">
                                    {{ __($column['label']) }}
                                    <div>
                                        <x-phosphor-caret-up-fill class="w-4 h-4 fill-zinc-500" />
                                        <x-phosphor-caret-down-fill class='w-4 h-4' />
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
                                        ];
                                        $badgeColor = $badgeColors[strtolower($value)] ?? 'bg-gray-500';
                                    @endphp
                                    <span
                                        class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full {{ $badgeColor }} text-white whitespace-nowrap inline-block">
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
                            <td class="px-2 sm:px-4 md:px-6 py-3">
                                <div class="flex items-center gap-3 text-text-muted">
                                    @foreach ($actions as $action)
                                    
                                        @php
                                            $rawValue = data_get($item, $action['param'] ?? 'id');
                                            $actionValue =!empty($action['encrypt']) && $action['encrypt'] ? encrypt($rawValue) : $rawValue;
                                            $isActive = isset($action['condition'])
                                                ? $action['condition']($item)
                                                : true;
                                            $iconName = $action['icon'] ?? 'question-mark';
                                            $componentName = 'phosphor-' . $iconName;
                                        @endphp

                                        @if ($isActive)
                                            @if (isset($action['method']))
                                                <button type="button"
                                                    wire:click="{{ $action['method'] }}({{ is_numeric($actionValue) ? $actionValue : "'{$actionValue}'" }})"
                                                    class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                                    title="{{ $action['label'] ?? '' }}">
                                                    <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                                </button>
                                            @elseif (isset($action['route']))
                                                <a href="{{ route($action['route'], $actionValue) }}" wire:navigate
                                                    class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                                    title="{{ $action['label'] ?? '' }}">
                                                    <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                                </a>
                                            @elseif (isset($action['href']))
                                                <a href="{{ $action['href'] }}"
                                                    target="{{ $action['target'] ?? '_self' }}"
                                                    class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                                    title="{{ $action['label'] ?? '' }}">
                                                    <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (count($actions) > 0 ? 1 : 0) }}"
                            class="px-4 py-12 text-center text-text-muted">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-12 h-12 text-zinc-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium">{{ $emptyMessage }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="block md:hidden overflow-x-auto space-y-4 p-4">
        @forelse ($data as $item)
            <div class="bg-bg-secondary rounded-xl shadow-lg overflow-hidden p-4">
                {{-- Card Header with Status Badge --}}
                <div class="bg-bg-optional p-4 rounded-xl">
                    {{-- Title/First Column --}}
                    <div class="mb-2">
                        @if (isset($columns[0]))
                            @if (isset($columns[0]['format']) && is_callable($columns[0]['format']))
                                {!! $columns[0]['format']($item) !!}
                            @else
                                <div class="text-text-white font-medium">
                                    {{ data_get($item, $columns[0]['key']) ?? '-' }}
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Status Badge --}}
                    @foreach ($columns as $column)
                        @if (isset($column['badge']) && $column['badge'])
                            @php
                                $value = data_get($item, $column['key']);
                                $badgeColors = $column['badgeColors'] ?? [
                                    'active' => 'bg-pink-500',
                                    'paused' => 'bg-red-500',
                                    'inactive' => 'bg-gray-500',
                                    'completed' => 'bg-pink-500',
                                ];
                                $badgeColor = $badgeColors[strtolower($value)] ?? 'bg-gray-500';
                            @endphp
                            <span
                                class="px-3 ml-10 py-1 text-xs font-semibold rounded-full {{ $badgeColor }} text-white whitespace-nowrap inline-block">
                                {{ ucfirst($value) }}
                            </span>
                            @break
                        @endif
                    @endforeach
                </div>

                {{-- Card Body with Data --}}
                <div class="p-4 space-y-3">
                    @foreach ($columns as $index => $column)
                        @if (
                            $index > 0 &&
                                (!isset($column['hideOnMobile']) || !$column['hideOnMobile']) &&
                                (!isset($column['badge']) || !$column['badge']))
                            <div class="flex justify-between items-start">
                                <span class="text-text-muted text-sm font-medium">
                                    {{ __($column['label']) }}
                                </span>
                                <span class="text-text-white text-sm text-right">
                                    @if (isset($column['format']) && is_callable($column['format']))
                                        {!! $column['format']($item) !!}
                                    @else
                                        {{ data_get($item, $column['key']) ?? '-' }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endforeach

                    {{-- Actions --}}
                    @if (count($actions) > 0)
                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-700">
                            @foreach ($actions as $action)
                                @php
                                    $actionValue = data_get($item, $action['param'] ?? 'id');
                                    $isActive = isset($action['condition']) ? $action['condition']($item) : true;
                                    $iconName = $action['icon'] ?? 'question-mark';
                                    $componentName = 'phosphor-' . $iconName;
                                @endphp

                                @if ($isActive)
                                    @if (isset($action['method']))
                                        <button type="button"
                                            wire:click="{{ $action['method'] }}({{ is_numeric($actionValue) ? $actionValue : "'{$actionValue}'" }})"
                                            class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors text-text-muted"
                                            title="{{ $action['label'] ?? '' }}">
                                            <x-dynamic-component :component="$componentName" class="w-6 h-6" />
                                        </button>
                                    @elseif (isset($action['route']))
                                        <a href="{{ route($action['route'], $actionValue) }}" wire:navigate
                                            class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors text-text-muted"
                                            title="{{ $action['label'] ?? '' }}">
                                            <x-dynamic-component :component="$componentName" class="w-6 h-6" />
                                        </a>
                                    @elseif (isset($action['href']))
                                        <a href="{{ $action['href'] }}" target="{{ $action['target'] ?? '_self' }}"
                                            class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors text-text-muted"
                                            title="{{ $action['label'] ?? '' }}">
                                            <x-dynamic-component :component="$componentName" class="w-6 h-6" />
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center gap-4 py-12">
                <svg class="w-16 h-16 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                <p class="text-lg font-medium text-text-muted">{{ $emptyMessage }}</p>
            </div>
        @endforelse
    </div>
</div
