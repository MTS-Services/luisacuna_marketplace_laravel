import Select2 from 'select2';
import 'select2/dist/css/select2.min.css';

// Manually attach Select2 to jQuery (Keep this for the fix)
Select2($); 

function initializeSelect2() {
    // 1. Target all select.select2 elements that have NOT been initialized yet
    const selects = document.querySelectorAll("select.select2:not(.select2-hidden-accessible)");
    
    selects.forEach(select => {
        // 2. Initialize Select2
        $(select).select2({
            tags: true,
            tokenSeparators: [','],
        });

        if (select.__livewire_listeners) {
             select.addEventListener('change', (e) => {
                select.dispatchEvent(new Event('change', { bubbles: true }));
             });
        }
    });
    console.log('Select2 attached to new elements.');
}

// Run on initial page load AND after Livewire navigates to a new page
document.addEventListener("livewire:navigated", () => {
    initializeSelect2();
});

// If you have components that update their HTML content via AJAX (e.g., modals, lists)
document.addEventListener("livewire:initialized", () => {
    // This is the fallback for initial full page load
    initializeSelect2();
});
Livewire.hook('morph.updated', ({ el }) => {
    // Re-run for DOM updates within a component (e.g., adding a new row)
    if (el.matches('select.select2') || el.querySelector('select.select2')) {
        initializeSelect2();
    }
});