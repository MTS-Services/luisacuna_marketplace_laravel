<x-admin::app>
    <x-slot name="pageSlug">game-management</x-slot>
   

    @switch(Route::currentRouteName())
        @case('admin.gm.category.create')
        
            <x-slot name="title">Admins Create</x-slot>
            <livewire:backend.admin.components.admin-management.admin.create />
        @break

        @default
            <x-slot name="title">Category List</x-slot>
             <x-slot name="breadcrumb">Game Management / Category List</x-slot>
            <livewire:backend.admin.components.game-management.category.index />
    @endswitch

</x-admin::app>
