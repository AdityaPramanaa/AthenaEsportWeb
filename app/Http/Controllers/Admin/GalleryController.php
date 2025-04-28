<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        $image = $request->file('image');
        $imagePath = $image->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto berhasil ditambahkan ke gallery');
    }

    public function edit(Gallery $gallery)
    {
        $events = Event::orderBy('title')->get();
        return view('admin.galleries.edit', compact('gallery', 'events'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($gallery->image_path);
            
            // Upload gambar baru
            $image = $request->file('image');
            $imagePath = $image->store('galleries', 'public');
            
            $gallery->image_path = $imagePath;
        }

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        // Hapus gambar
        Storage::disk('public')->delete($gallery->image_path);
        
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto berhasil dihapus dari gallery');
    }
} 