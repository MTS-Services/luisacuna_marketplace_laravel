@props(['notification', 'isRead' => false])

<a href"
    class="block group hover:bg-main/50 transition-colors rounded-lg p-3 -mx-3"
    wire:click="$parent.markAsRead('{{ $notification->id }}')">
    <div class="flex items-start gap-3">
        {{-- Icon --}}
        <div
            class="relative shrink-0 w-9 h-9 glass-card shadow-shadow-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
            <flux:icon icon="{{ $notification->data['icon'] ?? 'bell' }}"
                class="w-5 h-5 {{ $isRead ? 'stroke-white' : 'stroke-primary' }}" />
            @if (!$isRead)
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-primary rounded-full">
                    <span class="absolute inset-0 w-2 h-2 bg-primary rounded-full animate-ping"></span>
                </span>
            @endif
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <p
                class="text-text-primary text-sm font-medium mb-1 line-clamp-1 group-hover:text-primary transition-colors">
                {{ $notification->data['title'] ?? __('Notification') }}
            </p>
            <p class="text-text-secondary text-xs line-clamp-2 mb-1">
                {{ $notification->data['message'] ?? '' }}
            </p>
            <span class="text-text-muted text-xs">
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</a>
