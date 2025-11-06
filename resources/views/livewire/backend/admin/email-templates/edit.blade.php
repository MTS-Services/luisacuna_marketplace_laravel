<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="p-6 bg-white rounded-xl shadow-md max-w-3xl mx-auto">
    <form wire:submit.prevent="update" class="space-y-5">
        <x-input label="Key" type="text" wire:model="key" />
        <x-input label="Name" type="text" wire:model="name" />
        <x-input label="Subject" type="text" wire:model="subject" />
        <x-textarea label="Variables" wire:model="variables" />
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

</div>

