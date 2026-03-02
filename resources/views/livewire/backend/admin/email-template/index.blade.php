<section class="space-y-4">
    {{-- Header with search --}}
    <div class="glass-card rounded-xl p-3 sm:p-4 shadow-shadow-primary">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-xl font-bold text-text-primary tracking-tight truncate">
                    {{ __('Email Template List') }}
                </h1>
                <p class="text-xs text-text-secondary mt-0.5 truncate">
                    {{ __('Manage email templates for orders, payments, and notifications.') }}
                </p>
            </div>
            <div class="w-full sm:w-64 shrink-0">
                <label for="search-templates" class="sr-only">{{ __('Search templates') }}</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-text-secondary">
                        <flux:icon name="magnifying-glass" class="h-4 w-4" />
                    </span>
                    <input
                        id="search-templates"
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search by key or name...') }}"
                        class="input w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-accent/20 bg-card text-text-primary placeholder:text-text-secondary focus:border-accent focus:ring-1 focus:ring-accent/20"
                    />
                </div>
            </div>
        </div>
    </div>

    {{-- Template cards grid (compact) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
        @forelse ($templates as $template)
            <a
                wire:key="template-{{ $template->id }}"
                href="{{ route('admin.email-template.edit', encrypt($template->id)) }}"
                wire:navigate
                class="glass-card rounded-xl p-3 sm:p-4 shadow-shadow-primary flex flex-col hover:shadow-md hover:border-accent/25 border border-transparent transition-all duration-150 group min-w-0"
            >
                <div class="flex items-center justify-between gap-2">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-accent/10 dark:bg-accent/20 text-accent group-hover:bg-accent/20 transition-colors">
                        <flux:icon name="envelope" class="h-4 w-4" />
                    </span>
                    <flux:icon name="chevron-right" class="h-4 w-4 shrink-0 text-accent/70 group-hover:text-accent group-hover:translate-x-0.5 transition-all" />
                </div>
                <div class="mt-2 min-w-0 flex-1">
                    <h3 class="text-sm font-semibold text-text-primary truncate group-hover:text-accent transition-colors">
                        {{ $template->name }}
                    </h3>
                    <p class="font-mono text-[11px] sm:text-xs text-text-secondary truncate mt-0.5">
                        {{ $template->key }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="glass-card rounded-xl flex flex-col items-center justify-center py-10 px-4 text-center">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent/10 text-accent/60 mb-3">
                        <flux:icon name="document-text" class="h-6 w-6" />
                    </span>
                    <h3 class="text-sm font-semibold text-text-primary">{{ __('No templates found') }}</h3>
                    <p class="text-xs text-text-secondary mt-1 max-w-xs">
                        {{ __('No email template found. Seed for new template.') }}
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    @if ($templates->hasPages())
        <div class="flex justify-center sm:justify-end pt-1">
            {{ $templates->links() }}
        </div>
    @endif
</section>
