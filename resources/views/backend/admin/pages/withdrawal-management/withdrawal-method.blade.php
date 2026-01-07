<x-admin::app>
    <div>
     <x-slot name="title">{{ __('Withdrawal Method List') }}</x-slot>
    <x-slot name="pageSlug">{{ __('withdrawal-method') }}</x-slot>
    @switch(Route::currentRouteName())
       
        @case('admin.wm.method.edit')
       
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method Edit') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.withdrawal-method.edit :data="$data" />
        @break;
        @case('admin.wm.method.view')
       
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method View') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.withdrawal-method.show :data="$data" />
        @break;
        @case('admin.wm.method.create')
       
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method Create') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.withdrawal-method.create  />
        @break;
        
        @default
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method List') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.withdrawal-method.index />
            
    @endswitch
</div>

</x-admin::app>