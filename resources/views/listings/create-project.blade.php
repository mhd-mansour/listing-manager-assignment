<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Project Listing
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="project">
                
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
                            <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Number of Units *</label>
                            <input type="number" name="units" value="{{ old('units', 1) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            @error('units') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div id="gallery-tab" class="tab-content p-6 hidden">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Thumbnail *</label>
                        <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <p class="text-sm text-gray-500 mt-1">Maximum file size: 5MB</p>
                        @error('thumbnail') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <a href="{{ route('listings.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="button" id="nextBtn" onclick="switchToGallery()" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        Next
                    </button>
                    <button type="submit" id="submitBtn" class="hidden px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                        Create Listing
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchToGallery() {
            document.querySelector('[data-tab="gallery"]').click();
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
                
                // Update buttons
                if (tab === 'gallery') {
                    document.getElementById('nextBtn').classList.add('hidden');
                    document.getElementById('submitBtn').classList.remove('hidden');
                } else {
                    document.getElementById('nextBtn').classList.remove('hidden');
                    document.getElementById('submitBtn').classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>