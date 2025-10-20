<x-admin::app>
    <x-slot name="pageSlug">game-management</x-slot>
   
    @switch(Route::currentRouteName())
        @case('admin.gm.game.create')        
            <x-slot name="title">Game Category Create</x-slot>
            <x-slot name="breadcrumb">Game Management / Category Add</x-slot>
            <livewire:backend.admin.components.game-management.category.create />
        @break 

        @default
            <x-slot name="title">Game List</x-slot>
             <x-slot name="breadcrumb">Game Management / Game List</x-slot>
            <livewire:backend.admin.components.game-management.game.index />
    @endswitch

</x-admin::app>
