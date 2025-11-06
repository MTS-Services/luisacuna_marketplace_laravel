<div>

    {{-- In work, do what you enjoy. --}}


<div class="p-6 bg-white rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Email Templates</h2>
        <a href="{{ route('email_templates.create') }}" class="btn btn-primary">+ New Template</a>
    </div>

    <table class="table w-full">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th>#</th>
                <th>Name</th>
                <th>Key</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templates as $template)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->key }}</td>
                    <td>{{ $template->subject }}</td>
                    <td class="space-x-2">
                        <a href="{{ route('email_templates.show', $template->id) }}" class="text-blue-600">View</a>
                        <a href="{{ route('email_templates.edit', $template->id) }}" class="text-green-600">Edit</a>
                        <button wire:click="delete({{ $template->id }})" class="text-red-600">Trash</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-3">No templates found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>




</div>



