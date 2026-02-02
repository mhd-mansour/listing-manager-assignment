<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-medium text-gray-700">Total Listings</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ App\Models\Listing::count() }}</p>
                </div>
                
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-medium text-gray-700">Solo Properties</h3>
                    <p class="text-2xl font-bold text-green-600">{{ App\Models\Listing::where('type', 'solo')->count() }}</p>
                </div>
                
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-medium text-gray-700">Project Properties</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ App\Models\Listing::where('type', 'project')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
