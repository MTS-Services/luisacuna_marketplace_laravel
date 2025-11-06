
<X-admin::app>
    <x-slot name="pageslug">favorite-favorite</x-slot>

    @switch(Route::currentRouteName())


        @case('favorite_favorite.index')
       
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Edit Email Template</x-slot>
            <livewire:backend.admin.favorite.edit :data="$id" />
        @break




        @case('favorite_favorite.show')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Email Template Details</x-slot>
            <livewire:backend.admin.favorite.show :id="$id" />
        @break

        @default
            <x-slot name="breadcrumb">Application Settings > Currency List</x-slot>
            <x-slot name="title">Currency List</x-slot>
            <livewire:backend.admin.favorite.index />
            @break
    @endswitch
</X-admin::app>


