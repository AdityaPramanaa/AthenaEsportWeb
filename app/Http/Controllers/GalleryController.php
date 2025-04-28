<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('galleries', compact('galleries'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('galleries.show', compact('gallery'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/galleries', $imageName);
            $validated['image_path'] = 'galleries/' . $imageName;
        }

        Gallery::create($validated);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path) {
                Storage::delete('public/' . $gallery->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/galleries', $imageName);
            $validated['image_path'] = 'galleries/' . $imageName;
        }

        $gallery->update($validated);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::delete('public/' . $gallery->image_path);
        }
        
        $gallery->delete();

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item deleted successfully.');
    }
} 