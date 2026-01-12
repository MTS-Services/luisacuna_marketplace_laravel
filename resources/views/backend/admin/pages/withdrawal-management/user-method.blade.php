<x-admin::app>
    <div>
     <x-slot name="title">{{ __('User Method List') }}</x-slot>
    <x-slot name="pageSlug">{{ __('user-method') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.wm.user-method.view')
       
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method View') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.user-method.show :data="$data" />
        @break;
        @default
            <x-slot name="breadcrumb">{{ __('Withdrawal Method Management / Withdrawal Method List') }}</x-slot>
            <livewire:backend.admin.withdrawal-management.user-method.index />
            
    @endswitch
</div>

</x-admin::app>