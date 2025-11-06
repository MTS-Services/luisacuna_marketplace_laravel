<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="p-6 bg-white rounded-xl shadow-md max-w-3xl mx-auto">
    <form wire:submit.prevent="save" class="space-y-5">

        <x-input label="Sort Order" type="number" wire:model="sort_order" placeholder="0" />
        <x-input label="Key" type="text" wire:model="key" placeholder="unique key name" />
        <x-input label="Name" type="text" wire:model="name" placeholder="Email Template Name" />
        <x-input label="Subject" type="text" wire:model="subject" placeholder="Email Subject" />
        <x-textarea label="Variables" wire:model="variables" placeholder="e.g. {name}, {email}" />

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

</div>
