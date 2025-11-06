<div>
    {{-- Be like water. --}}
  <div class="p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-semibold mb-4">Trashed Email Templates</h2>

    <table class="table w-full">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th>#</th>
                <th>Name</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trashed as $template)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->deleted_at->diffForHumans() }}</td>
                    <td class="space-x-3">
                        <button wire:click="restore({{ $template->id }})" class="text-green-600">Restore</button>
                        <button wire:click="deletePermanently({{ $template->id }})" class="text-red-600">Delete Permanently</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-gray-500">No trashed templates</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
