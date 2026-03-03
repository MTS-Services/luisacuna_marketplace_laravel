@props([
    'icon' => ' search',
    'title' => __('No Results Found'),
    'message' => __('We couldn\'t find what you\'re looking for right now. Please check back later!'),
])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden bg-bg-primary dark:bg-bg-secondary p-8 rounded-2xl border border-white/5 flex flex-col items-center justify-center text-center min-h-[300px]']) }}>
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-pink-600/10 blur-[80px] rounded-full"></div>
    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-600/10 blur-[80px] rounded-full"></div>

    <div class="relative mb-6">
        <div class="w-20 h-20 bg-bg-info/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10">
             <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        </div>
        <div class="absolute inset-0 w-20 h-20 bg-pink-500/20 rounded-2xl animate-ping opacity-20"></div>
    </div>

    <div class="relative z-10 max-w-sm">
        <h3 class="text-xl md:text-2xl font-bold text-text-white mb-2 italic">
            {{ $title }}
        </h3>
        <p class="text-text-white/60 text-base font-normal leading-relaxed">
            {{ $message }}
        </p>
    </div>

    <div class="mt-8">
        <slot name="action"></slot>
    </div>
</div>