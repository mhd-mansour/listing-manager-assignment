<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ ucfirst($listing->type) }} Listing
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Listings', 'url' => route('listings.index')],
            ['label' => $listing->title, 'url' => route('listings.show', $listing)],
            ['label' => 'Edit']
        ]" />
        
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex">
                        <button type="button" class="tab-btn active px-6 py-3 text-sm font-medium border-b-2 border-blue-500 text-blue-600" data-tab="general">
                            General Information
                        </button>
                        <button type="button" class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" data-tab="gallery">
                            Gallery
                        </button>
                    </nav>
                </div>

                <!-- General Information Tab -->
                <div id="general-tab" class="tab-content p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $listing->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $listing->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if($listing->type === 'solo')
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Number of Rooms *</label>
                                    <input type="number" name="rooms" value="{{ old('rooms', $listing->rooms) }}" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('rooms') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Number of Bathrooms *</label>
                                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms) }}" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('bathrooms') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Space (sq ft) *</label>
                                    <input type="number" name="space" value="{{ old('space', $listing->space) }}" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('space') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Units *</label>
                                <input type="number" name="units" value="{{ old('units', $listing->units) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                @error('units') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div id="gallery-tab" class="tab-content p-6 hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Thumbnail</label>
                            <img src="{{ asset('storage/'.$listing->thumbnail) }}" class="w-32 h-32 object-cover rounded-md">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Thumbnail (optional)</label>
                            <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="previewImage(this)">
                            <p class="text-sm text-gray-500 mt-1">Maximum file size: 5MB. Leave empty to keep current thumbnail.</p>
                            @error('thumbnail') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            <div id="preview" class="mt-3 hidden">
                                <img id="preview-img" class="w-32 h-32 object-cover rounded border">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <a href="{{ route('listings.show', $listing) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        Update Listing
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('preview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                // Update buttons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                btn.classList.add('active', 'border-blue-500', 'text-blue-600');
                btn.classList.remove('border-transparent', 'text-gray-500');
                
                // Update content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(tab + '-tab').classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>