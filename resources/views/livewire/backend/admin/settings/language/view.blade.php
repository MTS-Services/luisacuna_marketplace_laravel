<section class="max-w-6xl mx-auto space-y-6 antialiased">
    {{-- Top Navigation & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs font-medium text-text-muted mb-1 px-1">
                <a href="{{ route('admin.as.language.index') }}"
                    class="hover:text-accent transition-colors">{{ __('Languages') }}</a>
                <flux:icon name="chevron-right" class="w-3 h-3 opacity-50" />
                <span class="text-text-primary">{{ __('Details') }}</span>
            </nav>
            <h1 class="text-2xl font-bold text-text-primary tracking-tight px-1">
                {{ $data->name }} <span class="text-text-muted font-normal text-lg ml-1">({{ $data->locale }})</span>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('admin.as.language.index') }}" class="hidden sm:flex">
                <flux:icon name="arrow-left"
                    class="w-4 h-4 mr-2 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                {{ __('Back to List') }}
            </x-ui.button>

            <x-ui.button href="{{ route('admin.as.language.edit', encrypt($data->id)) }}" variant="secondary"
                class="shadow-lg shadow-accent/20">
                <flux:icon name="pencil-square"
                    class="w-4 h-4 mr-2 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                {{ __('Edit Configuration') }}
            </x-ui.button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Identity & Status --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Flag & Main Info Card --}}
            <div
                class="glass-card rounded-3xl p-8 flex flex-col items-center text-center border-white/[0.08] relative overflow-hidden h-full">
                <div class="absolute top-0 right-0 p-4">
                    @if ($data->is_default)
                        <div class="bg-amber-500/10 text-amber-500 p-1.5 rounded-full border border-amber-500/20 shadow-sm"
                            title="Default Language">
                            <flux:icon name="star" class="w-4 h-4" variant="solid" />
                        </div>
                    @endif
                </div>

                <div
                    class="w-32 h-24 rounded-2xl bg-bg-secondary/50 border border-white/10 p-2 shadow-inner mb-6 flex items-center justify-center overflow-hidden">
                    @if ($data->flag_icon)
                        <img src="{{ $data->flag_icon }}" alt="{{ $data->name }} flag"
                            class="w-full h-full object-cover rounded-lg shadow-sm">
                    @else
                        <div class="flex flex-col items-center gap-1 opacity-20">
                            <flux:icon name="flag" class="w-10 h-10 text-text-muted" />
                            <span class="text-[10px] font-bold uppercase tracking-tighter">{{ __('No Flag') }}</span>
                        </div>
                    @endif
                </div>

                <h2 class="text-xl font-bold text-text-primary mb-1">{{ $data->name }}</h2>
                <p class="text-text-muted text-sm mb-6">{{ $data->native_name ?? $data->name }}</p>

                <div class="flex flex-wrap justify-center gap-2">
                    <span
                        class="px-3 py-1 rounded-full text-[11px] font-bold bg-bg-secondary border border-border text-text-muted uppercase tracking-wider">
                        {{ $data->country_code }}
                    </span>
                    <span
                        class="px-3 py-1 rounded-full text-[11px] font-bold border flex items-center gap-1.5
                        {{ $data->status === \App\Enums\LanguageStatus::ACTIVE
                            ? 'bg-green-500/5 text-green-500 border-green-500/20'
                            : 'bg-red-500/5 text-red-500 border-red-500/20' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full animate-pulse {{ $data->status === \App\Enums\LanguageStatus::ACTIVE ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $data->status->label() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Right Column: Detailed Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Main Configuration Card --}}
            <div class="glass-card rounded-3xl border-white/[0.08] overflow-hidden h-full">
                <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                    <h3 class="font-semibold text-text-primary">{{ __('Configuration Details') }}</h3>
                    <span
                        class="text-[10px] font-bold text-text-muted uppercase tracking-widest">{{ __('System Profile') }}</span>
                </div>

                <div class="p-6 md:p-8">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Language Name') }}</dt>
                            <dd class="text-base text-text-primary font-medium">{{ $data->name }}</dd>
                        </div>

                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Native Name') }}</dt>
                            <dd class="text-base text-text-primary font-medium">{{ $data->native_name ?? '—' }}</dd>
                        </div>

                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Locale Code') }}</dt>
                            <dd
                                class="inline-flex items-center px-2 py-0.5 rounded bg-bg-secondary font-mono text-sm font-bold text-accent uppercase">
                                {{ $data->locale }}
                            </dd>
                        </div>

                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Country Code') }}</dt>
                            <dd
                                class="inline-flex items-center px-2 py-0.5 rounded bg-bg-secondary font-mono text-sm font-bold text-text-primary uppercase">
                                {{ $data->country_code }}
                            </dd>
                        </div>

                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Text Direction') }}</dt>
                            <dd class="text-sm font-semibold text-text-primary flex items-center gap-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 rounded bg-accent/10 text-accent text-xs">
                                    {{ $data->direction->value === 'ltr' ? '→' : '←' }}
                                </span>
                                {{ $data->direction->label() }}
                            </dd>
                        </div>

                        <div class="space-y-1.5">
                            <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                {{ __('Default Status') }}</dt>
                            <dd class="text-sm">
                                @if ($data->is_default)
                                    <span class="text-amber-500 font-bold flex items-center gap-1.5">
                                        <flux:icon name="check-circle" class="w-4 h-4" variant="solid" />
                                        {{ __('Primary Language') }}
                                    </span>
                                @else
                                    <span class="text-text-muted font-medium">{{ __('Secondary Language') }}</span>
                                @endif
                            </dd>
                        </div>

                        @if ($data->flag_icon)
                            <div class="sm:col-span-2 pt-4 border-t border-white/5 space-y-1.5">
                                <dt class="text-[11px] font-bold text-text-muted uppercase tracking-wider">
                                    {{ __('Flag Resource URL') }}</dt>
                                <dd class="text-sm">
                                    <a href="{{ $data->flag_icon }}" target="_blank"
                                        class="text-accent hover:text-accent-hover transition-colors flex items-center gap-2 break-all italic">
                                        <flux:icon name="link" class="w-3.5 h-3.5 shrink-0" />
                                        {{ $data->flag_icon }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>
