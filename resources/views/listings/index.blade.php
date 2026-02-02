<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listings
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @can('create', App\Models\Listing::class)
            <div class="mb-6 flex gap-3">
                <a href="{{ route('listings.create.solo') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Create Solo Listing
                </a>
                <a href="{{ route('listings.create.project') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
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
                                    <a href="{{ route('listings.show', $listing) }}" class="text-blue-600 hover:text-blue-900">View</a>

                                    @can('update', $listing)
                                        <a href="{{ route('listings.edit', $listing) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan

                                    @can('delete', $listing)
                                        <form method="POST" action="{{ route('listings.destroy', $listing) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
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
</x-app-layout>
