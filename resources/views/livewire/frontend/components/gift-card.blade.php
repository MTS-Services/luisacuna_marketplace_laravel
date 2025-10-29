<main class="mx-auto">
    {{-- Gift Card header --}}
    <section class="container mx-auto mt-10 gift-card">
        <div class="mt-14">
            <h2 class="text-5xl font-semibold text-text-white">Gift Cards</h2>
        </div>

        <div class="flex items-center justify-between gap-4 my-10">
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
    {{-- Gift Cards --}}
    <section class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/1.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/2.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/3.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/4.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/5.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/6.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/7.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/8.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/9.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/10.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/11.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/12.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/13.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/14.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/15.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/16.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/17.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/18.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/19.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
            <div class="w-full h-72 relative">
                <img src="{{ asset('assets/images/gift_cards/20.png') }}" alt="" class="w-full h-full">
                <div class="absolute top-2.5 right-2.5">
                    <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">4 offerd</span>
                </div>
            </div>
        </div>
        <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div>
    </section>
</main>
