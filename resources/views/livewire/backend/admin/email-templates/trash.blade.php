<div>
    {{-- Be like water. --}}
<div class="max-w-5xl mx-auto bg-zinc-600 p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Trashed Email Templates</h2>

    @if (session()->has('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
        
    @endif

    <table class="table w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Deleted At</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($trashed as $template)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $template->name }}</td>
                    <td class="px-4 py-2">{{ $template->deleted_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 space-x-3">
                        <button
                            wire:click="restore({{ $template->id }})"
                            class="text-green-600 hover:underline">
                            Restore
                        </button>
                        <button
                            wire:click="deletePermanently({{ $template->id }})"
                            class="text-red-600 hover:underline"
                            onclick="return confirm('Are you sure to permanently delete?')">
                            Delete Permanently
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        No trashed templates found 😶
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('admin.email_templates.index') }}" class="text-gray-600 hover:text-gray-900">
            ← Back to Template List
        </a>
    </div>
</div>


</div>
