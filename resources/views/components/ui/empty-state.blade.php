@props([
    'icon' => 'inbox',
    'title' => __('No Results Found'),
    'message' => __('We couldn\'t find what you\'re looking for right now. Please check back later!'),
    'action' => null,
])

<div
    {{ $attributes->merge(['class' => 'relative overflow-hidden p-8 rounded-2xl flex flex-col items-center justify-center text-center min-h-[300px] bg-card/60 dark:bg-card/40 backdrop-blur-xl border border-border/50']) }}>
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-pink-600/10 blur-[80px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-600/10 blur-[80px] rounded-full pointer-events-none">
    </div>

    <div class="relative mb-6">
        <div
            class="w-20 h-20 bg-zinc-500/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10 dark:border-white/5">
            <flux:icon :name="$icon" class="w-10 h-10 text-pink-500" />
        </div>
        <div class="absolute inset-0 w-20 h-20 bg-pink-500/20 rounded-2xl animate-ping opacity-20"></div>
    </div>

    <div class="relative z-10 max-w-sm">
        <h3 class="text-xl md:text-2xl font-bold text-text-primary mb-2 italic">
            {{ $title }}
        </h3>
        <p class="text-text-muted text-base font-normal leading-relaxed">
            {{ $message }}
        </p>
    </div>

    @if (isset($action))
        <div class="mt-8 relative z-10">
            {{ $action }}
        </div>
    @endif
</div>
