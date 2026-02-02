<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Listing;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Listing::class);
        $listings = Listing::latest()->get();
        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Listing::class);

        $type = $request->input('type');

        if ($type === 'solo') {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'rooms' => 'required|integer|min:0',
                'bathrooms' => 'required|integer|min:0',
                'space' => 'required|integer|min:0',
                'thumbnail' => 'required|image|max:5120', // 5MB
            ]);
        } else { // project
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'units' => 'required|integer|min:1',
                'thumbnail' => 'required|image|max:5120', // 5MB
            ]);
        }

        // Store thumbnail
        $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        $data['type'] = $type;

        Listing::create($data);

        return redirect()->route('listings.index')->with('success', 'Listing created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        return view('listings.edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);
        
        $type = $listing->type;

        if ($type === 'solo') {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'rooms' => 'required|integer|min:0',
                'bathrooms' => 'required|integer|min:0',
                'space' => 'required|integer|min:0',
                'thumbnail' => 'nullable|image|max:5120',
            ]);
        } else {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'units' => 'required|integer|min:1',
                'thumbnail' => 'nullable|image|max:5120',
            ]);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $listing->update($data);

        return redirect()->route('listings.index')->with('success', 'Listing updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        
        $listing->delete();
        
        return redirect()->route('listings.index')->with('success', 'Listing deleted!');
    }

    public function createSolo()
    {
        $this->authorize('create', Listing::class);

        return view('listings.create-solo');
    }

    public function createProject()
    {
        $this->authorize('create', Listing::class);

        return view('listings.create-project');
    }
}
