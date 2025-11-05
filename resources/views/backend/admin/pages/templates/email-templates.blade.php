<X-admin::app>
    <x-slot name="pageslug">email-templates</x-slot>

    @switch(Route::currentRouteName())
        @case('email_templates.create')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Create Email Template</x-slot>
            <livewire:backend.admin.templates.email-templates.create />
        @break

        @case('email_templates.edit')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Edit Email Template</x-slot>
            <livewire:backend.admin.templates.email-templates.edit :data="$id" />
        @break


        @case('email_templates.index')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Email Templates</x-slot>
            <livewire:backend.admin.email-templates.index/>
        @break

        @case('email_templates.show')
            <x-slot name="breadcrumb">Email Templates</x-slot>
            <x-slot name="title">Email Template Details</x-slot>
            <livewire:backend.admin.email-templates.show :id="$id" />
        @break

        @default
            <x-slot name="breadcrumb">Application Settings > Currency List</x-slot>
            <x-slot name="title">Currency List</x-slot>
            <livewire:backend.admin.components.settings.currency.index />
            @break
    @endswitch
</X-admin::app>
