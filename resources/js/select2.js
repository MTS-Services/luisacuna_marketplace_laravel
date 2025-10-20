import Select2 from 'select2';
import 'select2/dist/css/select2.min.css';

// Attach Select2 to jQuery
Select2($);

function initializeSelect2() {
    const selects = document.querySelectorAll("select.select2:not(.select2-hidden-accessible)");

    selects.forEach(select => {
        const $select = $(select);
        
        $select.select2({
            // Enable tags/create new options
            tags: true,
            tokenSeparators: [','],
            
            // ALWAYS show search box
            minimumResultsForSearch: 0,
            
            // CRITICAL: Use element width
            width: '100%',
            
            // CRITICAL: Attach dropdown to the same parent as select
            dropdownParent: $select.parent(),
            
            // Disable auto width
            dropdownAutoWidth: false,

            // Allow clear button
            // allowClear: true,
            
            // Placeholder
            // placeholder: "Choose an option",
            
            // Theme
            theme: 'default'
        });

        // After initialization, force dropdown width to match container
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

        // Livewire integration - trigger change event
        $select.on('change', function(e) {
            let event = new Event('change', { bubbles: true });
            select.dispatchEvent(event);
        });
    });
    
    console.log('Select2 initialized on', selects.length, 'elements');
}

// Initialize on Livewire navigation
document.addEventListener("livewire:navigated", () => {
    initializeSelect2();
});

// Initialize on page load
document.addEventListener("livewire:initialized", () => {
    initializeSelect2();
});

// Re-initialize after DOM morphing
Livewire.hook('morph.updated', ({ el }) => {
    if (el.matches('select.select2') || el.querySelector('select.select2')) {
        initializeSelect2();
    }
});