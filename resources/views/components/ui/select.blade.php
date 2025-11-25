@props([
    'disabled' => false,
    'append' => null,
    'multiple' => false,
    'placeholder' => 'Choose an option',
    'tags' => false,
    'allowClear' => true,
])

@php
    // Generate unique ID for this select instance
    $selectId = $attributes->get('id', 'select-' . uniqid());

    // Prepare Select2 config as JSON
    $select2Config = json_encode([
        'placeholder' => $placeholder,
        'multiple' => $multiple,
        'tags' => $tags,
        'allowClear' => $allowClear,
    ]);
@endphp

{{-- Check if $append prop is provided --}}
@if (is_null($append))
    {{-- STANDARD SELECT INPUT --}}
    <select id="{{ $selectId }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'select w-full !border-zinc-300 focus:!border-accent focus:!outline-none focus:!ring-1 focus:!ring-accent shadow-sm dark:border-zinc-700 bg-transparent dark:text-zinc-100 text-zinc-900 dark:focus:border-accent dark:focus:ring-accent !transition-all !duration-300 !ease-in-out',
    ]) !!}
        {{ $multiple ? 'multiple' : '' }} data-select2-config="{{ $select2Config }}">
        {{ $slot }}
    </select>
@else
    <div class="flex items-center w-full">
        <select id="{{ $selectId }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' =>
                'select rounded-r-none w-full !border-zinc-300 focus:!border-accent focus:!ring-1 focus:!ring-accent shadow-sm dark:border-zinc-700 bg-transparent dark:text-zinc-100 text-zinc-900 dark:focus:border-accent dark:focus:ring-accent !transition-all !duration-300 !ease-in-out',
        ]) !!}
            {{ $multiple ? 'multiple' : '' }} data-select2-config="{{ $select2Config }}">
            {{ $slot }}
        </select>

        {{-- Appended Span --}}
        <span
            class="inline-flex items-center h-12 -ml-px px-4 text-sm font-medium border border-l-0 border-zinc-300 rounded-r-md bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:border-zinc-700 dark:text-zinc-300">
            {{ $append }}
        </span>
    </div>
@endif

@once
    @push('scripts')
        <script>
            function initializeAllSelect2() {
                const selects = document.querySelectorAll('select.select2:not(.select2-hidden-accessible)');

                selects.forEach(select => {
                    try {
                        const $select = $(select);

                        // Get config from data attribute
                        const configJson = select.getAttribute('data-select2-config');
                        const config = configJson ? JSON.parse(configJson) : {};

                        // Destroy existing Select2 instance if it exists
                        if ($select.hasClass('select2-hidden-accessible')) {
                            $select.select2('destroy');
                        }

                        // Initialize Select2
                        $select.select2({
                            tags: config.tags || false,
                            tokenSeparators: config.tags ? [','] : [],
                            minimumResultsForSearch: 0,
                            width: '100%',
                            dropdownAutoWidth: true,
                            allowClear: config.allowClear !== false,
                            placeholder: config.placeholder || 'Choose an option',
                            multiple: config.multiple || false,
                            theme: 'default',
                        });

                        // Force dropdown width on open
                        $select.on('select2:open', function() {
                            const container = $select.data('select2').$container;
                            const dropdown = $select.data('select2').$dropdown;

                            if (container && dropdown) {
                                const containerWidth = container.outerWidth();
                                dropdown.css({
                                    'width': containerWidth + 'px',
                                    'max-width': containerWidth + 'px',
                                    'min-width': containerWidth + 'px'
                                });
                            }
                        });

                        // Livewire integration
                        $select.on('change', function(e) {
                            // Dispatch native change event for Livewire
                            let event = new Event('change', {
                                bubbles: true
                            });
                            select.dispatchEvent(event);

                            // Also trigger Livewire's input event if wire:model is present
                            if (select.hasAttribute('wire:model') || select.hasAttribute('wire:model.live')) {
                                select.dispatchEvent(new Event('input', {
                                    bubbles: true
                                }));
                            }
                        });

                    } catch (error) {
                        console.error('Select2 initialization error:', error);
                    }
                });
            }

            // Initialize on different events
            if (typeof Livewire !== 'undefined') {
                // Livewire v3
                document.addEventListener('livewire:navigated', initializeAllSelect2);
                document.addEventListener('livewire:initialized', initializeAllSelect2);

                // Re-initialize after Livewire updates
                // Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                //     succeed(({ snapshot, effect }) => {
                //         queueMicrotask(() => {
                //             initializeAllSelect2();
                //         });
                //     });
                // });
            }

            // Standard DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeAllSelect2);
            } else {
                initializeAllSelect2();
            }

            // Make function globally available
            window.initializeAllSelect2 = initializeAllSelect2;
        </script>
    @endpush
@endonce
