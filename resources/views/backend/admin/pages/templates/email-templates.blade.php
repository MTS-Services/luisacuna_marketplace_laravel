

<x-admin::app>
    <x-slot name="pageSlug">email-templates</x-slot>


    @switch(Route::currentRouteName())

        {{-- Create --}}
        @case('admin.email_templates.create')
            <x-slot name="breadcrumb">Application Settings > Email Template Create</x-slot>
            <x-slot name="title">Create Email Template</x-slot>
            <livewire:backend.admin.email-templates.create />
        @break

        {{-- Edit --}}
        @case('admin.email_templates.edit')
            <x-slot name="breadcrumb">Application Settings > Email Template Edit</x-slot>
            <x-slot name="title">Edit Email Template</x-slot>
            <livewire:backend.admin.email-templates.edit :id="$id" />
        @break

        {{-- Trash --}}
        @case('admin.email_templates.trash')
            <x-slot name="breadcrumb">Application Settings > Email Template Trash</x-slot>
            <x-slot name="title">Trashed Email Templates</x-slot>
            <livewire:backend.admin.email-templates.trash />
        @break

        {{-- Show --}}
        @case('admin.email_templates.show')
            <x-slot name="breadcrumb">Application Settings > Email Template Details</x-slot>
            <x-slot name="title">Email Template Details</x-slot>
            <livewire:backend.admin.email-templates.show :id="$id" />
        @break

        {{--  Default (Index) --}}
        @default
            <x-slot name="breadcrumb">Application Settings > Email Template List</x-slot>
            <x-slot name="title">Email Template List</x-slot>
            <livewire:backend.admin.email-templates.index />
        @break

    @endswitch

</x-admin::app>
