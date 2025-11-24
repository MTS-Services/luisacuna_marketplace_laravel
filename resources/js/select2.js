// import Select2 from 'select2';
// import 'select2/dist/css/select2.min.css';

// // Attach Select2 to jQuery
// Select2($);

// function initializeSelect2(placeholder = "Choose an option", multiple = false, tags = false, allowClear = true) {
//     const selects = document.querySelectorAll("select.select2:not(.select2-hidden-accessible)");

//     selects.forEach(select => {
//         const $select = $(select);

//         $select.select2({
//             // Enable tags/create new options
//             tags: tags,
//             tokenSeparators: [','],

//             // ALWAYS show search box
//             minimumResultsForSearch: 0,

//             // CRITICAL: Use element width
//             width: '100%',

//             // CRITICAL: Attach dropdown to the same parent as select
//             // dropdownParent: $select.parent(),

//             // Multiple selection
//             multiple: multiple,

//             // Disable auto width
//             dropdownAutoWidth: true,

//             // Allow clear button
//             allowClear: allowClear,

//             // Placeholder
//             placeholder: placeholder,

//             // Theme
//             theme: 'default'
//         });

//         // After initialization, force dropdown width to match container
//         $select.on('select2:open', function () {
//             const container = $select.data('select2').$container;
//             const dropdown = $select.data('select2').$dropdown;

//             if (container && dropdown) {
//                 const containerWidth = container.outerWidth();
//                 dropdown.css({
//                     'width': containerWidth + 'px',
//                     'max-width': containerWidth + 'px',
//                     'min-width': containerWidth + 'px'
//                 });
//             }
//         });

//         // Livewire integration - trigger change event
//         $select.on('change', function (e) {
//             let event = new Event('change', { bubbles: true });
//             select.dispatchEvent(event);
//         });
//     });
// }

// window.initializeSelect2 = initializeSelect2;



import Select2 from 'select2';
import 'select2/dist/css/select2.min.css';

// Attach Select2 to jQuery
Select2($);

/**
 * Initialize Select2 on all select elements with .select2-target class
 */
function initializeSelect2() {
    const selects = document.querySelectorAll('.select2:not(.not-select2)');

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

            // Initialize Select2 with config
            $select.select2({
                // Tags/create new options
                tags: config.tags || false,
                tokenSeparators: config.tags ? [','] : [],

                // Always show search box
                minimumResultsForSearch: 0,

                // Width settings
                width: '100%',
                dropdownAutoWidth: true,

                // Allow clear button
                allowClear: config.allowClear !== false,

                // Placeholder
                placeholder: config.placeholder || 'Choose an option',

                // Multiple selection
                multiple: config.multiple || false,

                // Theme
                theme: 'default',

                // Dropdown parent (optional - uncomment if needed)
                // dropdownParent: $select.parent(),
            });

            // Force dropdown width to match container on open
            $select.on('select2:open', function () {
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

            // Livewire integration - trigger both change and input events
            $select.on('change', function (e) {
                // Dispatch native change event
                let changeEvent = new Event('change', { bubbles: true });
                select.dispatchEvent(changeEvent);

                // Also dispatch input event for wire:model.live
                let inputEvent = new Event('input', { bubbles: true });
                select.dispatchEvent(inputEvent);
            });

            console.log('Select2 initialized:', select.id || select.name);

        } catch (error) {
            console.error('Select2 initialization error:', error, select);
        }
    });
}

// Export for global use
window.initializeSelect2 = initializeSelect2;

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeSelect2);
} else {
    initializeSelect2();
}

// Livewire integration
if (typeof Livewire !== 'undefined') {
    // Livewire v3
    document.addEventListener('livewire:navigated', initializeSelect2);
    document.addEventListener('livewire:initialized', initializeSelect2);

    // Re-initialize after Livewire updates
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        succeed(({ snapshot, effect }) => {
            // Use queueMicrotask to ensure DOM is updated
            queueMicrotask(() => {
                initializeSelect2();
            });
        });
    });
}

export default initializeSelect2;
