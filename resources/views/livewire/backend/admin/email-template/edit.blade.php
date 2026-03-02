<section class="space-y-4">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/tinymce.css') }}">
    @endpush

    {{-- Compact header --}}
    <div class="glass-card rounded-xl p-3 sm:p-4 shadow-shadow-primary">
        <div class="flex items-center gap-3 min-w-0">

            <div class="min-w-0 flex-1">
                <h1 class="text-base sm:text-lg font-bold text-text-primary truncate">
                    {{ __('Edit Email Template') }}
                </h1>
                <p class="text-xs text-text-secondary mt-0.5 truncate">{{ $form->name }}</p>
            </div>
            <x-ui.button href="{{ route('admin.email-template.index') }}" variant="tertiary" class="w-auto! py-2!">
                <flux:icon name="arrow-left"
                    class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                {{ __('Back') }}
            </x-ui.button>
        </div>
    </div>

    <div class="glass-card rounded-xl p-4 sm:p-5 lg:p-6 shadow-shadow-primary" wire:key="edit-{{ $form->id }}">
        <form wire:submit="save" class="space-y-5">
            {{-- Template name (read-only) --}}
            <div class="flex flex-wrap items-center gap-2">
                <span
                    class="text-xs font-medium text-text-secondary uppercase tracking-wide">{{ __('Template') }}</span>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-md bg-accent/10 dark:bg-accent/15 text-sm font-medium text-accent border border-accent/20">
                    {{ $form->name }}
                </span>
            </div>

            {{-- Replaceable variables --}}
            <div>
                <label class="block text-xs font-medium text-text-secondary uppercase tracking-wide mb-1.5">
                    {{ __('Replaceable variables') }}
                </label>
                <p class="text-xs text-text-secondary mb-2">
                    {{ __('Use these placeholders in subject and content. They will be replaced when the email is sent.') }}
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($variables as $item)
                        @php
                            $placeholder = '{{ ' . $item . ' }}';
                        @endphp
                        <code
                            class="inline-flex items-center px-2 py-1 rounded text-xs font-mono bg-zinc-100 dark:bg-zinc-800 text-text-primary border border-zinc-200 dark:border-zinc-700">
                            {{ $placeholder }}
                        </code>
                    @endforeach
                </div>
            </div>

            {{-- Subject --}}
            <div>
                <label for="subject"
                    class="block text-xs font-medium text-text-secondary uppercase tracking-wide mb-1.5">
                    {{ __('Subject') }} <span class="text-red-500">*</span>
                </label>
                <x-ui.input id="subject" type="text" class="block w-full" wire:model="form.subject"
                    placeholder="{{ __('Email subject line') }}" />
                <x-ui.input-error :messages="$errors->get('form.subject')" class="mt-1.5" />
            </div>

            {{-- Content (TinyMCE) --}}
            <div>
                <label for="text-editor-template"
                    class="block text-xs font-medium text-text-secondary uppercase tracking-wide mb-1.5">
                    {{ __('Content') }} <span class="text-red-500">*</span>
                </label>
                <x-ui.text-editor model="form.template" id="text-editor-template"
                    placeholder="{{ __('Enter your main content here...') }}" :height="320" />
                <x-ui.input-error :messages="$errors->get('form.template')" class="mt-1.5" />
            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end sm:gap-3 sm:pt-4 border-t border-accent/10">
                <x-ui.button wire:click.prevent="resetForm" type="button" variant="tertiary"
                    class="w-full sm:w-auto py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary text-text-btn-primary group-hover:text-text-btn-tertiary    " />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Resetting...') }}</span>
                </x-ui.button>
                <x-ui.button type="accent" class="w-full sm:w-auto py-2!">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Update template') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
