<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div class="p-6 bg-zinc-600 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">View Email Template</h2>
        <a href="{{ route('admin.email_templates.index') }}" class="text-blue-600 hover:underline">
            ← Back to List
        </a>
    </div>

    <div class="space-y-4">
        <div>
            <h3 class="text-sm text-gray-500">Template Name</h3>
            <p class="text-lg font-medium text-gray-800">{{ $template->name }}</p>

        </div>

        <div>
            <h3 class="text-sm text-gray-500">Subject</h3>
            <p class="text-lg font-medium text-gray-800">{{ $template->subject }}</p>
        </div>

        <div>
            <h3 class="text-sm text-gray-500">Body</h3>
            <div class="p-4 border rounded bg-gray-50 text-gray-700">
                {!! $template->body !!}
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.email_templates.edit', $template->id) }}"

               class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                ✏️ Edit
            </a>
           
            <a href="{{ route('admin.email_templates.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Back
            </a>
        </div>
    </div>
</div>


</div>
