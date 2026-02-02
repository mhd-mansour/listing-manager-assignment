<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $listing->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Listings', 'url' => route('listings.index')],
            ['label' => $listing->title]
        ]" />
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $listing->title }}</h1>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $listing->type === 'solo' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($listing->type) }} Listing
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        @can('update', $listing)
                            <a href="{{ route('listings.edit', $listing) }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $listing)
                            <button type="button" onclick="showDeleteModal()" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Delete
                            </button>
                            <form id="deleteForm" method="POST" action="{{ route('listings.destroy', $listing) }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Thumbnail -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Thumbnail</h3>
                        <img src="{{ asset('storage/'.$listing->thumbnail) }}" alt="{{ $listing->title }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                    </div>

                    <!-- Details -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Details</h3>
                        <dl class="space-y-4">
                            @if($listing->description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $listing->description }}</dd>
                                </div>
                            @endif

                            @if($listing->type === 'solo')
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Number of Rooms</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $listing->rooms }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Number of Bathrooms</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $listing->bathrooms }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Space</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $listing->space }} sq ft</dd>
                                </div>
                            @else
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Number of Units</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $listing->units }}</dd>
                                </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $listing->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                <a href="{{ route('listings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    ← Back to Listings
                </a>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Listing</h3>
                <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete "{{ $listing->title }}"? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="document.getElementById('deleteForm').submit()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>