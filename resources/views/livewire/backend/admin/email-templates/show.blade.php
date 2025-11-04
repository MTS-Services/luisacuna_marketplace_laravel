<div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    @extends('layouts.admin')
    
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Email Template Details</h1>

    <div class="space-y-3">
        <div>
            <strong>ID:</strong> {{ $template->id }}
        </div>
        <div>
            <strong>Key:</strong> {{ $template->key }}
        </div>
        <div>
            <strong>Name:</strong> {{ $template->name }}
        </div>
        <div>
            <strong>Subject:</strong> {{ $template->subject ?? 'N/A' }}
        </div>
        <div>
            <strong>Body:</strong>
            <div class="border p-3 mt-2 bg-gray-50 rounded">
                {!! $template->template !!}
            </div>
        </div>
        <div>
            <strong>Variables:</strong> {{ is_array($template->variables) ? implode(', ', $template->variables) : $template->variables }}
        </div>
        <div class="text-right mt-4">
            <a href="{{ route('admin.email-templates.index') }}" class="btn btn-sm btn-primary">Back to List</a>
        </div>
    </div>
</div>


</div>
