@props(['status'])

@php
    $steps = [
        ['label' => __('Opened'), 'active' => true],
        ['label' => __('Vendor Notified'), 'active' => $status !== \App\Enums\DisputeStatus::PENDING_VENDOR],
        ['label' => __('Admin Review'), 'active' => in_array($status, [\App\Enums\DisputeStatus::ESCALATED, \App\Enums\DisputeStatus::RESOLVED_REFUND, \App\Enums\DisputeStatus::RESOLVED_CLOSED], true)],
        ['label' => __('Closed'), 'active' => $status->isResolved()],
    ];
@endphp

<div class="flex items-center justify-between gap-2 text-xs">
    @foreach($steps as $index => $step)
        <div class="flex items-center gap-2 flex-1">
            <div class="flex items-center gap-2">
                <div class="h-2.5 w-2.5 rounded-full {{ $step['active'] ? 'bg-primary-500' : 'bg-zinc-700' }}"></div>
                <span class="text-[11px] {{ $step['active'] ? 'text-text-primary' : 'text-text-muted' }}">
                    {{ $step['label'] }}
                </span>
            </div>

            @if($index < count($steps) - 1)
                <div class="flex-1 h-px {{ $steps[$index + 1]['active'] ? 'bg-primary-500' : 'bg-zinc-700' }}"></div>
            @endif
        </div>
    @endforeach
</div>

