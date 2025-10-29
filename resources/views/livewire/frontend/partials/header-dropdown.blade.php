<section class="absolute top-full left-0 right-0 w-full z-50 mt-0" x-show="open != ''" x-hide="open == ''">
    <div class="container mx-auto px-4 py-6">
        <div class="bg-bg-primary flex flex-col lg:flex-row items-start justify-between rounded-lg py-11 px-4 lg:px-10 shadow-2xl">
            {{-- Popular Games Section --}}
            <div class="w-full lg:w-2/3 pt-10 order-2 lg:order-1">
                <h3 class="text-text-white text-base font-semibold pt-2 mb-6">
                    Popular {{ ucfirst($dropdownType) }}
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5">
                    @foreach($this->content['popular'] ?? [] as $item)
                        <div class="flex items-center gap-2.5 p-2.5 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                            <div class="w-6 h-6">
                                <img src="{{ asset('assets/images/game_icon/' . $item['icon']) }}" 
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <p class="text-base font-normal text-text-white">{{ $item['name'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Search and All Games Section --}}
            <div class="w-full lg:w-1/3 p-6 order-1 lg:order-2">
                <div class="mb-6">
                    <span class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search for {{ $dropdownType }}" 
                            class="form-input w-full text-text-white bg-bg-secondary border border-purple-500/20 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-500" 
                        />
                    </span>
                </div>
                
                <div class="space-y-2">
                    <p class="text-xs font-semibold text-text-white/70 px-2.5 uppercase tracking-wide">
                        All {{ ucfirst($dropdownType) }}
                    </p>
                    @foreach($this->content['all'] ?? [] as $item)
                        <p class="text-base font-normal text-text-white p-2.5 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                            {{ $item }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>