<x-admin::app>
    <div>
        <x-slot name="title">{{ __('Withdrawal Requests') }}</x-slot>
        <x-slot name="pageSlug">{{ __('withdrawal-request') }}</x-slot>
        @switch(Route::currentRouteName())
            @case('admin.wm.request.view')
                <x-slot name="breadcrumb">{{ __('Withdrawal Management / Withdrawal Request Details') }}</x-slot>
                <livewire:backend.admin.withdrawal-management.withdrawal-request.show :data="$data" />
            @break

            @default
                <x-slot name="breadcrumb">{{ __('Withdrawal Management / Withdrawal Requests') }}</x-slot>
                <livewire:backend.admin.withdrawal-management.withdrawal-request.index />
        @endswitch
    </div>
</x-admin::app>
