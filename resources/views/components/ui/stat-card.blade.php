@props([
    'icon' => 'chart-bar',
    'label' => '',
    'value' => 0,
    'prefix' => '',
    'growth' => 0,
    'color' => 'blue',
    'progress' => 0,
])

@php
    $colorMap = [
        'blue'   => ['bg' => 'bg-blue-500/20',   'icon' => 'text-blue-400',   'bar' => 'from-blue-400 to-blue-600'],
        'green'  => ['bg' => 'bg-green-500/20',  'icon' => 'text-green-400',  'bar' => 'from-green-400 to-green-600'],
        'purple' => ['bg' => 'bg-purple-500/20', 'icon' => 'text-purple-400', 'bar' => 'from-purple-400 to-purple-600'],
        'yellow' => ['bg' => 'bg-yellow-500/20', 'icon' => 'text-yellow-400', 'bar' => 'from-yellow-400 to-yellow-600'],
    ];
    $c = $colorMap[$color] ?? $colorMap['blue'];
    $isPositive = $growth >= 0;
@endphp

<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl p-6']) }}>
    <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 {{ $c['bg'] }} rounded-xl flex items-center justify-center">
            <flux:icon :name="$icon" class="w-6 h-6 {{ $c['icon'] }}" />
        </div>
        <div class="{{ $isPositive ? 'text-green-400' : 'text-red-400' }} text-sm font-medium flex items-center gap-1">
            <flux:icon :name="$isPositive ? 'arrow-trending-up' : 'arrow-trending-down'" class="w-3 h-3" />
            {{ ($isPositive ? '+' : '') . $growth }}%
        </div>
    </div>
    <h3 class="text-2xl font-bold text-text-primary mb-1">
        {{ $prefix }}{{ is_numeric($value) ? number_format($value) : $value }}
    </h3>
    <p class="text-text-secondary text-sm">{{ $label }}</p>
    @if($progress > 0)
        <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
            <div
                class="h-full bg-gradient-to-r {{ $c['bar'] }} rounded-full transition-all duration-700"
                style="width: {{ min($progress, 100) }}%;"
            ></div>
        </div>
    @endif
</div>
