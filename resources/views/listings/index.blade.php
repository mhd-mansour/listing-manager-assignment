<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('create', App\Models\Listing::class)
                <div class="mb-6 flex gap-3">
                    <x-primary-button onclick="window.location='{{ route('listings.create.solo') }}'">
                        {{ __('Solo Listing') }}
                    </x-primary-button>
                    <x-secondary-button onclick="window.location='{{ route('listings.create.project') }}'">
                        {{ __('Project Listing') }}
                    </x-secondary-button>
                </div>
            @endcan

            <div class="bg-white shadow sm:rounded-lg">
                @if($listings->count() > 0)
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($listings as $listing)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <img src="{{ asset('storage/'.$listing->thumbnail) }}" class="h-12 w-12 object-cover rounded-lg">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $listing->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($listing->description, 40) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $listing->type === 'solo' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($listing->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($listing->type === 'solo')
                                                <div>{{ $listing->rooms }} rooms, {{ $listing->bathrooms }} baths</div>
                                                <div>{{ number_format($listing->space) }} sq ft</div>
                                            @else
                                                <div>{{ $listing->units }} {{ Str::plural('unit', $listing->units) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <x-secondary-button onclick="window.location='{{ route('listings.show', $listing) }}'" class="text-xs py-1 px-2">
                                                    {{ __('View') }}
                                                </x-secondary-button>

                                                @can('update', $listing)
                                                    <x-primary-button onclick="window.location='{{ route('listings.edit', $listing) }}'" class="text-xs py-1 px-2">
                                                        {{ __('Edit') }}
                                                    </x-primary-button>
                                                @endcan

                                                @can('delete', $listing)
                                                    <x-danger-button 
                                                        x-data="" 
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-listing-deletion-{{ $listing->id }}')"
                                                        class="text-xs py-1 px-2"
                                                    >
                                                        {{ __('Delete') }}
                                                    </x-danger-button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No listings</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first property listing.</p>
                        @can('create', App\Models\Listing::class)
                            <div class="mt-6">
                                <x-primary-button onclick="window.location='{{ route('listings.create.solo') }}'">
                                    {{ __('Create Solo Listing') }}
                                </x-primary-button>
                            </div>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>

    @foreach($listings as $listing)
        @can('delete', $listing)
            <x-modal name="confirm-listing-deletion-{{ $listing->id }}" focusable>
                <form method="post" action="{{ route('listings.destroy', $listing) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete this listing?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once this listing is deleted, all of its data will be permanently deleted.') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('Delete Listing') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        @endcan
    @endforeach
</x-app-layout>