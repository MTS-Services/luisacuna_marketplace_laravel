<header class=" sm:py-4 sm:px-8 lg:py-0 lg:px-2">
    <div class=" text-white lg:px-18 md:px-0">
        <div
            class="container mx-auto flex flex-col md:flex-row gap-4 md:items-center justify-between w-full px-0 sm:px-0 sm:py-6 lg:py-0 lg:px-0 mt-4">
            <!-- Logo -->
            <div class="flex gap-2">
                @if($game->logo && false)
                <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                    <img src="{{ storage_url($game->logo) }}" alt="{{ $game->name}}">
                </div>
                @else
                <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                   <span class="text-xl">
                        {{  substr($game->name, 0, 1) }}
                    </span>
                </div>
                @endif
                <span class="text-xl font-medium">{{ucfirst(str_replace('-', ' ', $game->name))}}</span>
            </div>
            <!-- Navigation Links -->
            <nav
                class="py-2 peer-checked:flex flex-col lg:flex lg:flex-row gap-8  w-full lg:w-auto  lg:bg-transparent border-t  lg:border-none">
             
                @foreach (gameCategories() as $category)
                        <a href="{{ route('game.index', ['gameSlug' => $gameSlug, 'categorySlug' => $category['slug']]) }}" wire:navigate class="navbar_style text-base py-2! {{ $categorySlug == $category['slug'] ? 'active' : 'text-text-primary' }}">{{$category['name']}}</a>
                @endforeach
               
            </nav>
        </div>
    </div>
</header>
