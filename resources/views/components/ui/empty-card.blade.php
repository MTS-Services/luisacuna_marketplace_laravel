<div
    class="col-span-full flex flex-col items-center justify-center py-20 px-6 bg-bg-primary dark:bg-bg-secondary rounded-2xl border border-dashed border-zinc-800 transition-all duration-300">

    <div class="relative mb-6">
        <div class="absolute -inset-4 bg-purple-500/10 blur-3xl rounded-full"></div>

        <div class="relative flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-zinc-600" viewBox="0 0 256 256">
                <rect width="256" height="256" fill="none" />
                <path d="M216,112V40a8,8,0,0,0-8-8H48a8,8,0,0,0-8,8v72a72,72,0,0,0,144,0Z" fill="none"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="8" />
                <circle cx="92" cy="108" r="12" fill="currentColor" />
                <circle cx="164" cy="108" r="12" fill="currentColor" />
                <path d="M40,112v96a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V112" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="8" />
                <line x1="104" y1="168" x2="152" y2="168" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="8" />
            </svg>

            <div class="absolute -top-1 -right-1 bg-orange p-1.5 rounded-full shadow-xl border-2 border-bg-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h3 class="text-text-white text-xl md:text-2xl font-bold tracking-tight opacity-80">
            {{ __('Nothing in the Vault') }}
        </h3>
    </div>
</div>
