<div>
    <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
        wire:navigate>
        <div class="w-full h-72 relative">
            <img src="{{ asset('assets/images/gift_cards/1.png') }}" alt="" class="w-full h-full">
            <div class="absolute top-2.5 right-2.5">
                <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
            </div>
        </div>
    </a>
</div>
