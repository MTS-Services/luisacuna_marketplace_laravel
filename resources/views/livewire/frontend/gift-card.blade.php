<main class="mx-auto">
    {{-- Gift Card header --}}
    <section class="container mx-auto mt-10">
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Gift Cards') }}
            </h1>
        </div>
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Gift Cards') }}</h2>
        </div>

        <div class="flex items-center justify-between gap-4 my-10">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded!" />
            </div>
            <div class="flex items-center justify-between gap-4 relative" x-data={filter:false}>

                <button
                    class="flex items-center gap-2  px-5 hover:bg-purple-600 transition py-2 bg-bg-primary rounded border! border-zinc-700!">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span>{{ __('Filter') }}</span>
                </button>
                
            </div>
        </div>


    </section>
    {{-- Gift Cards --}}
    <section class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
           
          @forelse ([1,2,3,4,5,6] as $item )
              <x-gift-card />
          @empty
              <h2>{{ __('No gift card found') }}</h2>
          @endforelse
        </div>
        <div class="pagination mb-24 mx-auto">
            {{-- <x-frontend.pagination-ui  :pagination="'[1,2,3,4,5,6,7,8,9,10]'"/> --}}
             <div class="flex justify-center lg:justify-end items-center space-x-3 p-4 mt-10">
                <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Previous') }}</button>

                <button class="bg-zinc-600 text-white text-sm px-3 py-1 rounded">1</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">2</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">3</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">4</button>
                <button class="text-text-primary text-sm hover:text-zinc-500">5</button>

                <button class="text-text-primary text-sm hover:text-zinc-500">{{ __('Next') }}</button>
            </div>
        </div>
    </section>
</main>
