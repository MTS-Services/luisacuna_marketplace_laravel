@props(['title', 'expanded' => true])

{{-- <div class="pt-4 pb-2">
    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest opacity-80"
        x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">{{ __($title) }}
    </p>
</div> --}}
<div class="pt-4 pb-2">
    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest opacity-80"
        x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">{{ __($title) }}
    </p>
    @if ($expanded)
        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest opacity-80 text-center"
            x-show="desktop && !sidebar_expanded">...</p>
    @endif
</div>
