@props(['cards' => 4])

<div {{ $attributes->merge(['class' => 'space-y-6']) }}>
    {{-- Stat cards skeleton --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $cards }} gap-4 lg:gap-6">
        @for ($i = 0; $i < $cards; $i++)
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                    <div class="w-12 h-4 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                </div>
                <div class="h-7 w-28 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
                <div class="h-4 w-20 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                <div class="mt-4 h-1 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
        @endfor
    </div>

    {{-- Financial Flow (area) skeleton --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="h-5 w-40 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
                <div class="h-4 w-64 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
            <div class="flex gap-2">
                <div class="h-4 w-20 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                <div class="h-4 w-16 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
        </div>
        <div class="h-72 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
    </div>

    {{-- Row 2: Order Lifecycle + Revenue by Game --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl p-6">
            <div class="h-5 w-36 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
            <div class="h-4 w-52 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-6"></div>
            <div class="h-64 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <div class="h-5 w-40 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
            <div class="h-4 w-48 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-6"></div>
            <div class="h-64 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
        </div>
    </div>

    {{-- Row 3: Revenue by Category + Withdrawal Queue --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl p-6">
            <div class="h-5 w-44 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
            <div class="h-4 w-52 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-6"></div>
            <div class="h-64 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <div class="h-5 w-40 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
            <div class="h-4 w-56 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-6"></div>
            <div class="h-64 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
        </div>
    </div>

    {{-- Profit & Commission (column) skeleton --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="h-5 w-44 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
                <div class="h-4 w-64 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
            <div class="flex gap-2">
                <div class="h-4 w-24 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                <div class="h-4 w-24 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
        </div>
        <div class="h-72 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
    </div>

    {{-- Seller Engagement (line) skeleton --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="h-5 w-40 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer mb-2"></div>
                <div class="h-4 w-60 rounded bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
            <div class="flex gap-2">
                <div class="h-4 w-16 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
                <div class="h-4 w-16 rounded-full bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
            </div>
        </div>
        <div class="h-64 rounded-xl bg-zinc-200 dark:bg-zinc-800 animate-shimmer"></div>
    </div>
</div>
