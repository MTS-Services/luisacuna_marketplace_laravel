<div>
    {{-- Because she competes with no one, no one can compete with her. --}}




<div class="p-6 bg-white rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Favorites List</h2>
        <a 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
           + Add Favorite
        </a>
    </div>

  
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
      
        </div>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">#</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">User</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">Type</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">Favorable ID</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">Sort Order</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
             
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">fdfg</td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2 space-x-2">
                            <a"
                               class="text-blue-600 hover:underline">View</a>
                            <a 
                               class="text-yellow-600 hover:underline">Edit</a>
                            <form action="" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
    
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                            No favorites found.
                        </td>
                    </tr>
       
            </tbody>
        </table>
    </div>
</div>


</div>
