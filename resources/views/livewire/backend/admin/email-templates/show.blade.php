<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div class="p-6 bg-white rounded-xl shadow-md max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">{{ $template->name }}</h2>
    <div class="space-y-2">
        <p><strong>Key:</strong> {{ $template->key }}</p>
        <p><strong>Subject:</strong> {{ $template->subject }}</p>
        <p><strong>Variables:</strong> {{ $template->variables }}</p>
    </div>
    <div class="mt-4">
        <a href="{{ route('email_templates.edit', $template->id) }}" class="btn btn-sm btn-primary">Edit</a>
    </div>
</div>


</div>
