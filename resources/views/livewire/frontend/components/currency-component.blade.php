<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="search-filter max-w-7xl mx-auto">
        <div class="title mt-20 mb-5">
            <h2 class="font-bold text-4xl">Currency</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search..."
                    class="form-input w-full h-11 border border-primary rounded-md focus:border-primary transition duration-150"
                />
            </div>
            <div class="filter flex items-center">
                <div class="border border-primary rounded-md h-11 w-12 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/light.png') }}" alt="" class="w-5 h-5">
                </div>
            </div>
        </div>
    </section>
</main>
