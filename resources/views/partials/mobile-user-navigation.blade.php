{{-- <div class="space-y-1">
    <a href="{{ route('currency') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Currency</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('currency') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Gift Card</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('boosting') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Boosting</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('items') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Items</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('accounts') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Accounts</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('top-up') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Top Ups</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
    <a href="{{ route('coaching') }}"
        class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300">
        <span>Coaching</span>
        <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
    </a>
</div> --}}

<div class="space-y-1">
    @php
        $links = [
            ['route' => 'currency', 'label' => 'Currency'],
            ['route' => 'gift-card', 'label' => 'Gift Card'],
            ['route' => 'boosting', 'label' => 'Boosting'],
            ['route' => 'items', 'label' => 'Items'],
            ['route' => 'accounts', 'label' => 'Accounts'],
            ['route' => 'top-up', 'label' => 'Top Ups'],
            ['route' => 'coaching', 'label' => 'Coaching'],
        ];
    @endphp

    @foreach ($links as $link)
        @php
            $isActive = request()->routeIs($link['route']);
            $bgClass = $isActive ? 'bg-bg-hover hover:bg-bg-hover' : 'bg-bg-info hover:bg-bg-hover';
        @endphp

        <a href="{{ route($link['route']) }}"
            class="flex justify-between items-center p-2 rounded-lg font-medium transition-all duration-300 {{ $bgClass }}">
            <span>{{ $link['label'] }}</span>
            <flux:icon name="chevron-right" class="w-5 h-5 stroke-current {{ $isActive ? 'text-text-primary' : '' }}" />
        </a>
    @endforeach
</div>


{{-- <div class="space-y-1" x-clock>
    @foreach (gameCategories() as $category)
        <button
            x-on:click="open = (open == '{{ $category['slug'] }}' || open == '' || open != '{{ $category['slug'] }}' ? '{{ $category['slug'] }}' : '')" @click="mobileMenuOpen = false;"
            class="flex justify-between items-center bg-bg-secondary p-2 rounded-lg font-medium hover:bg-bg-hover transition-all duration-300 w-full"
            :class="{
                'dark:bg-zinc-800 bg-zinc-100': open == '{{ $category['slug'] }}' ||
                    {{ request()->route('categorySlug') == $category['slug'] ? 'true' : 'false' }}
            }">
            <span>{{ $category['name'] }}</span>
            <flux:icon name="chevron-right" class="w-5 h-5 stroke-current hover:text-text-primary" />
        </button>
    @endforeach
</div> --}}
