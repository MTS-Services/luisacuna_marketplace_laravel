<section class="space-y-6">
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-text-primary">
                    {{ __('Language List') }}
                </h2>
                <p class="text-sm text-text-muted mt-1">
                    {{ __('Manage the languages available in your marketplace.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Languages grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse ($languages as $language)
            <div
                wire:key="language-{{ $language->id }}"
                class="glass-card rounded-2xl p-5 flex flex-col gap-4">

                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-text-primary truncate">
                            {{ $language->name }}
                        </h3>
                        <p class="text-xs text-text-muted mt-0.5 truncate">
                            {{ $language->native_name }}
                        </p>
                        <p class="text-[11px] text-text-muted font-mono mt-0.5">
                            {{ $language->locale }}
                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium badge badge-soft {{ $language->status->color() }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $language->status === \App\Enums\LanguageStatus::ACTIVE ? 'bg-green-500' : 'bg-zinc-400' }}"></span>
                            {{ $language->status->label() }}
                        </span>

                        <button
                            type="button"
                            wire:click="changeStatus({{ $language->id }}, '{{ $language->status === \App\Enums\LanguageStatus::ACTIVE ? \App\Enums\LanguageStatus::INACTIVE->value : \App\Enums\LanguageStatus::ACTIVE->value }}')"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium border border-border bg-bg-secondary/60 hover:bg-bg-secondary text-text-muted transition-colors">
                            <flux:icon
                                name="arrows-right-left"
                                class="w-3 h-3" />
                            <span>
                                {{ $language->status === \App\Enums\LanguageStatus::ACTIVE ? __('Set inactive') : __('Set active') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] text-text-muted">
                    <span>
                        {{ __('Created') }}: {{ $language->created_at_formatted ?? $language->created_at?->format('Y-m-d') }}
                    </span>
                    <span class="truncate max-w-[45%] text-right">
                        {{ __('By') }}: {{ $language->creater_admin?->name ?? 'System' }}
                    </span>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <a
                        href="{{ route('admin.as.language.view', encrypt($language->id)) }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-[11px] font-medium border border-white/10 bg-white/5 hover:bg-white/10 text-text-primary transition-colors">
                        <flux:icon name="eye" class="w-3.5 h-3.5" />
                        <span>{{ __('View') }}</span>
                    </a>

                    <a
                        href="{{ route('admin.as.language.edit', encrypt($language->id)) }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-[11px] font-medium border border-accent/30 bg-accent/10 text-accent hover:bg-accent/20 transition-colors">
                        <flux:icon name="pencil-square" class="w-3.5 h-3.5" />
                        <span>{{ __('Edit') }}</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="glass-card rounded-2xl flex flex-col items-center justify-center py-10 px-4 text-center">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent/10 text-accent/60 mb-3">
                        <flux:icon name="language" class="h-6 w-6" />
                    </span>
                    <h3 class="text-sm font-semibold text-text-primary">
                        {{ __('No languages found') }}
                    </h3>
                    <p class="text-xs text-text-muted mt-1 max-w-xs">
                        {{ __('Languages configured in your system will appear here.') }}
                    </p>
                </div>
            </div>
        @endforelse
    </div>
</section>
