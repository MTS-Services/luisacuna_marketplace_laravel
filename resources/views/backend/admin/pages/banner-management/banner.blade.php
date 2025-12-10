<x-admin::app>
    <div>
     <x-slot name="title">{{ __('Banner List') }}</x-slot>
    <x-slot name="pageSlug">{{ __('banner-management') }}</x-slot>
    @switch(Route::currentRouteName())
       
        @case('admin.bm.banner.edit')
       
            <x-slot name="breadcrumb">{{ __('Banner Management / Banner Edit') }}</x-slot>
            <livewire:backend.admin.banner-management.banner.edit :data="$data" />
        @break;
        
        @default
            <x-slot name="breadcrumb">{{ __('Banner Management / Banner List') }}</x-slot>
            <livewire:backend.admin.banner-management.banner.index />
            
    @endswitch
</div>

</x-admin::app>