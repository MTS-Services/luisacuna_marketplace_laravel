<x-admin::app>
    <div>
    <x-slot name="pageSlug">{{ __('banner-management') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.bm.banner.create')
            <x-slot name="title">{{ __('Banner Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Banner Management / Banner Create') }}</x-slot>
            <livewire:backend.admin.banner-management.banner.create />
            @break
    
        @default
            <x-slot name="title">{{ __('Banner List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Banner Management / Banner List') }}</x-slot>
            <livewire:backend.admin.banner-management.banner.index />
            
    @endswitch
</div>

</x-admin::app>