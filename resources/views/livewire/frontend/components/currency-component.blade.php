<main class="overflow-x-hidden-hidden">
    {{-- filder section --}}
    <section class="search-filter">
        <div class="max-w-7xl  mx-auto d-flex">
            <div class="search mt-3.5">
                <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full" />
            </div>
            <div class="filter">
                <select wire:model.live="perPage" class="form-select w-full">
            </div>
        </div>
    </section>
</main>
