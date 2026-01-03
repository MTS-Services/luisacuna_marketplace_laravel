@props([
    'model',
    'id',
    'placeholder' => '',
    'height' => 400,
    'disabled' => false,
    'menubar' => false,
    'readonly' => false,
])

@php
    $editorId = $id ?? 'tinymce-' . uniqid();
@endphp

<div wire:ignore x-data="{
    value: @entangle($model).live,
    editor: null,
    editorId: '{{ $editorId }}',

    initEditor() {
        const self = this;

        // Check if dark mode is active on the HTML element (Tailwind 4.1 standard)
        const isDark = document.documentElement.classList.contains('dark');

        // Define internal editor colors to match your CSS variables
        const bodyBg = isDark ? '#130f26' : '#ffffff';
        const textColor = isDark ? '#e0d9ff' : '#333333';

        tinymce.init({
            selector: '#' + this.editorId,
            height: {{ $height }},
            menubar: {{ $menubar ? 'true' : 'false' }},
            branding: false,
            license_key: 'gpl',
            promotion: false,

            // Apply built-in dark/light skins for icons and dialogs
            skin: isDark ? 'oxide-dark' : 'oxide',
            content_css: isDark ? 'dark' : 'default',

            plugins: [
                'code', 'table', 'lists', 'link', 'image', 'media',
                'preview', 'anchor', 'searchreplace', 'visualblocks',
                'fullscreen', 'insertdatetime', 'charmap', 'wordcount'
            ],

            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table | removeformat code preview searchreplace',

            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            placeholder: '{{ $placeholder }}',
            readonly: {{ $disabled ? 'true' : 'false' }},

            // This fixes the 'Written Area' color issues
            content_style: `
                body {
                    background-color: ${bodyBg} !important;
                    color: ${textColor} !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                    font-size: 14px; 
                    line-height: 1.5;
                }
                /* Custom placeholder styling for dark mode */
                body.mce-content-body[data-mce-placeholder]::before {
                    color: ${isDark ? 'rgba(224, 217, 255, 0.3)' : 'rgba(0,0,0,0.3)'} !important;
                }
            `,

            images_upload_handler: function(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        resolve(reader.result);
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(blobInfo.blob());
                });
            },

            setup: function(editor) {
                self.editor = editor;

                // Sync initial content
                editor.on('init', function() {
                    editor.setContent(self.value || '');

                    // Watch for external Livewire changes
                    self.$watch('value', (newValue) => {
                        if (editor.getContent() !== newValue) {
                            editor.setContent(newValue || '');
                        }
                    });
                });

                // Update Livewire on change, keyup, or blur
                editor.on('change keyup blur', function() {
                    self.value = editor.getContent();
                });
            },
        });
        this.$watch('$flux.dark', () => {
            this.resetEditor();
        });
    },

    resetEditor() {
        if (tinymce.get(this.editorId)) {
            tinymce.get(this.editorId).destroy();
        }
        this.editor = null;
        this.$nextTick(() => {
            this.initEditor();
        });
    }
}" @reset-tinymce-initiallized.window="resetEditor()" x-cloak>
    <textarea id="{{ $editorId }}" class="tinymce-editor" style="width: 100%;" {{ $disabled ? 'disabled' : '' }}></textarea>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.js') }}" referrerpolicy="origin"></script>
        <script>
            // Reset editor on Livewire navigation to pick up theme changes
            document.addEventListener('livewire:navigated', () => {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('reset-tinymce-initiallized'));
                }, 500);
            });
        </script>
    @endpush
@endonce
