<x-admin::app>
    <x-slot name="pageSlug">game-management</x-slot>
   
    @switch(Route::currentRouteName())
        @case('admin.gm.game.create')        
            <x-slot name="title">Game Create</x-slot>
            <x-slot name="breadcrumb">Game Management / Game Create</x-slot>
            <livewire:backend.admin.components.game-management.game.create />
        @break 
         @case('admin.gm.game.view')        
            <x-slot name="title">Game View</x-slot>
            <x-slot name="breadcrumb">Game Management / Game View</x-slot>
            <livewire:backend.admin.components.game-management.game.show :data="$data" />
        @break 
         @case('admin.gm.game.edit')        
            <x-slot name="title">Game Edit</x-slot>
            <x-slot name="breadcrumb">Game Management / Game Edit</x-slot>
            <livewire:backend.admin.components.game-management.game.edit :data="$data" />
        @break 
        
         @case('admin.gm.game.trash')        
                 <x-slot name="title">Game Trash List</x-slot>
             <x-slot name="breadcrumb">Game Management / Game Trash List</x-slot>
            <livewire:backend.admin.components.game-management.game.trash />
        @break 

        @default
            <x-slot name="title">Game List</x-slot>
             <x-slot name="breadcrumb">Game Management / Game List</x-slot>
            <livewire:backend.admin.components.game-management.game.index />
    @endswitch

</x-admin::app>
