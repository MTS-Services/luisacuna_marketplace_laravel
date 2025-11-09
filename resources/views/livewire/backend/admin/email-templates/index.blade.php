<div>

    {{-- In work, do what you enjoy. --}}

    <div class="container mx-auto ">
        <div class="p-6 bg-zinc-600 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Email Templates</h2>
                <a href="{{ route('admin.email_templates.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Create New
                </a>


            </div>

            @if (session()->has('message'))
                <div class="p-3 mb-4 bg-green-100 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Subject</th>
                        <th class="p-2 border">Created</th>
                        <th class="p-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $template->name }}</td>
                            <td class="p-2 border">{{ $template->subject }}</td>
                            <td class="p-2 border">{{ $template->created_at->diffForHumans() }}</td>
                            <td class="p-2 border text-center space-x-3">
                                <a href="{{ route('admin.email_templates.show', $template->id) }}"
                                    class="text-blue-600">View</a>
                                <a href="{{ route('admin.email_templates.edit', $template->id) }}"
                                    class="text-yellow-600">Edit</a>
                                <button wire:click="delete({{ $template->id }})" class="text-red-600">Trash</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">No templates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <div class="mt-4 text-right">
                <a href="{{ route('admin.email_templates.trash') }}" class="text-gray-600 hover:text-black">
                    🗑 View Trash
                </a>
            </div>
           
        </div>

    </div>
