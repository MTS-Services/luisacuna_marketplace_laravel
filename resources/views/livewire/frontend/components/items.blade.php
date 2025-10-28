<main class="mx-auto">
    <section class="container mx-auto">
        <div class="flex items-center gap-1 mt-10">
            <div class="w-3 h-3">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full">
            </div>
            <div class="">
                Home
            </div>
            <div class="px-2">
                >
            </div>
            <div class="">
                Items
            </div>
        </div>
    </section>
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 mt-10 mb-10">
            <div class="w-12 h-12">
                <img src="{{ asset('assets/images/items/item-logo.png') }}" alt="m logo" class="w-full h-full">
            </div>
            <div class="">
                <h2 class="font-semibold text-white text-5xl">Items</h2>
            </div>
        </div>
        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full" />
            </div>
            <div class="filter flex items-center">
                <div class="border border-primary rounded-xl h-10 w-30 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/light.png') }}" alt="" class="w-5 h-5">
                    <p>Filter</p>
                </div>
            </div>
        </div>
    </section>
    {{-- popular items --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-white text-5xl">Popular Item</h2>
            </div>
            <div class="flex items-center gap-6">
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-88 h-68">
                            <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
                                class="w-full h-full rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Grand Theft Auto 5</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-88 h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                class="w-full h-full rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Valorant</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-zinc-900 rounded-2xl">
                    <div class="">
                        <div class="w-88 h-68 rounded-2xl">
                            <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                class="w-full h-full rounded-lg">
                        </div>
                        <div class="mt-5 mb-8">
                            <h2 class="text-2xl text-semibold text-white">Call of Duty</h2>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-primary w-full">
                            See seller list
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
