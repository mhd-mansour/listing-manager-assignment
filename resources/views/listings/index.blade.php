<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listings
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Listings']
        ]" />
        
        @can('create', App\Models\Listing::class)
            <div class="mb-6 flex gap-3">
                <a href="{{ route('listings.create.solo') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium">
                    Create Solo Listing
                </a>
                <a href="{{ route('listings.create.project') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                    Create Project Listing
                </a>
            </div>
        @endcan

        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if($listings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($listings as $listing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ asset('storage/'.$listing->thumbnail) }}" class="w-16 h-16 object-cover rounded-md">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $listing->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $listing->type === 'solo' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($listing->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('listings.show', $listing) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                                        View
                                    </a>

                                    @can('update', $listing)
                                        <a href="{{ route('listings.edit', $listing) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete', $listing)
                                        <button type="button" onclick="showDeleteModal({{ $listing->id }}, '{{ $listing->title }}')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                            Delete
                                        </button>
                                        <form id="delete-form-{{ $listing->id }}" method="POST" action="{{ route('listings.destroy', $listing) }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No listings found.</p>
                    @can('create', App\Models\Listing::class)
                        <div class="mt-4">
                            <a href="{{ route('listings.create.solo') }}" class="text-blue-600 hover:text-blue-800">Create your first listing</a>
                        </div>
                    @endcan
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Listing</h3>
                <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete "<span id="listingTitle"></span>"? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteForm = null;
        
        function showDeleteModal(id, title) {
            document.getElementById('listingTitle').textContent = title;
            currentDeleteForm = document.getElementById('delete-form-' + id);
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteForm = null;
        }
        
        function confirmDelete() {
            if (currentDeleteForm) {
                currentDeleteForm.submit();
            }
        }
    </script>
</x-app-layout>
