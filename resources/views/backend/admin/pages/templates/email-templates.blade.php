<X-admin::app>
    <x-slot name="pageslug">email-templates</x-slot>

    @switch(Route::currentRouteName())

        {{-- Create --}}
        @case('email_templates.create')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Create Email Template</x-slot>
            <livewire:backend.admin.email-templates.create />
        @break

        {{-- Edit --}}
        @case('email_templates.edit')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Edit Email Template</x-slot>
            <livewire:backend.admin.email-templates.edit :id="$id" />
        @break

        {{-- Trash --}}
        @case('email_templates.trash')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Trashed Email Templates</x-slot>
            <livewire:backend.admin.email-templates.trash />
        @break

        {{-- Show --}}
        @case('email_templates.show')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Email Template Details</x-slot>
            <livewire:backend.admin.email-templates.show :id="$id" />
        @break

        {{-- Index --}}
        @default
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Email Template List</x-slot>
            <livewire:backend.admin.email-templates.index />
        @break

    @endswitch
</X-admin::app>
