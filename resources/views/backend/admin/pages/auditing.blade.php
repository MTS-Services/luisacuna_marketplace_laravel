<x-admin::app>
    <x-slot name="pageSlug">auditing</x-slot>

    @switch(Route::currentRouteName())

        @case('admin.auditing.view')
            <x-slot name="title">Auditing Log Details</x-slot>
            <x-slot name="breadcrumb">Auditing Log > Details </x-slot>
            <livewire:backend.admin.audit-log-management.view :data="$data"/>
        @break

        @default
            <x-slot name="title">Auditing Log List</x-slot>
            <x-slot name="breadcrumb">Auditing Log > List</x-slot>
            <livewire:backend.admin.audit-log-management.index />
    @endswitch

</x-admin::app>