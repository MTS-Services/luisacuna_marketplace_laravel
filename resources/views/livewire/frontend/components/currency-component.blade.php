<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="search-filter">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search..."
                    class="form-input w-full h-10 border border-primary rounded-md focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition duration-150"
                />
            </div>
            <div class="filter flex items-center">
                <div class="border border-primary rounded-md h-10 w-12 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/light.png') }}" alt="" class="w-5 h-5">
                </div>
            </div>
        </div>
    </section>
</main>
