<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    @extends('backend.admin.layouts.master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Favorite Details</h2>

    <div class="space-y-4">
        <div>
            <p class="text-gray-500 text-sm">User</p>
            <p class="text-gray-800 font-medium">{{ $favorite->user->name ?? 'N/A' }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Favorable Type</p>
            <p class="text-gray-800 font-medium">{{ $favorite->favorable_type }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Favorable ID</p>
            <p class="text-gray-800 font-medium">{{ $favorite->favorable_id }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Sort Order</p>
            <p class="text-gray-800 font-medium">{{ $favorite->sort_order }}</p>
        </div>

        <div>
            <p class="text-gray-500 text-sm">Created At</p>
            <p class="text-gray-800 font-medium">{{ $favorite->created_at->format('d M, Y h:i A') }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('favorite.index') }}"
           class="text-gray-600 hover:text-gray-800">
           ← Back to List
        </a>
        <a href="{{ route('favorite.edit', $favorite->id) }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
           Edit Favorite
        </a>
    </div>
</div>
@endsection

</div>
