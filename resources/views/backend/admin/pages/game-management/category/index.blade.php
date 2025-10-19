<x-admin::app>
    <x-slot name="pageSlug">game-management</x-slot>
   
    @switch(Route::currentRouteName())
        @case('admin.gm.category.create')        
            <x-slot name="title">Game Category Create</x-slot>
            <x-slot name="breadcrumb">Game Management / Category Add</x-slot>
            <livewire:backend.admin.components.game-management.category.create />
        @break 
        @case('admin.gm.category.edit')        
            <x-slot name="title">Game Category Edit</x-slot>
            <x-slot name="breadcrumb">Game Management / Category Edit</x-slot>
            <livewire:backend.admin.components.game-management.category.edit  :category="$category"/>
        @break
        @case('admin.gm.category.view')        
            <x-slot name="title">Game Category Edit</x-slot>
            <x-slot name="breadcrumb">Game Management / Category Edit</x-slot>
            <livewire:backend.admin.components.game-management.category.show  :category="$category"/>
        @break

        @case('admin.gm.category.trash')        
            <x-slot name="title">Game Category Trash</x-slot>
            <x-slot name="breadcrumb">Game Management / Category Trash</x-slot>
            <livewire:backend.admin.components.game-management.category.trash />
        @break

        @default
            <x-slot name="title">Category List</x-slot>
             <x-slot name="breadcrumb">Game Management / Category List</x-slot>
            <livewire:backend.admin.components.game-management.category.index />
    @endswitch

</x-admin::app>
